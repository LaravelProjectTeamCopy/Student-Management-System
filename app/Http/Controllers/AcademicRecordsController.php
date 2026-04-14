<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Financial;
use App\Models\PaymentLog;
use App\Models\SystemHistory;
use Illuminate\Http\Request;
use App\Imports\ScoreImport;
use App\Exports\AcademicRecordExport;
use Maatwebsite\Excel\Facades\Excel;

class AcademicRecordsController extends Controller
{
    public function academicrecordsindex()
    {
        $majors       = Student::distinct()->pluck('major');
        $currentMajor = request('major', $majors->first() ?? 'Arts');
        $currentYear  = request('year', '');
        $currentSem   = request('semester', 'Semester 1');

        $subjects = Subject::where('major', $currentMajor)
                        ->when($currentYear, fn($q) => $q->where('academic_year', $currentYear))
                        ->where('semester', $currentSem)
                        ->get();

        $allStudentsInMajor = Student::where('major', $currentMajor)
                                ->with(['scores' => function ($q) use ($subjects) {
                                    $q->whereIn('subject_id', $subjects->pluck('id'));
                                }])
                                ->get();

        // 1. CLASS AVERAGE: Now accurate because total_score is capped at 100
        // We round this to 1 decimal place for a cleaner dashboard look
        $classAvg = $allStudentsInMajor
                        ->flatMap(fn($s) => $s->scores ?? collect())
                        ->avg('total_score') ?? 0;
        $classAvg = round($classAvg, 1); 

        $passedCount   = 0;
        $atRisk        = 0;
        $totalStudents = $allStudentsInMajor->count();

        foreach ($allStudentsInMajor as $student) {
            $studentScores = $student->scores ?? collect();
            
            // Only calculate average if the student actually has scores for this selection
            $studentAvg = $studentScores->count() > 0 ? $studentScores->avg('total_score') : null;

            if ($studentAvg !== null) {
                // 2. PASSING LOGIC: 50 is the standard pass mark for a 100-cap system
                if ($studentAvg >= 50) {
                    $passedCount++;
                } else {
                    $atRisk++;
                }
            }
        }

        $passingRate = $totalStudents > 0 ? round(($passedCount / $totalStudents) * 100) : 0;

        // 3. TOP STUDENT LOGIC: 
        // This will now correctly find the student closest to 100%
        $topStudent = $allStudentsInMajor->sortByDesc(
            fn($s) => ($s->scores ?? collect())->avg('total_score') ?? 0
        )->first();

        $topScore = 0;
        if ($topStudent && ($topStudent->scores ?? collect())->count() > 0) {
            // Capping the top score display at 100 just in case
            $topScore = min(round($topStudent->scores->avg('total_score'), 1), 100);
        }

        $academicrecords = Student::where('major', $currentMajor)
                            ->when(request('search'), fn($q) =>
                                $q->where('name', 'like', '%' . request('search') . '%')
                                ->orWhere('student_code', 'like', '%' . request('search') . '%')
                            )
                            ->with(['scores' => function ($q) use ($subjects) {
                                $q->whereIn('subject_id', $subjects->pluck('id'));
                            }])
                            ->paginate(10)
                            ->withQueryString();

        return view('academicrecords.index', compact(
            'academicrecords',
            'subjects',
            'majors',
            'classAvg',
            'passingRate',
            'passedCount',
            'totalStudents',
            'atRisk',
            'topScore',
            'currentMajor',
            'currentYear',
            'currentSem'
        ));
    }
    public function showacademicrecordsimport()
    {
        $subjects = Subject::orderBy('major')->orderBy('name')->get();
        $majors   = Student::distinct()->pluck('major');

        return view('academicrecords.import', compact('subjects', 'majors'));
    }

    public function academicrecordimport(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx']);

        $import = new ScoreImport;
        Excel::import($import, $request->file('file'));

        $failures     = $import->failures();
        $failureCount = count($failures);

        SystemHistory::log(
            'Imported Academic Scores',
            'Academic',
            "Imported grade sheet from {$request->file('file')->getClientOriginalName()}" .
            ($failureCount > 0 ? " ({$failureCount} rows failed)" : ""),
            'upload_file'
        );

        $this->applyRetakeSurcharges();

        if ($failureCount > 0) {
            $errorMessages = collect($failures)->take(5)->map(function ($failure) {
                return "Row {$failure->row()}: " . implode(', ', $failure->errors());
            })->implode('; ');

            return redirect()->route('academicrecords.index')
                ->with('error', "Import completed with {$failureCount} errors. First errors: {$errorMessages}");
        }

        return redirect()->route('academicrecords.index')
                         ->with('success', 'Import completed successfully. All scores have been recorded.');
    }

