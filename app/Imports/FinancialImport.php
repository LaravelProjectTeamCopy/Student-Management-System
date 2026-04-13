<?php

namespace App\Imports;

use App\Models\Financial;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FinancialImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $student = Student::where('email', $row['email'])->first();

        return new Financial([
            'student_id'        => $student->id,
            'total_fees'        => $row['total_fees'],
            'amount_paid'       => $row['amount_paid'],
            'balance_remaining' => $row['total_fees'] - $row['amount_paid'],
            'payment_status'    => $row['payment_status'],
            'payment_date'      => $row['payment_date'],
        ]);
    }

    public function rules(): array
    {
        return [
            'email'          => 'required|email|exists:students,email',
            'total_fees'     => 'required|numeric',
            'amount_paid'    => 'required|numeric',
            'payment_status' => 'required|string',
            'payment_date'   => 'required|date',
        ];
    }
}