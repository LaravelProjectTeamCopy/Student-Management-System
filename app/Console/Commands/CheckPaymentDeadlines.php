<?php

namespace App\Console\Commands;

use App\Models\Financial;
use App\Models\FinancialHistory;
use App\Models\PaymentLog;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckPaymentDeadlines extends Command
{
    protected $signature = 'app:payment-deadlines';
    protected $description = 'Archive all financial records and reset them once the semester deadline has passed';

    public function handle()
    {
        $first = Financial::first();

        if (!$first || !$first->deadline || !$first->semester_duration) {
            $this->info('No financial record or deadline found.');
            return;
        }

        $deadline         = Carbon::parse($first->deadline);
        $semesterStart    = $first->semester_start;
        $semesterDuration = (int) $first->semester_duration;

        $this->info("Semester: {$semesterStart} → {$deadline->format('Y-m-d')} ({$semesterDuration} weeks)");

        if (now()->lt($deadline)) {
            $this->info('Deadline has not passed yet.');
            return;
        }

        // Double-archive guard
        $alreadyArchived = FinancialHistory::where('semester_start', $semesterStart)
            ->where('deadline', $deadline->format('Y-m-d'))
            ->exists();

        if ($alreadyArchived) {
            $this->warn('This semester has already been archived. Skipping.');
            return;
        }

        $this->info('Deadline passed. Starting archive...');

        try {
            DB::transaction(function () use ($deadline, $semesterDuration) {
                $financials = Financial::all();

                $this->info("Processing {$financials->count()} students...");

                // Bulk insert archives
                $rows = $financials->map(function ($f) {
                    $status = in_array($f->payment_status, ['Unpaid', 'Partial']) ? 'Overdue' : $f->payment_status;

                    $overdueDays = 0;
                    if ($status === 'Overdue' && $f->deadline) {
                        $overdueDays = now()->diffInDays(Carbon::parse($f->deadline));
                    }

                    return [
                        'student_id'        => $f->student_id,
                        'semester_start'    => $f->semester_start,
                        'semester_end'      => $f->semester_end ?? $f->deadline,
                        'total_fees'        => $f->total_fees,
                        'amount_paid'       => $f->amount_paid,
                        'balance_remaining' => $f->balance_remaining,
                        'payment_status'    => $status,
                        'payment_date'      => $f->payment_date,
                        'overdue_days'      => $overdueDays,
                        'deadline'          => $f->deadline,
                    ];
                })->toArray();

                $paid    = collect($rows)->where('payment_status', 'Paid')->count();
                $overdue = collect($rows)->where('payment_status', 'Overdue')->count();

                foreach (array_chunk($rows, 500) as $chunk) {
                    FinancialHistory::insert($chunk);
                }

                $this->info("  ✓ Archived {$paid} paid, {$overdue} overdue.");

                // Clean up payment logs
                $logsDeleted = PaymentLog::count();
                PaymentLog::query()->delete();
                $this->info("  ✓ Cleaned up {$logsDeleted} payment logs.");

                // Reset for new semester
                $newStart    = $deadline->copy()->addDay()->startOfDay();
                $newDeadline = $newStart->copy()->addMonth();
                $newEnd      = $newStart->copy()->addWeeks($semesterDuration);

                Financial::query()->update([
                    'semester_start'    => $newStart->format('Y-m-d'),
                    'semester_end'      => $newEnd->format('Y-m-d'),
                    'deadline'          => $newDeadline->format('Y-m-d'),
                    'payment_status'    => 'Unpaid',
                    'amount_paid'       => 0,
                    'balance_remaining' => DB::raw('total_fees'),
                    'payment_date'      => null,
                ]);

                $this->info("  ✓ New semester: {$newStart->format('Y-m-d')} → {$newEnd->format('Y-m-d')}");

                Log::info('[Financial Archive] Archived financial records', [
                    'total'   => count($rows),
                    'paid'    => $paid,
                    'overdue' => $overdue,
                    'user_id' => User::first()?->id,
                ]);
            });

            $this->info('Archive complete.');

        } catch (\Throwable $e) {
            Log::error('[Financial Archive] FAILED', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->error("Archive failed: {$e->getMessage()}");
        }
    }
}