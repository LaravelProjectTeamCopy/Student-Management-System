<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Financial;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function ($student) {
            do {
                $code = 'STU-' . strtoupper(Str::random(2)) . rand(1000, 9999);
            } while (Student::where('student_code', $code)->exists()); // Guarantee uniqueness

            $student->student_code = $code;
        });
    }

    protected $fillable = [
        'name',
        'email',
        'major',
        'student_code',
        'academic_year',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function financial()
    {
        return $this->hasOne(Financial::class);
    }

    public function attendance()
    {
        return $this->hasOne(Attendance::class);
    }
    
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    public function subjects()
    {
        return $this->hasManyThrough(Subject::class, Score::class, 'student_id', 'id', 'id', 'subject_id');
    }
}