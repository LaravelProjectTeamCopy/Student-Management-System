<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialHistory extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'student_id',
        'total_fees',
        'amount_paid',
        'balance_remaining',
        'present_days',
        'payment_status',
        'status',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }


}
