<?php

namespace App\Console\Commands;

use App\Models\Financial;
use App\Models\FinancialHistory;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckPaymentDeadlines extends Command
{
    protected $signature = 'app:payment-deadlines';
    protected $description = 'Archive all financial records and reset them once the semester deadline has passed';

    public function handle()
    {
        // --- For testing only, remove/comment out in production ---
        Carbon::setTestNow(Carbon::parse('2026-05-03 14:00:00'));

        // Use first record to determine semester info
        $first = Financial::first();

        if (!$first || !$first->deadline || !$first->semester_duration) {
            $this->info('No financial record or deadline found.');
            return;
        }

        $deadline         = Carbon::parse($first->deadline);
        $semesterDuration = (int) $first->semester_duration;

        // Check if deadline has passed
        $now = Carbon::now();
        if ($now->lt($deadline)) {
            $this->info('Deadline has not passed yet.');
            return;
        }

        // 1️⃣ Archive all financial records
        foreach (Financial::all() as $financial) {
            $historyStatus = in_array($financial->payment_status, ['Unpaid', 'Partial']) ? 'Overdue' : $financial->payment_status;

            FinancialHistory::create([
                'student_id'        => $financial->student_id,
                'semester_start'    => $financial->semester_start,
                'semester_end'      => $financial->deadline,
                'total_fees'        => $financial->total_fees,
                'amount_paid'       => $financial->amount_paid,
                'balance_remaining' => $financial->balance_remaining,
                'payment_status'    => $historyStatus,
            ]);
        }

        // 2️⃣ Start new semester for all students
        $newStart    = $deadline->copy()->addDay()->startOfDay();
        $newDeadline = $newStart->copy()->addWeeks($semesterDuration);

        Financial::query()->update([
            'semester_start'    => $newStart->format('Y-m-d'),
            'semester_end'      => $newDeadline->format('Y-m-d'),
            'deadline'          => $newDeadline->format('Y-m-d'),
            'payment_status'    => 'Unpaid',
            'amount_paid'       => 0,
            'balance_remaining' => \DB::raw('total_fees'), // resets balance to full
        ]);

        $this->info("All financial records archived and reset: {$newStart->format('Y-m-d')} → Deadline: {$newDeadline->format('Y-m-d')}");
    }
}