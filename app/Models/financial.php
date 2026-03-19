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
        'payment_date'
    ];

    protected $casts = [
    'payment_date' => 'date', // 👈 tells Laravel to convert it to Carbon automatically
];

    public function student()
    {
        return $this->belongsTo(student::class);
    }
}
