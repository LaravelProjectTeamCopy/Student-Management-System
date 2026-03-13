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
            'major' => $row['major'],
            // ← no joined_at
        ]);
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string',
            'email' => 'required|email|unique:students,email',
            'major' => 'required|string',
        ];
    }
}