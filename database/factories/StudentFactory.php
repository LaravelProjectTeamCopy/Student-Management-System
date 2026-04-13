<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'major' => $this->faker->randomElement(['Computer Science', 'Business', 'Engineering', 'Arts']),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'address' => $this->faker->address(),
            'student_code' => 'STU-' . strtoupper($this->faker->unique()->bothify('??####')),
            'academic_year' => $this->faker->randomElement(['2023-2024', '2024-2025', '2025-2026']),
        ];
    }
}
