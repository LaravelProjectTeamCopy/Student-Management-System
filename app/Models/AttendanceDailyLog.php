<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceDailyLog extends Model
{
    //
    protected $fillable = ['student_id', 'log_date', 'status'];
    public function attendance(){
        return $this->belongsTo(Attendance::class);
    }
}
