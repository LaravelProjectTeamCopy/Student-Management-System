<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    public function definition(): array
{
    $total   = fake()->numberBetween(50, 100);
    $present = fake()->numberBetween(0, $total);
    $absent  = $total - $present;
    $pct     = round(($present / $total) * 100);

    if ($pct >= 75) $status = 'Good';
    elseif ($pct >= 50) $status = 'At Risk';
    else $status = 'Critical';

    return [
        'student_id'   => Student::inRandomOrder()->first()->id,
        'total_days'   => $total,
        'present_days' => $present,
        'absent_days'  => $absent,
        'status'       => $status,
    ];
}
}