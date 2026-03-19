<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'amount',
        'type',
        'method',
        'note',
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
