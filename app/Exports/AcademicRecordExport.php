<?php

namespace App\Exports;

use App\Models\Score;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AcademicRecordExport implements FromCollection, WithHeadings, WithMapping
{
    // Exports all academic records across all subjects and majors
    public function collection()
    {
        return Score::with('student', 'subject')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Student Name', 'Email', 'Major', 'Subject', 'Attendance', 'Quiz', 'Midterm', 'Final Exam', 'Total Score'];
    }

    public function map($score): array
    {
        return [
            $score->id,
            $score->student->name,
            $score->student->email,
            $score->student->major,
            $score->subject->name,
            $score->attendance,
            $score->quiz,
            $score->midterm,
            $score->final_exam,
            $score->total_score,
        ];
    }
}
