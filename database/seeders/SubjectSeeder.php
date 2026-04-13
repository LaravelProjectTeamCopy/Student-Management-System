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
            // Semester 1 - Computer Science
            ['name' => 'Mathematics', 'subject_code' => 'MATH-101', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Physics', 'subject_code' => 'PHY-101', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Chemistry', 'subject_code' => 'CHE-101', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Computer Science', 'subject_code' => 'C-101', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            
            // Semester 2 - Computer Science
            ['name' => 'Advanced Mathematics', 'subject_code' => 'MATH-102', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            ['name' => 'Data Structures', 'subject_code' => 'C-102', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            ['name' => 'Database Management', 'subject_code' => 'DB-102', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            ['name' => 'Web Development', 'subject_code' => 'WD-102', 'major' => 'Computer Science', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            
            // Semester 1 - Arts
            ['name' => 'English Literature', 'subject_code' => 'EN-101', 'major' => 'Arts', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'History', 'subject_code' => 'HIS-101', 'major' => 'Arts', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Philosophy', 'subject_code' => 'PHI-101', 'major' => 'Arts', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            
            // Semester 2 - Arts
            ['name' => 'World History', 'subject_code' => 'HIS-102', 'major' => 'Arts', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            ['name' => 'Modern Literature', 'subject_code' => 'EN-102', 'major' => 'Arts', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            ['name' => 'Ethics', 'subject_code' => 'PHI-102', 'major' => 'Arts', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            
            // Semester 1 - Business
            ['name' => 'Business Management', 'subject_code' => 'BM-101', 'major' => 'Business', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Marketing', 'subject_code' => 'MKT-101', 'major' => 'Business', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            ['name' => 'Finance', 'subject_code' => 'FIN-101', 'major' => 'Business', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            
            // Semester 2 - Business
            ['name' => 'Strategic Management', 'subject_code' => 'BM-102', 'major' => 'Business', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            ['name' => 'Digital Marketing', 'subject_code' => 'MKT-102', 'major' => 'Business', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            ['name' => 'Investment Analysis', 'subject_code' => 'FIN-102', 'major' => 'Business', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            
            // Semester 1 - Engineering
            ['name' => 'Mechanical Engineering', 'subject_code' => 'ME-101', 'major' => 'Engineering', 'academic_year' => '2025/2026', 'semester' => 'Semester 1'],
            
            // Semester 2 - Engineering
            ['name' => 'Thermodynamics', 'subject_code' => 'ME-102', 'major' => 'Engineering', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            ['name' => 'Fluid Mechanics', 'subject_code' => 'ME-103', 'major' => 'Engineering', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
            ['name' => 'Control Systems', 'subject_code' => 'ME-104', 'major' => 'Engineering', 'academic_year' => '2025/2026', 'semester' => 'Semester 2'],
        ];

        foreach ($subjects as $subject) {
            \App\Models\Subject::create($subject);
        }
    }
}
