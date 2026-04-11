<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Mathematics', 'subject_code' => 'MATH-101', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Physics', 'subject_code' => 'PHY-101', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Chemistry', 'subject_code' => 'CHE-101', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Computer Science', 'subject_code' => 'C-101', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'English Literature', 'subject_code' => 'EN-101', 'major' => 'Arts', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'History', 'subject_code' => 'HIS-101', 'major' => 'Arts', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Philosophy', 'subject_code' => 'PHI-101', 'major' => 'Arts', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Business Management', 'subject_code' => 'BM-101', 'major' => 'Business', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Marketing', 'subject_code' => 'MKT-101', 'major' => 'Business', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Finance', 'subject_code' => 'FIN-101', 'major' => 'Business', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Mechanical Engineering', 'subject_code' => 'ME-101', 'major' => 'Engineering', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
        ];

        foreach ($subjects as $subject) {
            \App\Models\Subject::create($subject);
        }
    }
}
