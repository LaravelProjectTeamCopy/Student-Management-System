<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AttendanceImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $student = Student::where('email', $row['email'])->first();
        $pct     = $row['total_days'] > 0 ? round(($row['present_days'] / $row['total_days']) * 100) : 0;

        if ($pct >= 75) $status = 'Good';
        elseif ($pct >= 50) $status = 'At Risk';
        else $status = 'Critical';

        return new Attendance([
            'student_id'   => $student->id,
            'total_days'   => $row['total_days'],
            'present_days' => $row['present_days'],
            'absent_days'  => $row['total_days'] - $row['present_days'],
            'status'       => $status,
        ]);
    }

    public function rules(): array
    {
        return [
            'email'        => 'required|email|exists:students,email',
            'total_days'   => 'required|numeric',
            'present_days' => 'required|numeric|lte:total_days',
        ];
    }
}
