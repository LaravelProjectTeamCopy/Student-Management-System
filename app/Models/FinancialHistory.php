<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialHistory extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'student_id',
        'semester_start',
        'semester_end',
        'total_fees',
        'amount_paid',
        'balance_remaining',
        'payment_status',
        'payment_date',
        'overdue_since',
        'overdue_days',
        'deadline',
    ];

    protected $casts = [
        'semester_start' => 'date',
        'semester_end'   => 'date',
        'payment_date'   => 'date',
        'deadline'       => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
