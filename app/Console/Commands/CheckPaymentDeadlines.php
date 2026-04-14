<?php

namespace App\Console\Commands;

use App\Models\Financial;
use App\Models\FinancialHistory;
use App\Models\PaymentLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckPaymentDeadlines extends Command
{
    protected $signature = 'app:payment-deadlines';
    protected $description = 'Mark overdue payments, archive financial records, and reset for the new semester';

    public function handle(): void
    {
        // For Demo: Uncomment to pretend today is past the deadline
        Carbon::setTestNow(Carbon::parse('2026-05-15 14:00:00'));

        $first = Financial::first();

        if (!$first || !$first->deadline || !$first->semester_duration) {
            $this->info('No financial record or deadline found.');
            return;
        }

        $deadline = Carbon::parse($first->deadline);
        $semesterStart = $first->semester_start;
        $semesterDuration = (int) $first->semester_duration;

        $this->info("Current Semester: {$semesterStart} to {$deadline->format('Y-m-d')}");

        // 1. Check if deadline has passed
        if (now()->lt($deadline)) {
            $this->info('Deadline has not passed yet. Dashboard will show current statuses.');
            return;
        }

        // 2. Double-archive guard
        $alreadyArchived = FinancialHistory::where('semester_start', $semesterStart)
            ->where('deadline', $deadline->format('Y-m-d'))
            ->exists();

        if ($alreadyArchived) {
            $this->warn('This semester has already been archived. Skipping.');
            return;
        }

        $this->info('Deadline passed. Updating live statuses and starting archive...');

        try {
            DB::transaction(function () use ($deadline, $semesterDuration, $semesterStart) {
                
                // 3. Update LIVE statuses to Overdue first
                // Anyone who is 'Unpaid' or 'Partial' after the deadline is now 'Overdue'
                Financial::whereIn('payment_status', ['Unpaid', 'Partial'])
                    ->update(['payment_status' => 'Overdue']);

                $financials = Financial::all();
                $this->info("Processing {$financials->count()} students...");

                // 4. Map records for Archive
                $rows = $financials->map(function ($f) {
                    $overdueDays = 0;
                    if ($f->payment_status === 'Overdue' && $f->deadline) {
                        $overdueDays = now()->diffInDays(Carbon::parse($f->deadline));
                    }

                    return [
                        'student_id'        => $f->student_id,
                        'semester_start'    => $f->semester_start,
                        'semester_end'      => $f->semester_end ?? $f->deadline,
                        'total_fees'        => $f->total_fees,
                        'amount_paid'       => $f->amount_paid,
                        'balance_remaining' => $f->balance_remaining,
                        'payment_status'    => $f->payment_status,
                        'payment_date'      => $f->payment_date,
                        'overdue_days'      => $overdueDays,
                        'deadline'          => $f->deadline,
                    ];
                })->toArray();

                // 5. Bulk Insert Archives
                foreach (array_chunk($rows, 500) as $chunk) {
                    FinancialHistory::insert($chunk);
                }

                // 6. Cleanup Payment Logs
                PaymentLog::query()->delete();

                // 7. Prepare and Reset for New Semester
                // Start is the day after the previous deadline
                $newStart = $deadline->copy()->addDay()->startOfDay();
                // Financial deadline is 1 month after the new start
                $newDeadline = $newStart->copy()->addMonth(); 
                // Semester end is based on the original week duration
                $newEnd = $newStart->copy()->addWeeks($semesterDuration);

                Financial::query()->update([
                    'semester_start'    => $newStart->format('Y-m-d'),
                    'semester_end'      => $newEnd->format('Y-m-d'),
                    'deadline'          => $newDeadline->format('Y-m-d'),
                    'payment_status'    => 'Unpaid',
                    'amount_paid'       => 0,
                    'balance_remaining' => DB::raw('total_fees'), // Reset balance to the full fee
                    'payment_date'      => null,
                ]);

                // 8. Logging
                $paid = collect($rows)->where('payment_status', 'Paid')->count();
                $overdue = collect($rows)->where('payment_status', 'Overdue')->count();

                Log::info('[Financial Archive] Success', [
                    'archived_count' => count($rows),
                    'paid'           => $paid,
                    'overdue'        => $overdue,
                    'new_semester'   => $newStart->toDateString()
                ]);

                $this->info("✓ Archived {$paid} paid and {$overdue} overdue students.");
                $this->info("✓ New semester starts: {$newStart->format('Y-m-d')}");
            });

            $this->info('Archive and reset complete.');

        } catch (\Throwable $e) {
            Log::error('[Financial Archive] FAILED', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->error("Archive failed: {$e->getMessage()}");
        }
    }
}