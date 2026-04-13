<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    /** @use HasFactory<\Database\Factories\FinancialFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'student_id',
        'total_fees',
        'amount_paid',
        'balance_remaining',
        'payment_status',
        'payment_date',
        'semester_start',
        'semester_duration',
        'semester_end',
        'deadline'
    ];

    protected $casts = [
        'payment_date'   => 'date',
        'semester_start' => 'date',
        'deadline'       => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
