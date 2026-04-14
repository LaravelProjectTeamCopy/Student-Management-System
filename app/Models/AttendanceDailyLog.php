<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceDailyLog extends Model
{
    protected $fillable = [
        'student_id', 
        'subject_id', // Added to track specific subject failure
        'log_date', 
        'status'
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}