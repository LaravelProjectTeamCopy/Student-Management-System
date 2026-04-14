<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceHistory extends Model
{
    public $timestamps = false;

    protected $table = 'attendance_histories';

    protected $fillable = [
        'student_id',
        'semester_start',
        'semester_end',
        'total_days',
        'present_days',
        'absent_days',
        'status',
        'attendance_result',
        'failed_subjects',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}