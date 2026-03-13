<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;


class student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
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
        return $this->hasMany(financial::class);
    }
    public function attendance()
    {
        return $this->hasOne(Attendance::class);
    }
}
