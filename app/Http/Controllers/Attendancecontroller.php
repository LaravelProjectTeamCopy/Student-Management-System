<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\AttendanceLog;
use App\Models\AttendanceHistory;
use App\Models\AttendanceDailyLog;
use App\Models\Subject;
use App\Models\SubjectSchedule;
use App\Models\SystemHistory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use App\Imports\AttendanceImport;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function attendanceindex()
    {
        $majors      = Student::distinct()->pluck('major');
        $yearLevels  = ['Year 1', 'Year 2', 'Year 3', 'Year 4'];
        $statuses    = Attendance::distinct()->pluck('status');
        $attendances = $this->searchByStudent(Attendance::with('student'), request('search'))
            ->when(request('major'), function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('major', request('major'));
                });
            })
            ->when(request('year_level'), function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('year_level', request('year_level'));
                });
            })
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->paginate(10)
            ->withQueryString();

        // Summary variables for dashboard cards
        $totalAttendance = Attendance::count();
        $goodCount       = Attendance::where('status', 'Good')->count();
        $atRiskCount     = Attendance::where('status', 'At Risk')->count();
        $criticalCount   = Attendance::where('status', 'Critical')->count();

        return view('attendances.index', compact(
            'attendances', 'majors', 'yearLevels', 'statuses',
            'totalAttendance', 'goodCount', 'atRiskCount', 'criticalCount'
        ));
    }

    private function calculateStatus($present, $total)
    {
        $pct = $total > 0 ? round(($present / $total) * 100) : 0;

        if ($pct >= 75)     return 'Good';
        elseif ($pct >= 50) return 'At Risk';
        else                return 'Critical';
    }

    public function attendanceshow($id)
    {
        $student    = Student::findOrFail($id);
        $attendance = Attendance::where('student_id', $id)->firstOrFail();
        $logs       = AttendanceLog::where('student_id', $id)->orderBy('log_date', 'desc')->take(3)->get();

        $absentDays = $attendance->absent_days ?? 0;
        $result     = $absentDays >= 3 ? 'Fail' : 'Pass';
        $message    = $absentDays >= 3
            ? "Student has failed attendance — absent {$absentDays} days (limit: 3 days) retake exam."
            : "Student has passed attendance — absent only {$absentDays} days.";

        return view('attendances.show', compact('student', 'attendance', 'logs', 'result', 'message'));
    }

    public function attendancehistory($id)
    {
        $student = Student::findOrFail($id);
        $logs    = AttendanceLog::where('student_id', $id)->orderBy('log_date', 'desc')->paginate(10);

        return view('attendances.history', compact('student', 'logs'));
    }

    public function attendanceedit(Request $request, $id)
    {
        $attendance    = Attendance::where('student_id', $id)->firstOrFail();
        $student       = $attendance->student;
        $semesterStart = \Carbon\Carbon::parse($attendance->semester_start)->startOfDay();
        $today         = \Carbon\Carbon::now()->startOfDay();

        $firstWeekEnd = $semesterStart->copy()->endOfWeek(\Carbon\Carbon::FRIDAY)->startOfDay();

        if ($today->lte($firstWeekEnd)) {
            $weekStart = $semesterStart->copy();
        } else {
            $weekStart = $today->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
        }

        $friday   = $weekStart->copy()->endOfWeek(\Carbon\Carbon::FRIDAY)->setTime(17, 0, 0);
        $isLocked = !(\Carbon\Carbon::now()->isFriday() && \Carbon\Carbon::now()->lt($friday));

        $weekDays = collect();
        $day      = $weekStart->copy();
        $count    = 0;

        while ($count < 5) {
            if ($day->gt($friday)) break;

            if (!$day->isWeekend()) {
                $existing = AttendanceDailyLog::where('student_id', $student->id)
                    ->where('log_date', $day->format('Y-m-d'))
                    ->first();

                $weekDays->push([
                    'date'   => $day->format('Y-m-d'),
                    'label'  => $day->format('l, M d'),
                    'status' => $existing?->status ?? null,
                ]);

                $count++;
            }
            $day->addDay();
        }

        $lastUpdate = AttendanceLog::where('student_id', $id)
            ->orderBy('log_date', 'desc')
            ->first();

        return view('attendances.edit', compact('attendance', 'student', 'weekDays', 'weekStart', 'lastUpdate', 'isLocked'));
    }

    public function attendanceupdate(Request $request, $id)
    {
        $attendance    = Attendance::where('student_id', $id)->firstOrFail();
        $semesterStart = \Carbon\Carbon::parse($attendance->semester_start)->startOfDay();
        $semesterEnd   = \Carbon\Carbon::parse($attendance->deadline)->endOfDay();
        $today         = \Carbon\Carbon::now()->startOfDay();

        $firstWeekEnd = $semesterStart->copy()->endOfWeek(\Carbon\Carbon::FRIDAY)->startOfDay();

        if ($today->lte($firstWeekEnd)) {
            $weekStart = $semesterStart->copy();
        } else {
            $weekStart = $today->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
        }

        $friday   = $weekStart->copy()->endOfWeek(\Carbon\Carbon::FRIDAY)->setTime(17, 0, 0);
        $deadline = \Carbon\Carbon::parse($attendance->deadline);
        $now      = \Carbon\Carbon::now();

        if ($now->gt($deadline)) {
            return back()->withErrors(['locked' => 'Semester has ended. Attendance is closed.']);
        }

        if (!($now->isFriday() && $now->lt($friday))) {
            return back()->withErrors(['locked' => 'Attendance can only be submitted on Friday before 5PM.']);
        }

        $request->validate([
            'days'          => 'required|array',
            'days.*.date'   => 'required|date',
            'days.*.status' => 'nullable|in:present,absent',
        ]);

        foreach ($request->days as $entry) {
            if (empty($entry['status'])) continue;
            AttendanceDailyLog::updateOrCreate(
                ['student_id' => $attendance->student_id, 'log_date' => $entry['date']],
                ['status'     => $entry['status']]
            );
        }

        $presentDays = AttendanceDailyLog::where('student_id', $attendance->student_id)
            ->where('status', 'present')
            ->whereBetween('log_date', [$semesterStart, $semesterEnd])
            ->count();

        $absentDays = AttendanceDailyLog::where('student_id', $attendance->student_id)
            ->where('status', 'absent')
            ->whereBetween('log_date', [$semesterStart, $semesterEnd])
            ->count();

        $totalDays = $attendance->semester_duration
            ? (int) $attendance->semester_duration * 5
            : ($presentDays + $absentDays);

        $status = $this->calculateStatus($presentDays, $totalDays);

        AttendanceLog::create([
            'student_id'   => $attendance->student_id,
            'total_days'   => $totalDays,
            'present_days' => $presentDays,
            'absent_days'  => $absentDays,
            'status'       => $status,
            'log_date'     => now(),
        ]);

        $attendance->update([
            'total_days'   => $totalDays,
            'present_days' => $presentDays,
            'absent_days'  => $absentDays,
            'status'       => $status,
        ]);

        // ── Apply subject failure surcharges ──────────────────────────
        $this->applySubjectFailureSurcharges($attendance, $semesterStart, $semesterEnd);
        // ─────────────────────────────────────────────────────────────

        SystemHistory::log(
            'Updated Attendance',
            'Attendance',
            "Updated attendance for {$attendance->student->name} — Present: {$presentDays}, Absent: {$absentDays} ({$status})",
            'edit_calendar'
        );

        return redirect('/attendances')->with('success', 'Attendance record updated successfully!');
    }

    private function applySubjectFailureSurcharges(Attendance $attendance, $semesterStart, $semesterEnd): void
    {
        $student   = $attendance->student;
        $financial = \App\Models\Financial::where('student_id', $student->id)->first();

        if (!$financial) return;

        // Get all scheduled subjects for this student's major/year/semester
        $schedules = SubjectSchedule::whereHas('subject', function ($q) use ($attendance) {
            $q->where('major', $attendance->student->major)
              ->where('academic_year', $attendance->academic_year)
              ->where('semester', $attendance->semester);
        })->with('subject')->get();

        if ($schedules->isEmpty()) return;

        foreach ($schedules as $schedule) {
            // Count absences on this subject's scheduled day within the semester
            $absentCount = AttendanceDailyLog::where('student_id', $student->id)
                ->where('status', 'absent')
                ->whereBetween('log_date', [$semesterStart, $semesterEnd])
                ->get()
                ->filter(fn($log) => Carbon::parse($log->log_date)->format('l') === $schedule->day_of_week)
                ->count();

            if ($absentCount < 3) continue;

            // Check if a surcharge for this subject was already applied this semester
            $alreadyCharged = \App\Models\PaymentLog::where('student_id', $student->id)
                ->where('payment_method', 'Surcharge')
                ->where('notes', 'like', "%subject_id:{$schedule->subject_id}%")
                ->where('payment_date', '>=', $semesterStart)
                ->exists();

            if ($alreadyCharged) continue;

            $surcharge = 100;

            // Add $100 to total_fees and recalculate balance + status
            $financial->increment('total_fees', $surcharge);
            $financial->refresh();

            $financial->balance_remaining = $financial->total_fees - $financial->amount_paid;

            if ($financial->amount_paid <= 0) {
                $financial->payment_status = 'Unpaid';
            } elseif ($financial->balance_remaining <= 0) {
                $financial->payment_status = 'Paid';
            } else {
                $financial->payment_status = 'Partial';
            }

            $financial->save();

            // Log the surcharge as a PaymentLog entry
            \App\Models\PaymentLog::create([
                'student_id'     => $student->id,
                'amount_paid'    => 0,
                'payment_method' => 'Surcharge',
                'payment_status' => $financial->payment_status,
                'payment_date'   => now()->toDateString(),
                'notes'          => "Subject failure surcharge – {$schedule->subject->name} ({$absentCount} absences) | subject_id:{$schedule->subject_id}",
            ]);

            SystemHistory::log(
                'Subject Failure Surcharge',
                'Financial',
                "Charged \${$surcharge} to {$student->name} — failed {$schedule->subject->name} ({$absentCount} absences on {$schedule->day_of_week})",
                'payments'
            );
        }
    }

    public function showattendanceimport()
    {
        return view('attendances.import');
    }

    public function showattendanceexport()
    {
        return view('attendances.export');
    }

    public function attendanceexport()
    {
        SystemHistory::log(
            'Exported Attendance',
            'Attendance',
            'Exported attendance records to Excel',
            'download'
        );

        return Excel::download(new AttendanceExport, 'Attendances_' . '.xlsx');
    }

    public function attendanceimport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new AttendanceImport, $request->file('file'));

        SystemHistory::log(
            'Imported Attendance',
            'Attendance',
            "Imported attendance records from {$request->file('file')->getClientOriginalName()}",
            'upload_file'
        );

        return redirect('/attendances')->with('success', 'Attendance record imported successfully!');
    }

    public function attendanceduration()
    {
        return view('attendances.duration');
    }

    public function attendancesetduration(Request $request)
    {
        $request->validate([
            'academic_year'     => 'required|string',
            'semester'          => 'required|string|in:Semester 1,Semester 2',
            'semester_start'    => 'required|date',
            'semester_duration' => 'required|string|in:15,17,18',
        ]);

        $weeks    = (int) $request->semester_duration;
        $deadline = \Carbon\Carbon::parse($request->semester_start)->copy()->addWeeks($weeks)->format('Y-m-d');

        Attendance::query()->update([
            'academic_year'     => $request->academic_year,
            'semester'          => $request->semester,
            'semester_start'    => $request->semester_start,
            'semester_duration' => $request->semester_duration,
            'deadline'          => $deadline,
        ]);

        Attendance::query()->update([
            'total_days'   => 0,
            'present_days' => 0,
            'absent_days'  => 0,
            'status'       => 'Critical',
        ]);

        SystemHistory::log(
            'Set Semester Duration',
            'Attendance',
            "Semester started {$request->semester_start} — {$weeks} weeks, deadline {$deadline} ({$request->academic_year} {$request->semester})",
            'date_range'
        );

        return redirect('/attendances')->with('success', 'Semester duration set successfully!');
    }

    public function attendancecleardeadline()
    {
        Attendance::query()->update([
            'academic_year'     => null,
            'semester'          => null,
            'semester_start'    => null,
            'semester_duration' => null,
            'deadline'          => null,
        ]);

        SystemHistory::log(
            'Cleared Attendance Deadline',
            'Attendance',
            'Attendance semester deadlines cleared for all students',
            'event_busy'
        );

        return redirect('/attendances')->with('success', 'Attendance deadlines cleared successfully!');
    }

    public function attendanceallhistory(Request $request)
    {
        $majors           = Student::distinct()->pluck('major');
        $attendanceresult = ['Passed', 'Failed'];

        $semesters = AttendanceHistory::select('semester_end')
            ->distinct()
            ->orderByDesc('semester_end')
            ->pluck('semester_end')
            ->groupBy(fn($date) => \Carbon\Carbon::parse($date)->format('Y'))
            ->map(fn($group) => $group->values());

        $histories = AttendanceHistory::with('student')
            ->when(request('major'), function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('major', request('major'));
                });
            })
            ->when(request('status'), function ($query) {
                $query->where('attendance_result', request('status'));
            })
            ->when(request('semester'), function ($query) {
                $query->where('semester_end', request('semester'));
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('attendances.all-students-history', compact('majors', 'attendanceresult', 'histories', 'semesters'));
    }

    public function attendanceallhistorydelete(Request $request)
    {
        $semesterEnd = $request->query('semester_end');

        if ($semesterEnd) {
            AttendanceHistory::where('semester_end', $semesterEnd)->delete();

            SystemHistory::log(
                'Deleted Attendance History',
                'Attendance',
                "Deleted all attendance history records for semester ending {$semesterEnd}",
                'delete'
            );

            return redirect()->route('attendances.studenthistory')
                ->with('success', 'All records for the selected semester have been deleted.');
        }

        return redirect()->back()->with('error', 'Invalid semester selected.');
    }

    public function attendanceschedule(Request $request)
    {
        $majors       = Student::distinct()->pluck('major');

        // Default to the active semester from attendance records if set
        $activeAtt    = Attendance::whereNotNull('academic_year')->first();
        $defaultYear  = $activeAtt?->academic_year ?? '2025/2026';
        $defaultSem   = $activeAtt?->semester ?? 'Semester 1';

        $currentMajor = $request->get('major', $majors->first() ?? 'Arts');
        $currentYear  = $request->get('year', $defaultYear);
        $currentSem   = $request->get('semester', $defaultSem);

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // Subjects available for this major/year/semester
        $subjects = Subject::where('major', $currentMajor)
            ->where('academic_year', $currentYear)
            ->where('semester', $currentSem)
            ->get();

        // Current schedule: which subject is on which day
        $schedules = SubjectSchedule::whereHas('subject', function ($q) use ($currentMajor, $currentYear, $currentSem) {
            $q->where('major', $currentMajor)
              ->where('academic_year', $currentYear)
              ->where('semester', $currentSem);
        })->with('subject')->get();

        // Build per-student results: for each scheduled subject, count absences on that day
        $studentResults = collect();
        if ($schedules->isNotEmpty()) {
            $students = Student::where('major', $currentMajor)
                ->whereHas('attendance', function ($q) {
                    $q->whereNotNull('semester_start')->whereNotNull('deadline');
                })
                ->with('attendance')
                ->get();

            foreach ($students as $student) {
                $att = $student->attendance;
                if (!$att || !$att->semester_start || !$att->deadline) continue;

                $deadlinePassed = now()->gt($att->deadline);
                $subjectData    = [];

                foreach ($schedules as $schedule) {
                    $absentCount = AttendanceDailyLog::where('student_id', $student->id)
                        ->where('status', 'absent')
                        ->whereBetween('log_date', [$att->semester_start, $att->deadline])
                        ->get()
                        ->filter(fn($log) => Carbon::parse($log->log_date)->format('l') === $schedule->day_of_week)
                        ->count();

                    $subjectData[] = [
                        'schedule_id'  => $schedule->id,
                        'subject_name' => $schedule->subject->name,
                        'day'          => $schedule->day_of_week,
                        'absent'       => $absentCount,
                        'result'       => $absentCount >= 3 ? 'Fail' : 'Pass',
                    ];
                }

                $failedCount = collect($subjectData)->where('result', 'Fail')->count();

                $studentResults->push([
                    'student'         => $student,
                    'subjects'        => $subjectData,
                    'failed_count'    => $failedCount,
                    'deadline_passed' => $deadlinePassed,
                ]);
            }
        }

        return view('attendances.schedule', compact(
            'majors', 'subjects', 'days', 'schedules', 'studentResults',
            'currentMajor', 'currentYear', 'currentSem'
        ));
    }

    public function attendancescheduleset(Request $request)
    {
        $request->validate([
            'subject_id'  => 'required|exists:subjects,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'start_time'  => 'nullable|date_format:H:i',
            'end_time'    => 'nullable|date_format:H:i|after:start_time',
        ]);

        $subject = Subject::findOrFail($request->subject_id);

        // Update or create - allows reassigning to different day
        $schedule = SubjectSchedule::updateOrCreate(
            ['subject_id' => $request->subject_id],
            [
                'day_of_week' => $request->day_of_week,
                'start_time'  => $request->start_time,
                'end_time'    => $request->end_time,
            ]
        );

        $action = $schedule->wasRecentlyCreated ? 'Assigned' : 'Reassigned';

        SystemHistory::log(
            "{$action} Subject Schedule",
            'Attendance',
            "{$action} {$subject->name} ({$subject->subject_code}) to {$request->day_of_week}",
            'calendar_month'
        );

        return back()->with('success', "{$subject->name} {$action} to {$request->day_of_week} successfully!");
    }

    public function attendancescheduleauto(Request $request)
    {
        $request->validate([
            'year'     => 'required|string',
            'semester' => 'required|string|in:Semester 1,Semester 2',
        ]);

        $year     = $request->year;
        $semester = $request->semester;
        $days     = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // Get all majors that have subjects for this year/semester
        $majors = Subject::where('academic_year', $year)
            ->where('semester', $semester)
            ->distinct()
            ->pluck('major');

        $totalAssigned = 0;
        $summary       = [];

        foreach ($majors as $major) {
            // Get subjects for this major that are NOT yet scheduled
            $unscheduled = Subject::where('major', $major)
                ->where('academic_year', $year)
                ->where('semester', $semester)
                ->whereDoesntHave('schedules')
                ->get();

            if ($unscheduled->isEmpty()) continue;

            $majorCount = 0;
            // Round-robin distribute across Mon–Fri
            foreach ($unscheduled as $i => $subject) {
                SubjectSchedule::create([
                    'subject_id'  => $subject->id,
                    'day_of_week' => $days[$i % 5],
                ]);
                $totalAssigned++;
                $majorCount++;
            }
            $summary[] = "{$major} ({$majorCount})";
        }

        if ($totalAssigned === 0) {
            return back()->with('info', "All subjects already scheduled for {$year} {$semester}.");
        }

        $summaryText = implode(', ', $summary);

        SystemHistory::log(
            'Auto-Scheduled Subjects',
            'Attendance',
            "Auto-assigned {$totalAssigned} subjects across {$majors->count()} majors for {$year} {$semester}",
            'auto_fix'
        );

        return back()->with('success', "Auto-scheduled {$totalAssigned} subjects: {$summaryText}. Switch major filter to see each.");
    }

    public function attendancescheduleremove($id)
    {
        $schedule = SubjectSchedule::with('subject')->findOrFail($id);

        SystemHistory::log(
            'Removed Subject Schedule',
            'Attendance',
            "Removed {$schedule->subject->name} from {$schedule->day_of_week}",
            'event_busy'
        );

        $schedule->delete();

        return back()->with('success', 'Schedule removed successfully!');
    }
}