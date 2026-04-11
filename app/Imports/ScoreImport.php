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

    // 1. Pre-load lookups to avoid N+1
    protected $students;
    protected $subjects;

    public function __construct()
    {
        $this->students = Student::pluck('id', 'student_code');
        $this->subjects = Subject::pluck('id', 'subject_code');
    }

    // 2. Chunk size for large files
    public function chunkSize(): int
    {
        return 500;
    }

    // 3. Validation — runs before model()
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

    // 4. Model — only runs if validation passes
    public function model(array $row)
    {
        $student = Student::where('student_code', trim($row['student_code']))->first();
        
        if (!$student) {
            Log::warning('Student not found', ['student_code' => $row['student_code']]);
            return null;
        }
        
        $studentId = $student->id;

        // Find subject using student's major and academic_year
        $subject = Subject::where('subject_code', trim($row['subject_code']))
            ->where('major', $student->major)
            ->where('academic_year', $student->academic_year)
            ->first();

        $subjectId = $subject?->id;

        if (!$studentId || !$subjectId) {
            Log::warning('ScoreImport: subject not found', [
                'student_code' => $row['student_code'],
                'subject_code' => $row['subject_code'],
            ]);
            return null;
        }

        $attendance = (float)($row['attendance'] ?? 0);
        $quiz       = (float)($row['quiz'] ?? 0);
        $midterm    = (float)($row['midterm'] ?? 0);
        $finalExam  = (float)($row['final_exam'] ?? 0);

        return Score::updateOrCreate(
            ['student_id' => $studentId, 'subject_id' => $subjectId],
            ['attendance' => $attendance, 'quiz' => $quiz, 'midterm' => $midterm, 'final_exam' => $finalExam, 'total_score' => $attendance + $quiz + $midterm + $finalExam]
        );
    }
}