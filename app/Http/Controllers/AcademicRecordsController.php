<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

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
        $request->validate([
            'file'          => 'required|file|mimes:csv,txt',
            'subject_id'    => 'required|exists:subjects,id',
            'academic_year' => 'required|string',
            'semester'      => 'required|string',
        ]);

        $rows    = array_map('str_getcsv', file($request->file('file')->getRealPath()));
        $headers = array_shift($rows); // [student_code, attendance, quiz, midterm, final]

        $subject = Subject::findOrFail($request->subject_id);

        foreach ($rows as $row) {
            if (empty($row[0])) continue;

            $student = Student::where('student_code', trim($row[0]))->first();
            if (!$student) continue;

            $attendance = isset($row[1]) && $row[1] !== '' ? (float) $row[1] : 0;
            $quiz       = isset($row[2]) && $row[2] !== '' ? (float) $row[2] : 0;
            $midterm    = isset($row[3]) && $row[3] !== '' ? (float) $row[3] : 0;
            $final_exam = isset($row[4]) && $row[4] !== '' ? (float) $row[4] : 0;

            // Auto calculate total score
            $total_score = $attendance + $quiz + $midterm + $final_exam;

            Score::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                ],
                [
                    'attendance'  => $attendance,
                    'quiz'        => $quiz,
                    'midterm'     => $midterm,
                    'final_exam'  => $final_exam,
                    'total_score' => $total_score,
                ]
            );
        }

        return redirect()->route('academicrecords.index')
                         ->with('success', count($rows) . ' student scores imported successfully.');
    }

    public function academicrecordsshow($id)
    {
        $student = Student::findOrFail($id);
        $scores  = $student->scores()->with('subject')->get();

        return view('academicrecords.show', compact('student', 'scores'));
    }
}