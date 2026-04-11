<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Student::all();
    }

    public function headings(): array
    {
    return ['ID', 'Name', 'Email', 'Major', 'Student_Code' , 'Date Joined'];
    }

    public function map($student): array
    {
    return [
        $student->id,
        $student->name,
        $student->email,
        $student->major,
        $student->student_code,
        $student->created_at ? $student->created_at->format('Y-m-d') : '—',
    ];
    }
}