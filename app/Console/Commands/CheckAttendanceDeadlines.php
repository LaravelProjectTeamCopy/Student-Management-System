<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\AttendanceHistory;
use App\Models\AttendanceDailyLog;
use App\Models\AttendanceLog;
use App\Models\SubjectSchedule;
use App\Models\SystemHistory;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckAttendanceDeadlines extends Command
{
    protected $signature = 'app:check-attendance-deadlines';
    protected $description = 'Archive attendance records when deadline passes and start a new semester cycle';

    public function handle(): int
    {
        // ── Step 1: Validate semester data exists ──
        $first = Attendance::first();

        if (!$first || !$first->deadline || !$first->semester_duration) {
            $this->warn('No attendance record or deadline found. Skipping.');
            Log::channel('single')->info('[Attendance Archive] Skipped — no attendance data or deadline configured.');
            return self::SUCCESS;
        }

        $deadline         = Carbon::parse($first->deadline);
        $semesterStart    = $first->semester_start;
        $semesterDuration = (int) $first->semester_duration;
        $now              = Carbon::now();

        $this->info("Semester: {$semesterStart} → {$first->deadline} ({$semesterDuration} weeks)");

        // ── Step 2: Check if deadline has passed ──
        if ($now->lt($deadline)) {
            $daysLeft = $now->diffInDays($deadline);
            $this->info("Deadline has not passed yet. {$daysLeft} days remaining.");
            return self::SUCCESS;
        }

        // ── Step 3: Prevent double-archiving ──
        $alreadyArchived = AttendanceHistory::where('semester_end', $first->deadline)
            ->where('academic_year', $first->academic_year)
            ->where('semester', $first->semester)
            ->exists();

        if ($alreadyArchived) {
            $this->warn('This semester has already been archived. Skipping.');
            Log::channel('single')->warning("[Attendance Archive] Double-archive prevented for {$first->academic_year} {$first->semester} ending {$first->deadline}.");
            return self::SUCCESS;
        }

        // ── Step 4: Begin atomic archive + reset ──
        $this->info('Deadline passed. Starting archive...');

        try {
            DB::transaction(function () use ($first, $deadline, $semesterStart, $semesterDuration) {
                $this->archiveSemester($first, $deadline, $semesterStart, $semesterDuration);
            });
        } catch (\Throwable $e) {
            $this->error("Archive failed: {$e->getMessage()}");
            Log::channel('single')->error("[Attendance Archive] FAILED: {$e->getMessage()}", [
                'trace' => $e->getTraceAsString(),
            ]);
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function archiveSemester($first, Carbon $deadline, string $semesterStart, int $semesterDuration): void
    {
        // ── Load all data upfront (avoid N+1 queries) ──
        $attendances  = Attendance::with('student')->get();
        $academicYear = $first->academic_year;
        $semester     = $first->semester;

        // Load only schedules that match this semester's academic_year + semester
        $schedules = SubjectSchedule::with('subject')
            ->whereHas('subject', function ($q) use ($academicYear, $semester) {
                $q->when($academicYear, fn($q) => $q->where('academic_year', $academicYear))
                  ->when($semester, fn($q) => $q->where('semester', $semester));
            })
            ->get();

        // Pre-load ALL absent logs for the semester in one query
        $allAbsentLogs = AttendanceDailyLog::where('status', 'absent')
            ->whereBetween('log_date', [$semesterStart, $first->deadline])
            ->get()
            ->groupBy('student_id');

        $this->info("Processing {$attendances->count()} students for {$academicYear} {$semester}...");

        // ── Build history records in bulk ──
        $historyRecords = [];
        $passedCount    = 0;
        $failedCount    = 0;

        foreach ($attendances as $att) {
            $studentAbsentLogs = $allAbsentLogs->get($att->student_id, collect());
            $result = $this->determineResult($att, $schedules, $studentAbsentLogs);

            $result === 'Failed' ? $failedCount++ : $passedCount++;

            $historyRecords[] = [
                'student_id'        => $att->student_id,
                'academic_year'     => $academicYear,
                'semester'          => $semester,
                'semester_start'    => $att->semester_start,
                'semester_end'      => $att->deadline,
                'total_days'        => $att->total_days,
                'present_days'      => $att->present_days,
                'absent_days'       => $att->absent_days,
                'status'            => $att->status,
                'attendance_result' => $result,
            ];
        }

        // Bulk insert all history records (chunked to avoid memory issues)
        foreach (array_chunk($historyRecords, 500) as $chunk) {
            AttendanceHistory::insert($chunk);
        }
        $this->info("  ✓ Archived {$passedCount} passed, {$failedCount} failed.");

        // ── Clean up old semester data ──
        $deletedDaily = AttendanceDailyLog::whereBetween('log_date', [$semesterStart, $first->deadline])->delete();
        $deletedLogs  = AttendanceLog::whereBetween('log_date', [$semesterStart, $first->deadline])->delete();
        $this->info("  ✓ Cleaned up {$deletedDaily} daily logs, {$deletedLogs} attendance logs.");

        // ── Clear subject schedules for THIS semester only ──
        $academicYear = $first->academic_year;
        $semester     = $first->semester;

        $deletedSchedules = SubjectSchedule::whereHas('subject', function ($q) use ($academicYear, $semester) {
            $q->when($academicYear, fn($q) => $q->where('academic_year', $academicYear))
              ->when($semester, fn($q) => $q->where('semester', $semester));
        })->count();

        SubjectSchedule::whereHas('subject', function ($q) use ($academicYear, $semester) {
            $q->when($academicYear, fn($q) => $q->where('academic_year', $academicYear))
              ->when($semester, fn($q) => $q->where('semester', $semester));
        })->delete();

        $this->info("  ✓ Cleared {$deletedSchedules} subject schedule entries for {$academicYear} {$semester}.");

        // ── Calculate new semester dates ──
        $newStart    = $deadline->copy()->addDay()->startOfDay();
        $newDeadline = $newStart->copy()->addWeeks($semesterDuration);

        // ── Reset all attendance records for new semester ──
        Attendance::query()->update([
            'academic_year'     => null,
            'semester'          => null,
            'semester_start'    => $newStart->format('Y-m-d'),
            'semester_duration' => $semesterDuration,
            'deadline'          => $newDeadline->format('Y-m-d'),
            'total_days'        => 0,
            'present_days'      => 0,
            'absent_days'       => 0,
            'status'            => 'Critical',
        ]);
        $this->info("  ✓ Reset all attendance records.");
        $this->info("  ✓ New semester: {$newStart->format('Y-m-d')} → {$newDeadline->format('Y-m-d')}");

        // ── Log to system history ──
        $userId = User::first()?->id;
        if ($userId) {
            SystemHistory::create([
                'user_id'     => $userId,
                'action'      => 'Archived Attendance & New Semester',
                'module'      => 'Attendance',
                'description' => "Archived {$passedCount} passed, {$failedCount} failed. Cleared {$deletedSchedules} schedules. New semester: {$newStart->format('Y-m-d')} → {$newDeadline->format('Y-m-d')}",
                'icon'        => 'history',
            ]);
        }

        // ── Persistent log for audit trail ──
        Log::channel('single')->info("[Attendance Archive] Completed", [
            'academic_year'  => $academicYear,
            'semester'       => $semester,
            'passed'         => $passedCount,
            'failed'         => $failedCount,
            'cleaned_daily'  => $deletedDaily,
            'cleaned_logs'   => $deletedLogs,
            'cleared_schedules' => $deletedSchedules,
            'old_semester'   => "{$semesterStart} → {$first->deadline}",
            'new_semester'   => "{$newStart->format('Y-m-d')} → {$newDeadline->format('Y-m-d')}",
        ]);

        $this->newLine();
        $this->info("Archive complete.");
    }

    private function determineResult(Attendance $att, $schedules, $studentAbsentLogs): string
    {
        $student = $att->student;
        if (!$student) return 'Passed';

        // Filter schedules to this student's major (academic_year/semester already filtered at load time)
        $majorSchedules = $schedules->filter(
            fn($s) => $s->subject && $s->subject->major === $student->major
        );

        // No subject schedules — fall back to simple absent_days >= 3
        if ($majorSchedules->isEmpty()) {
            return $att->absent_days >= 3 ? 'Failed' : 'Passed';
        }

        // Check each scheduled subject: 3+ absences on that day → fail
        foreach ($majorSchedules as $schedule) {
            $absentOnDay = $studentAbsentLogs->filter(
                fn($log) => Carbon::parse($log->log_date)->format('l') === $schedule->day_of_week
            )->count();

            if ($absentOnDay >= 3) {
                return 'Failed';
            }
        }

        return 'Passed';
    }
}