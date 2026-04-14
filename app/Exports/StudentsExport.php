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
    return ['ID', 'Name', 'Email', 'Date of Birth', 'Gender', 'Address', 'Major', 'Academic Year' , 'Date Joined'];
    }

    public function map($student): array
    {
        return [
            $student->id,
            $student->name,
            $student->email,
            $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '—',
            $student->gender,
            $student->address,
            $student->major,
            $student->academic_year,
            $student->created_at->format('Y-m-d H:i:s'),
        ];
    }
}