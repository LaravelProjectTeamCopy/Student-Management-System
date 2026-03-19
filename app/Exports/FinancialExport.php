<?php

namespace App\Exports;

use App\Models\Financial;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FinancialExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Financial::with('student')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Student Name', 'Email', 'Major', 'Total Fees', 'Amount Paid', 'Balance Remaining', 'Payment Status', 'Payment Date'];
    }

    public function map($financial): array
    {
        return [
            $financial->id,
            $financial->student->name,
            $financial->student->email,
            $financial->student->major,
            $financial->total_fees,
            $financial->amount_paid,
            $financial->balance_remaining,
            $financial->payment_status,
            $financial->payment_date ? $financial->payment_date->format('Y-m-d') : '—',
        ];
    }
}