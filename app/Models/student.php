<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Financial;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'major'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function financial()
    {
        return $this->hasMany(Financial::class);
    }

    public function attendance()
    {
        return $this->hasOne(Attendance::class);
    }
}