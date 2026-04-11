<?php

namespace App\Console\Commands;

use App\Models\Financial;
use App\Models\FinancialHistory;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckPaymentDeadlines extends Command
{
    protected $signature = 'app:payment-deadlines';
    protected $description = 'Archive financial records when payment deadline has passed and start a new semester cycle';

    public function handle()
    {
        // --- For testing only ---
        \Carbon\Carbon::setTestNow(Carbon::parse('2026-05-03 14:00:00'));

        // Read first record to get the semester info
        $first = Financial::first();

        if (!$first || !$first->deadline || !$first->semester_duration) {
            $this->info('No financial record or deadline found.');
            return;
        }

        $deadline         = $first->deadline;
        $semesterDuration = (int) $first->semester_duration;
        $now              = Carbon::now();

        // Check if deadline has passed
        if ($now->lt(Carbon::parse($deadline))) {
            $this->info('Deadline has not passed yet.');
            return;
        }

        // Archive all financial records
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

        // Start new semester: exactly the day after current deadline
        $newStart    = Carbon::parse($deadline)->addDay()->startOfDay();
        $newDeadline = $newStart->copy()->addWeeks($semesterDuration);

        // Reset all current financial records for new semester
        Financial::query()->update([
            'semester_start'    => $newStart->format('Y-m-d'),
            'semester_end'      => $newDeadline->format('Y-m-d'),
            'deadline'          => $newDeadline->format('Y-m-d'),
            'payment_status'    => 'Unpaid',
            'amount_paid'       => 0,
            'balance_remaining' => \DB::raw('total_fees'),
        ]);

        $this->info("All financial records archived and new semester started: {$newStart->format('Y-m-d')} → Deadline: {$newDeadline->format('Y-m-d')}");
    }
}