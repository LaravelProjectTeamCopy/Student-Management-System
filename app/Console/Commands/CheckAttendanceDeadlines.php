<?php

namespace App\Console\Commands;

use App\Models\AttendanceHistory;
use Illuminate\Console\Command;
use App\Models\Attendance;

class CheckAttendanceDeadlines extends Command
{
    protected $signature = 'app:check-attendance-deadlines';
    protected $description = 'Archive attendance records when semester deadline has passed';

    public function handle()
    {
        $first = Attendance::first();
        $deadline = $first->deadline ?? null;
        $semesterDuration = $first->semester_duration ?? null;

        if ($deadline && now()->gt($deadline)) {

            $alreadyArchived = AttendanceHistory::where('semester_end', $deadline)->exists();

            if (!$alreadyArchived) {
                // 1. Archive
                foreach (Attendance::all() as $attendance) {
                    AttendanceHistory::create([
                        'student_id'        => $attendance->student_id,
                        'semester_start'    => $attendance->semester_start,
                        'semester_end'      => $attendance->deadline,
                        'present_days'      => $attendance->present_days,
                        'absent_days'       => $attendance->absent_days,
                        'status'            => $attendance->absent_days < 3 ? 'Passed' : 'Failed',
                        'attendance_result' => $attendance->absent_days < 3 ? 'Passed' : 'Failed',
                    ]);
                }

                // 2. Calculate new semester
                $newStart    = \Carbon\Carbon::parse($deadline)->addDay();
                $newDeadline = $newStart->copy()->addWeeks((int) $semesterDuration);

                // 3. Reset and start new semester
                Attendance::query()->update([
                    'present_days'      => 0,
                    'absent_days'       => 0,
                    'total_days'        => 0,
                    'status'            => 'Good',
                    'semester_start'    => $newStart->format('Y-m-d'),
                    'deadline'          => $newDeadline->format('Y-m-d'),
                ]);

                $this->info("Archived and new semester started: {$newStart->format('Y-m-d')} to {$newDeadline->format('Y-m-d')}");
            } else {
                $this->info('Already archived for this semester.');
            }
        } else {
            $this->info('Deadline has not passed yet.');
        }
    }
}