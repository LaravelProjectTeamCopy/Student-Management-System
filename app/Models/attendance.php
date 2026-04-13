<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;


class Attendance extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'total_days',
        'present_days',
        'absent_days',
        'status',
        'academic_year',
        'semester',
        'semester_start',
        'semester_duration',
        'deadline',
        'attendance_result',
    ];

    // Attendance.php model
    protected $casts = [
        'semester_start'    => 'date',
        'deadline'          => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}