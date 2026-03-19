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
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}