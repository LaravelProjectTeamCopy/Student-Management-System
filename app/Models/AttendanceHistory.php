<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceHistory extends Model
{
    public $timestamps = false;
    // Tell Laravel the EXACT table name in your database
    protected $table = 'attendance_histories'; 
    protected $fillable = [
        'student_id', 
        'semester_start', 
        'semester_end', 
        'present_days', 
        'absent_days', 
        'attendance_result',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}