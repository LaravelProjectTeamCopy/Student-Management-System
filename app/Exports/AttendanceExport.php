<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Attendance::with('student')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Student Name', 'Email', 'Major', 'Total Days', 'Present Days', 'Absent Days', 'Status'];
    }

    public function map($attendance): array
    {
        return [
            $attendance->id,
            $attendance->student->name,
            $attendance->student->email,
            $attendance->student->major,
            $attendance->total_days,
            $attendance->present_days,
            $attendance->absent_days,
            $attendance->status,
        ];
    }
}