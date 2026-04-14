<?php
namespace App\Imports;

use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Log;

class ScoreImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithChunkReading
{
    use SkipsFailures;

    public function chunkSize(): int
    {
        return 500;
    }

    public function rules(): array
    {
        return [
            'student_code' => ['required', 'exists:students,student_code'],
            'subject_code' => ['required', 'exists:subjects,subject_code'],
            'attendance'   => ['nullable', 'numeric', 'min:0', 'max:100'],
            'quiz'         => ['nullable', 'numeric', 'min:0', 'max:100'],
            'midterm'      => ['nullable', 'numeric', 'min:0', 'max:100'],
            'final_exam'   => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'student_code.exists' => 'Student code :input does not exist.',
            'subject_code.exists' => 'Subject code :input does not exist.',
            'attendance.max'      => 'Attendance score cannot exceed 100.',
            'quiz.max'            => 'Quiz score cannot exceed 100.',
            'midterm.max'         => 'Midterm score cannot exceed 100.',
            'final_exam.max'      => 'Final exam score cannot exceed 100.',
        ];
    }

    public function model(array $row)
    {
        $student = Student::where('student_code', trim($row['student_code']))->first();

        if (!$student) {
            Log::warning('ScoreImport: student not found', ['student_code' => $row['student_code']]);
            return null;
        }

        $subject = Subject::where('subject_code', trim($row['subject_code']))
                        ->where('major', $student->major)
                        ->where('academic_year', $student->academic_year)
                        ->first();

        if (!$subject) {
            $subject = Subject::where('subject_code', trim($row['subject_code']))->first();
        }

        if (!$subject) {
            Log::warning('ScoreImport: subject not found', [
                'student_code'  => $row['student_code'],
                'subject_code'  => $row['subject_code'],
                'student_major' => $student->major,
                'student_year'  => $student->academic_year,
            ]);
            return null;
        }

        $attendance = (float)($row['attendance'] ?? 0);
        $quiz       = (float)($row['quiz']       ?? 0);
        $midterm    = (float)($row['midterm']    ?? 0);
        $finalExam  = (float)($row['final_exam'] ?? 0);

        // PINPOINT FIX: Apply Weights (10% Attendance, 20% Quiz, 20% Midterm, 50% Final)
        // This ensures a student getting 100 in everything gets exactly 100 total.
        $calculatedScore = ($attendance * 0.10) + ($quiz * 0.20) + ($midterm * 0.20) + ($finalExam * 0.50);

        // Apply the 100 limit cap for safety
        $totalScore = min($calculatedScore, 100);

        return Score::updateOrCreate(
            [
                'student_id' => $student->id,
                'subject_id' => $subject->id,
            ],
            [
                'attendance'  => $attendance,
                'quiz'        => $quiz,
                'midterm'     => $midterm,
                'final_exam'  => $finalExam,
                'total_score' => $totalScore,
            ]
        );
    }
}