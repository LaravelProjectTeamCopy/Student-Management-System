<?php

namespace App\Imports;

use App\Models\Student;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Student([
            'name'  => $row['name'],
            'email' => $row['email'],
            'date_of_birth' => $row['date_of_birth'],
            'gender' => $row['gender'],
            'address' => $row['address'],
            'major' => $row['major'],
            'academic_year' => $row['academic_year'],
        ]);
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string',
            'email' => 'required|email|unique:students,email',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'major' => 'required|string',
            'academic_year' => 'nullable|string',
        ];
    }
}