<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Score;
use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = Subject::all()->groupBy('major');

        foreach ($subjects as $major => $subjectList) {
            $students = Student::where('major', $major)->get();

            if ($students->isEmpty()) continue;

            foreach ($students as $student) {
                foreach ($subjectList as $subject) {
                    $exists = Score::where('student_id', $student->id)
                                   ->where('subject_id', $subject->id)
                                   ->exists();

                    if ($exists) continue;

                    // Random scores based on your specific weight limits
                    $attendance = rand(7, 10);    // Max 10
                    $quiz       = rand(12, 20);   // Max 20
                    $midterm    = rand(12, 20);   // Max 20
                    $finalExam  = rand(30, 50);   // Max 50

                    // The sum of these maximums (10+20+20+50) is exactly 100
                    $calculatedTotal = $attendance + $quiz + $midterm + $finalExam;

                    // Apply the 100 limit cap for safety
                    $totalScore = min($calculatedTotal, 100);

                    Score::create([
                        'student_id'  => $student->id,
                        'subject_id'  => $subject->id,
                        'attendance'  => $attendance,
                        'quiz'        => $quiz,
                        'midterm'     => $midterm,
                        'final_exam'  => $finalExam,
                        'total_score' => $totalScore,
                    ]);
                }
            }
        }
    }
}