    private function applyRetakeSurcharges(): void
    {
        $students = Student::with(['scores.subject'])->get();

        foreach ($students as $student) {
            $financial = Financial::where('student_id', $student->id)->first();

            if (!$financial) continue;

            foreach ($student->scores as $score) {
                $subject = $score->subject;

                if (!$subject) continue;

                if ($score->total_score >= 60) continue;

                $fingerprint = "retake_subject_id:{$subject->id}|year:{$subject->academic_year}|sem:{$subject->semester}";

                $alreadyCharged = PaymentLog::where('student_id', $student->id)
                    ->where('payment_method', 'Surcharge')
                    ->where('note', 'like', "%{$fingerprint}%")
                    ->exists();

                if ($alreadyCharged) continue;

                $surcharge = 20;

                $financial->increment('total_fees', $surcharge);
                $financial->refresh();

                $financial->balance_remaining = $financial->total_fees - $financial->amount_paid;

                if ($financial->amount_paid <= 0) {
                    $financial->payment_status = 'Unpaid';
                } elseif ($financial->balance_remaining <= 0) {
                    $financial->payment_status = 'Paid';
                } else {
                    $financial->payment_status = 'Partial';
                }

                $financial->save();

                PaymentLog::create([
                    'student_id'     => $student->id,
                    'amount_paid'    => 0,
                    'payment_method' => 'Surcharge',
                    'payment_status' => $financial->payment_status,
                    'payment_date'   => now()->toDateString(),
                    'note'           => "Retake exam fee – {$subject->name} (score: {$score->total_score}/100) | {$fingerprint}",
                ]);

                SystemHistory::log(
                    'Retake Exam Surcharge',
                    'Financial',
                    "Charged \${$surcharge} to {$student->name} — failed [{$subject->subject_code}] {$subject->name} (score: {$score->total_score})",
                    'payments'
                );
            }
        }
    }

    public function academicrecordsshow($id)
    {
        $student = Student::findOrFail($id);
        $scores  = $student->scores()->with('subject')->get();

        $currentYear = request('year', '2025/2026');
        $currentSem  = request('semester', 'Semester 1');

        $filteredScores = $scores->filter(function ($score) use ($currentYear, $currentSem) {
            return $score->subject &&
                   $score->subject->academic_year === $currentYear &&
                   $score->subject->semester === $currentSem;
        });

        $avgScore = $filteredScores->count() > 0 ? $filteredScores->avg('total_score') : 0;

        return view('academicrecords.show', compact(
            'student', 'scores', 'filteredScores',
            'avgScore', 'currentYear', 'currentSem'
        ));
    }

    public function showacademicrecordssubject()
    {
        $majors = Student::distinct()->pluck('major');

        return view('academicrecords.subject', compact('majors'));
    }

    public function academicrecordssubject(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'subject_code'  => 'required|string|max:50|unique:subjects,subject_code',
            'major'         => 'required|string',
            'academic_year' => 'required|string',
            'semester'      => 'required|string',
        ]);

        $validated['subject_code'] = str_replace(' ', '-', strtoupper($validated['subject_code']));

        Subject::create($validated);

        SystemHistory::log(
            'Created Subject',
            'Academic',
            "Added subject [{$validated['subject_code']}] {$validated['name']} — {$validated['major']}, {$validated['semester']} {$validated['academic_year']}",
            'book'
        );

        return redirect()->route('academicrecords.index')
                         ->with('success', "Subject [{$validated['subject_code']}] created successfully! You can now import scores for this class.");
    }

    public function academicrecordsexport()
    {
        return view('academicrecords.export');
    }

    public function academicrecordsexportcsv()
    {
        SystemHistory::log(
            'Exported Students',
            'Student',
            'Exported student list to Excel',
            'download'
        );

        return Excel::download(new AcademicRecordExport, 'students_' . now()->format('Y-m-d') . '.xlsx');
    }
}