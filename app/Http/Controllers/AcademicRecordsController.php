<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\SystemHistory;
use Illuminate\Http\Request;
use App\Imports\ScoreImport;
use Maatwebsite\Excel\Facades\Excel;

class AcademicRecordsController extends Controller
{
    public function academicrecordsindex()
    {
        $majors       = Student::distinct()->pluck('major');
        $currentMajor = request('major', $majors->first() ?? 'Arts');
        $currentYear  = request('year', '2025/2026');
        $currentSem   = request('semester', 'Semester 1');

        $subjects = Subject::where('major', $currentMajor)
                        ->where('academic_year', $currentYear)
                        ->where('semester', $currentSem)
                        ->get();

        $allStudentsInMajor = Student::where('major', $currentMajor)
                                ->with(['scores' => function ($q) use ($subjects) {
                                    $q->whereIn('subject_id', $subjects->pluck('id'));
                                }])
                                ->get();

        $classAvg = $allStudentsInMajor
                        ->flatMap(fn($s) => $s->scores ?? collect())
                        ->avg('total_score') ?? 0;

        $passedCount   = 0;
        $atRisk        = 0;
        $totalStudents = $allStudentsInMajor->count();

        foreach ($allStudentsInMajor as $student) {
            $studentScores = $student->scores ?? collect();
            $studentAvg    = $studentScores->count() > 0 ? $studentScores->avg('total_score') : null;

            if ($studentAvg !== null) {
                if ($studentAvg >= 50) $passedCount++;
                else $atRisk++;
            }
        }

        $passingRate = $totalStudents > 0 ? round(($passedCount / $totalStudents) * 100) : 0;

        $topStudent = $allStudentsInMajor->sortByDesc(
            fn($s) => ($s->scores ?? collect())->avg('total_score') ?? 0
        )->first();

        $topScore = 0;
        if ($topStudent && ($topStudent->scores ?? collect())->count() > 0) {
            $topScore = round($topStudent->scores->avg('total_score'), 1);
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

        $failures = $import->failures();
        $failureCount = count($failures);

        SystemHistory::log(
            'Imported Academic Scores',
            'Academic',
            "Imported grade sheet from {$request->file('file')->getClientOriginalName()}" . 
            ($failureCount > 0 ? " ({$failureCount} rows failed)" : ""),
            'upload_file'
        );

        if ($failureCount > 0) {
            $errorMessages = collect($failures)->take(5)->map(function($failure) {
                return "Row {$failure->row()}: " . implode(', ', $failure->errors());
            })->implode('; ');
            
            return redirect()->route('academicrecords.index')
                ->with('error', "Import completed with {$failureCount} errors. First errors: {$errorMessages}");
        }

        return redirect()->route('academicrecords.index')
                         ->with('success', 'Import completed successfully. All scores have been recorded.');
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
}