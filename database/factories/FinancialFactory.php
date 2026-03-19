<?php

namespace Database\Factories;

use App\Models\Financial;
use Illuminate\Database\Eloquent\Factories\Factory; // 👈 only this import

class FinancialFactory extends Factory
{
    // 👇 remove "use HasFactory" — it does NOT belong here!

    protected $model = Financial::class;

    public function definition(): array
    {
        $totalFees  = fake()->randomElement([3000, 4000, 5000, 6000, 7000, 8000]);
        $status     = fake()->randomElement(['Paid', 'Partial', 'Unpaid', 'Overdue']);

        $amountPaid = match($status) {
            'Paid'    => $totalFees,
            'Partial' => fake()->numberBetween($totalFees * 0.2, $totalFees * 0.8),
            'Unpaid'  => 0,
            'Overdue' => 0,
        };

        return [
            'total_fees'     => $totalFees,
            'amount_paid'    => $amountPaid,
            'balance_remaining' => $totalFees - $amountPaid,
            'payment_status' => $status,
            'payment_date'   => $amountPaid > 0 ? fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d') : null,
        ];
    }
}