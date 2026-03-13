<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Financial; // 👈 import the MODEL not the factory
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();

        foreach ($students as $student) {
            Financial::factory()->create([  // 👈 Financial not FinancialSeeder
                'student_id' => $student->id,
                'major'      => $student->major,
            ]);
        }
    }
}