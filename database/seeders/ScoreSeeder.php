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
        // Get all subjects grouped by major
        $subjects = Subject::all()->groupBy('major');
        
        foreach ($subjects as $major => $subjectList) {
            // Get students for this major
            $students = Student::where('major', $major)->get();
            
            if ($students->isEmpty()) continue;
            
            // For each student, create scores for their major's subjects
            foreach ($students as $student) {
                foreach ($subjectList as $subject) {
                    // Normalize academic year formats for comparison (2025-2026 vs 2025/2026)
                    $studentYear = str_replace('-', '/', $student->academic_year);
                    $subjectYear = str_replace('-', '/', $subject->academic_year);
                    
                    // Only create if academic year matches
                    if ($studentYear !== $subjectYear) {
                        continue;
                    }
                    
                    // Generate realistic scores
                    $attendance = rand(10, 15);  // out of 15
                    $quiz       = rand(12, 20);  // out of 20
                    $midterm    = rand(15, 25);  // out of 25
                    $finalExam  = rand(25, 45);  // out of 45
                    $total      = $attendance + $quiz + $midterm + $finalExam;
                    
                    Score::create([
                        'student_id'  => $student->id,
                        'subject_id'  => $subject->id,
                        'attendance'  => $attendance,
                        'quiz'        => $quiz,
                        'midterm'     => $midterm,
                        'final_exam'  => $finalExam,
                        'total_score' => $total,
                    ]);
                }
            }
        }
    }
}
