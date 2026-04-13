<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'subject_code',
        'name',
        'major',
        'credits',
        'academic_year',
        'semester',
    ];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function schedules()
    {
        return $this->hasMany(SubjectSchedule::class);
    }
}
