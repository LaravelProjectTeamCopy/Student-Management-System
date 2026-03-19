<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    protected $fillable = [
        'student_id',
        'total_days',
        'present_days',
        'absent_days',
        'status',
        'note',
        'log_date',
    ];
    public $timestamps = false;
    protected $casts = [
        'log_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
