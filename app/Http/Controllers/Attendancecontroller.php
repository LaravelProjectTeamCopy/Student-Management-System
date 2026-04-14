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
use App\Models\Financial;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use App\Imports\AttendanceImport;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display the main attendance dashboard.
     */
    public function attendanceindex()
    {
        $majors   = Student::distinct()->pluck('major');
        $statuses = Attendance::distinct()->pluck('status');
        
        $attendances = Attendance::with('student')
            ->when(request('search'), function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('name', 'like', '%' . request('search') . '%')
                      ->orWhere('student_id', 'like', '%' . request('search') . '%');
                });
            })
            ->when(request('major'), function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('major', request('major'));
                });
            })
            ->when(request('year'), function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('academic_year', request('year'));
                });
            })
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->paginate(10)
            ->withQueryString();

        $totalAttendance = Attendance::count();
        $presentCount    = Attendance::where('status', 'Good')->count();
        $absentCount     = Attendance::where('status', 'Critical')->count();
        $pendingCount    = Attendance::where('status', 'At Risk')->count();

        return view('attendances.index', compact(
            'attendances', 'majors', 'statuses',
            'totalAttendance', 'presentCount', 'absentCount', 'pendingCount'
        ));
    }

    private function calculateStatus($present, $total)
    {
        $pct = $total > 0 ? round(($present / $total) * 100) : 0;
        if ($pct >= 75) return 'Good';
        if ($pct >= 50) return 'At Risk';
        return 'Critical';
    }

    public function attendanceshow($id)
    {
        $student    = Student::findOrFail($id);
        $attendance = Attendance::where('student_id', $id)->firstOrFail();
        $logs       = AttendanceLog::where('student_id', $id)->orderBy('log_date', 'desc')->take(3)->get();

        $absentDays = $attendance->absent_days ?? 0;
        $result     = $absentDays > 3 ? 'Fail' : 'Pass';
        $message    = $absentDays > 3
            ? "Student has failed attendance — absent {$absentDays} days (limit: 3 days)."
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
        // Testing override for demo purposes
        Carbon::setTestNow(Carbon::parse('2026-07-31 14:00:00'));

        $attendance = Attendance::where('student_id', $id)->firstOrFail();
        $student    = $attendance->student;
        $deadline   = $attendance->deadline ? Carbon::parse($attendance->deadline)->endOfDay() : null;

        $isLocked   = $deadline && Carbon::now()->gt($deadline);
        $weekStart  = Carbon::now()->startOfWeek(Carbon::MONDAY);

        $weekDays = collect();
        $day      = $weekStart->copy();
        $count    = 0;

        while ($count < 5) {
            if (!$day->isWeekend()) {
                $existing = AttendanceDailyLog::where('student_id', $student->id)
                    ->where('log_date', $day->format('Y-m-d'))
                    ->first();

                $isPastDeadline = $deadline && $day->copy()->startOfDay()->gt($deadline);

                $weekDays->push([
                    'date'           => $day->format('Y-m-d'),
                    'label'          => $day->format('l, M d'),
                    'status'         => $existing?->status ?? null,
                    'past_deadline'  => $isPastDeadline,
                ]);
                $count++;
            }
            $day->addDay();
        }

        $lastUpdate = AttendanceLog::where('student_id', $id)->orderBy('log_date', 'desc')->first();

        return view('attendances.edit', compact(
            'attendance', 'student', 'weekDays', 'weekStart', 'lastUpdate', 'isLocked'
        ));
    }
    
    public function attendanceupdate(Request $request, $id)
    {
        $attendance    = Attendance::where('student_id', $id)->firstOrFail();
        $semesterStart = Carbon::parse($attendance->semester_start)->startOfDay();
        $semesterEnd   = Carbon::parse($attendance->deadline)->endOfDay();

        if ($attendance->deadline && Carbon::now()->gt($semesterEnd)) {
            return back()->withErrors(['locked' => 'Semester has ended. Attendance is closed.']);
        }

        $request->validate([
            'days'          => 'required|array',
            'days.*.date'   => 'required|date',
            'days.*.status' => 'nullable|in:present,absent',
        ]);

        foreach ($request->days as $entry) {
            if (empty($entry['status'])) {
                AttendanceDailyLog::where('student_id', $attendance->student_id)
                    ->where('log_date', $entry['date'])->delete();
                continue;
            }
            if (Carbon::parse($entry['date'])->gt($semesterEnd)) continue;

            AttendanceDailyLog::updateOrCreate(
                ['student_id' => $attendance->student_id, 'log_date' => $entry['date']],
                ['status'     => $entry['status']]
            );
        }

        $presentDays = AttendanceDailyLog::where('student_id', $attendance->student_id)
            ->where('status', 'present')
            ->whereBetween('log_date', [$semesterStart, $semesterEnd])->count();

        $absentDays = AttendanceDailyLog::where('student_id', $attendance->student_id)
            ->where('status', 'absent')
            ->whereBetween('log_date', [$semesterStart, $semesterEnd])->count();

        $totalPossible = $attendance->semester_duration ? (int) $attendance->semester_duration * 5 : ($presentDays + $absentDays);
        $status        = $this->calculateStatus($presentDays, $totalPossible);

        $attendance->update([
            'total_days'   => $totalPossible,
            'present_days' => $presentDays,
            'absent_days'  => $absentDays,
            'status'       => $status,
        ]);

        AttendanceLog::create([
            'student_id'   => $attendance->student_id,
            'total_days'   => $totalPossible,
            'present_days' => $presentDays,
            'absent_days'  => $absentDays,
            'status'       => $status,
            'log_date'     => now(),
        ]);

        SystemHistory::log('Updated Attendance', 'Attendance', "Updated {$attendance->student->name} — Present: {$presentDays}, Absent: {$absentDays}", 'edit_calendar');

        return redirect('/attendances')->with('success', 'Attendance record updated successfully!');
    }

    private function applySubjectFailureSurcharges(Attendance $attendance, $semesterStart, $semesterEnd): void
    {
        $student   = $attendance->student;
        $financial = Financial::where('student_id', $student->id)->first();
        if (!$financial || !$student) return;

        $schedules = SubjectSchedule::whereHas('subject', fn($q) => $q->where('major', $student->major))->with('subject')->get();
        $absentLogs = AttendanceDailyLog::where('student_id', $student->id)->where('status', 'absent')
            ->whereBetween('log_date', [$semesterStart, $semesterEnd])->get();

        foreach ($schedules as $schedule) {
            $absentCount = $absentLogs->filter(fn($log) => Carbon::parse($log->log_date)->format('l') === $schedule->day_of_week)->count();

            if ($absentCount > 3) {
                $identifier = "subject_id:{$schedule->subject_id}";
                $alreadyCharged = PaymentLog::where('student_id', $student->id)
                    ->where('payment_method', 'Surcharge')->where('note', 'like', "%{$identifier}%")->exists();

                if (!$alreadyCharged) {
                    $financial->increment('total_fees', 100);
                    $financial->refresh();
                    $financial->balance_remaining = $financial->total_fees - $financial->amount_paid;
                    $financial->payment_status = ($financial->balance_remaining <= 0) ? 'Paid' : (($financial->amount_paid > 0) ? 'Partial' : 'Unpaid');
                    $financial->save();

                    PaymentLog::create([
                        'student_id'     => $student->id,
                        'amount_paid'    => 0,
                        'payment_method' => 'Surcharge',
                        'payment_status' => $financial->payment_status,
                        'payment_date'   => now()->toDateString(),
                        'note'           => "Subject failure surcharge – {$schedule->subject->name} ({$absentCount} absences) | {$identifier}",
                    ]);
                }
            }
        }
    }

    public function showattendanceimport() { return view('attendances.import'); }
    public function showattendanceexport() { return view('attendances.export'); }

    public function attendanceexport()
    {
        SystemHistory::log('Exported Attendance', 'Attendance', 'Exported records to Excel', 'download');
        return Excel::download(new AttendanceExport, 'Attendances_' . now()->format('Y-m-d') . '.xlsx');
    }

    public function attendanceimport(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv|max:2048']);
        Excel::import(new AttendanceImport, $request->file('file'));
        return redirect('/welcome')->with('success', 'Attendance record imported successfully!');
    }

    public function attendanceduration() { return view('attendances.duration'); }

    public function attendancesetduration(Request $request)
    {
        $request->validate([
            'semester_start'    => 'required|date',
            'semester_duration' => 'required|string|in:15,17,18',
        ]);

        $weeks = (int) $request->semester_duration;
        $deadline = Carbon::parse($request->semester_start)->addWeeks($weeks)->format('Y-m-d');

        Attendance::query()->update([
            'semester_start'    => $request->semester_start,
            'semester_duration' => $request->semester_duration,
            'deadline'          => $deadline,
            'total_days'        => 0,
            'present_days'      => 0,
            'absent_days'       => 0,
            'status'            => 'Critical',
        ]);

        return redirect('/attendances')->with('success', 'Semester duration set successfully!');
    }

    public function attendancecleardeadline()
    {
        Attendance::query()->update(['semester_start' => null, 'semester_duration' => null, 'deadline' => null]);
        return redirect('/attendances')->with('success', 'Attendance deadlines cleared.');
    }

    public function attendanceallhistory(Request $request)
    {
        $majors = Student::distinct()->pluck('major');
        $attendanceresult = ['Passed', 'Failed'];

        $semesters = AttendanceHistory::select('semester_end')->distinct()->orderByDesc('semester_end')->pluck('semester_end')
            ->groupBy(fn($date) => Carbon::parse($date)->format('Y'))->map(fn($group) => $group->values());

        $histories = AttendanceHistory::with('student')
            ->when(request('major'), fn($q) => $q->whereHas('student', fn($sq) => $sq->where('major', request('major'))))
            ->when(request('status'), fn($q) => $q->where('attendance_result', request('status')))
            ->when(request('semester'), fn($q) => $q->where('semester_end', request('semester')))
            ->latest('id')->paginate(10)->withQueryString();

        return view('attendances.all-students-history', compact('majors', 'attendanceresult', 'histories', 'semesters'));
    }

    public function attendanceallhistorydelete(Request $request)
    {
        if ($request->query('semester_end')) {
            AttendanceHistory::where('semester_end', $request->query('semester_end'))->delete();
            return redirect()->route('attendances.studenthistory')->with('success', 'Records deleted.');
        }
        return redirect()->back()->with('error', 'Invalid semester.');
    }

    public function attendanceschedule(Request $request)
    {
        $majors       = Student::distinct()->pluck('major');
        $activeAtt    = Attendance::whereNotNull('deadline')->first();
        $currentMajor = $request->get('major', $majors->first() ?? 'Arts');
        $currentYear  = $request->get('year', $activeAtt?->academic_year ?? date('Y') . '/' . (date('Y') + 1));
        $currentSem   = $request->get('semester', $activeAtt?->semester ?? 'Semester 1');
        $days         = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $subjects  = Subject::where('major', $currentMajor)->get();

        // ✅ KEY FIX: filter schedules by major via subject relationship
        $schedules = SubjectSchedule::whereHas('subject', fn($q) => $q->where('major', $currentMajor))
                        ->with('subject')
                        ->get();

        $studentResults = collect();

        // ✅ Run even if schedules are empty — students still show with no subject rows
        $students = Student::where('major', $currentMajor)->get();

        foreach ($students as $student) {
            $att = $student->attendance;

            // ✅ Skip students with no active semester configured
            if (!$att || !$att->semester_start || !$att->deadline) continue;

            $absentLogs = AttendanceDailyLog::where('student_id', $student->id)
                ->where('status', 'absent')
                ->whereBetween('log_date', [$att->semester_start, $att->deadline])
                ->get();

            $subjectData = [];

            foreach ($schedules as $schedule) {
                $absentCount = $absentLogs->filter(
                    fn($log) => Carbon::parse($log->log_date)->format('l') === $schedule->day_of_week
                )->count();

                $subjectData[] = [
                    'subject_name' => $schedule->subject->name,
                    'day'          => $schedule->day_of_week,
                    'absent'       => $absentCount,
                    'result'       => $absentCount > 3 ? 'Fail' : 'Pass',
                ];
            }

            $failedCount  = collect($subjectData)->where('result', 'Fail')->count();
            $globalResult = ($failedCount > 0 || $absentLogs->count() > 3) ? 'Fail' : 'Pass';

            $studentResults->push([
                'student'         => $student,
                'subjects'        => $subjectData,
                'failed_count'    => $failedCount,
                'global_result'   => $globalResult,
                'deadline_passed' => $att->deadline && now()->gt($att->deadline),
            ]);
        }

        return view('attendances.schedule', compact(
            'majors', 'subjects', 'days', 'schedules',
            'studentResults', 'currentMajor', 'currentYear', 'currentSem'
        ));
    }

    public function attendancescheduleset(Request $request)
    {
        $request->validate(['subject_id' => 'required|exists:subjects,id', 'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday']);
        if (SubjectSchedule::where('subject_id', $request->subject_id)->exists()) return back()->withErrors(['duplicate' => "Already scheduled."]);
        SubjectSchedule::create($request->only('subject_id', 'day_of_week', 'start_time', 'end_time'));
        return back()->with('success', "Schedule assigned!");
    }

    public function attendancescheduleauto(Request $request)
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $unscheduled = Subject::whereDoesntHave('schedules')->get();
        $total = 0;

        foreach ($unscheduled as $i => $subject) {
            SubjectSchedule::create(['subject_id' => $subject->id, 'day_of_week' => $days[$i % 5]]);
            $total++;
        }

        return back()->with('success', "Auto-scheduled {$total} subjects.");
    }

    public function attendancescheduleremove($id)
    {
        SubjectSchedule::findOrFail($id)->delete();
        return back()->with('success', 'Schedule removed.');
    }
}