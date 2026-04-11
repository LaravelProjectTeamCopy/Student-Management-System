<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $fillable = [
        'student_id',
        'total_fees',
        'amount_paid',
        'payment_method',
        'payment_status',
        'payment_date',
    ];

    protected $casts = [
    'payment_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
