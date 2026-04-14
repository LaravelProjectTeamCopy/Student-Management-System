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
    protected $description = 'Archive attendance records, track failed subjects, and reset for the new semester';

    public function handle(): int
    {
        // For testing demo
        Carbon::setTestNow(Carbon::parse('2026-07-29 14:00:00'));

        $first = Attendance::first();

        // 1. Validation
        if (!$first || !$first->deadline || !$first->semester_duration) {
            $this->warn('No attendance record or deadline found. Skipping.');
            return self::SUCCESS;
        }

        $deadline = Carbon::parse($first->deadline)->startOfDay();
        $now      = Carbon::now()->startOfDay();

        // 2. Timing Check
        if ($now->lt($deadline)) {
            $daysLeft = $now->diffInDays($deadline, false);
            $this->info("Deadline has not passed yet. {$daysLeft} days remaining.");
            return self::SUCCESS;
        }

        // 3. Double-Archive Protection
        $deadlineString = $first->deadline instanceof \Carbon\Carbon
            ? $first->deadline->format('Y-m-d')
            : $first->deadline;

        $alreadyArchived = AttendanceHistory::where('semester_end', $deadlineString)->exists();

        if ($alreadyArchived) {
            $this->warn('This semester has already been archived. Skipping.');
            return self::SUCCESS;
        }

        $this->info('Deadline passed. Starting archive and semester reset...');

        // 4. Execution
        try {
            DB::transaction(function () use ($first, $deadline) {
                $this->archiveSemester($first, $deadline);
            });
        } catch (\Throwable $e) {
            $this->error("Archive failed: {$e->getMessage()}");
            $this->error("Line: {$e->getLine()} File: {$e->getFile()}");
            Log::channel('single')->error("[Attendance Archive] FAILED: {$e->getMessage()}", [
                'trace' => $e->getTraceAsString(),
            ]);
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function archiveSemester($first, Carbon $deadline): void
    {
        $semesterStart = $first->semester_start instanceof \Carbon\Carbon
            ? $first->semester_start->format('Y-m-d')
            : $first->semester_start;

        $semesterEnd = $first->deadline instanceof \Carbon\Carbon
            ? $first->deadline->format('Y-m-d')
            : $first->deadline;

        $attendances = Attendance::with('student')->get();

        $schedules = SubjectSchedule::with('subject')->get();

        $allAbsentLogs = AttendanceDailyLog::where('status', 'absent')
            ->whereBetween('log_date', [$semesterStart, $semesterEnd])
            ->get()
            ->groupBy('student_id');

        $historyRecords = [];
        $failedCount    = 0;
        $passedCount    = 0;

        foreach ($attendances as $att) {
            $studentAbsentLogs = $allAbsentLogs->get($att->student_id, collect());
            
            // Pre-calculate count of absences per day of week (e.g., ['Monday' => 4, 'Wednesday' => 1])
            $absencesPerDay = $studentAbsentLogs->mapToGroups(function ($log) {
                return [Carbon::parse($log->log_date)->format('l') => 1];
            })->map->count();

            $analysis = $this->analyzeStudentResult($att, $schedules, $absencesPerDay, $studentAbsentLogs->count());

            if ($analysis['result'] === 'Failed') $failedCount++;
            else $passedCount++;

            $attSemesterStart = $att->semester_start instanceof \Carbon\Carbon
                ? $att->semester_start->format('Y-m-d')
                : $att->semester_start;

            $attDeadline = $att->deadline instanceof \Carbon\Carbon
                ? $att->deadline->format('Y-m-d')
                : $att->deadline;

            // TIMESTAMP COLUMNS REMOVED FROM ARRAY BELOW
            $historyRecords[] = [
                'student_id'        => $att->student_id,
                'semester_start'    => $attSemesterStart,
                'semester_end'      => $attDeadline,
                'total_days'        => $att->total_days,
                'present_days'      => $att->present_days,
                'absent_days'       => $att->absent_days,
                'status'            => $att->status,
                'attendance_result' => $analysis['result'],
                'failed_subjects'   => $analysis['failed_list'],
            ];
        }

        $this->info("Inserting " . count($historyRecords) . " history records...");

        foreach (array_chunk($historyRecords, 500) as $chunk) {
            AttendanceHistory::insert($chunk);
        }

        $this->info("History inserted. Cleaning up logs...");

        AttendanceDailyLog::whereBetween('log_date', [$semesterStart, $semesterEnd])->delete();
        AttendanceLog::whereBetween('log_date',      [$semesterStart, $semesterEnd])->delete();

        SubjectSchedule::all()->each->delete();

        $duration    = (int) $first->semester_duration;
        $newStart    = $deadline->copy()->addDay()->startOfDay();
        $newDeadline = $newStart->copy()->addWeeks($duration);

        $this->info("Resetting attendance. New start: {$newStart->format('Y-m-d')}, New deadline: {$newDeadline->format('Y-m-d')}");

        Attendance::query()->update([
            'academic_year'     => null,
            'semester'          => null,
            'semester_start'    => $newStart->format('Y-m-d'),
            'semester_duration' => $duration,
            'deadline'          => $newDeadline->format('Y-m-d'),
            'total_days'        => 0,
            'present_days'      => 0,
            'absent_days'       => 0,
            'status'            => 'Critical',
        ]);

        $userId = User::first()?->id;
        if ($userId) {
            SystemHistory::create([
                'user_id'     => $userId,
                'action'      => 'Semester Archived',
                'module'      => 'Attendance',
                'description' => "Archived {$passedCount} passed, {$failedCount} failed. New cycle starts {$newStart->format('Y-m-d')}.",
                'icon'        => 'history',
            ]);
        }

        $this->info("Archive complete. {$passedCount} Passed, {$failedCount} Failed.");
    }

    private function analyzeStudentResult(Attendance $att, $schedules, $absencesPerDay, int $totalAbsences): array
    {
        $student = $att->student;
        $failedSubjects = [];

        if (!$student) {
            return ['result' => 'Passed', 'failed_list' => null];
        }

        // 1. Check Subject-Specific Failures (3 or more absences on a subject's day)
        $majorSchedules = $schedules->filter(fn($s) => $s->subject && $s->subject->major === $student->major);

        foreach ($majorSchedules as $schedule) {
            $scheduledDay = ucfirst(strtolower(trim($schedule->day_of_week)));
            $absentCount  = $absencesPerDay->get($scheduledDay, 0);

            if ($absentCount >= 3) {
                $failedSubjects[] = $schedule->subject->name;
            }
        }

        // 2. Check General Attendance Failure (15 or more total absences)
        $hardLimitReached = ($totalAbsences >= 15);
        
        // Student fails if they hit a subject limit OR the global 15-day limit
        $isFailed = !empty($failedSubjects) || $hardLimitReached;

        // 3. Determine the display string for the 'failed_list' column
        if (!empty($failedSubjects)) {
            // Just show names: "Math, Science"
            $failedList = implode(', ', array_unique($failedSubjects));
            
            // Optional: If they also hit the 15-day limit, you could append it, 
            // but per your request for "no hassle," we'll stick to subject names.
        } elseif ($hardLimitReached) {
            $failedList = "General Absence Limit";
        } else {
            $failedList = null;
        }

        return [
            'result'      => $isFailed ? 'Failed' : 'Passed',
            'failed_list' => $failedList,
        ];
    }
}