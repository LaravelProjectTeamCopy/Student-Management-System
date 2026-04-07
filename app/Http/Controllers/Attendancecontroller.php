<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\AttendanceLog;
use App\Models\AttendanceHistory;
use App\Models\AttendanceDailyLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use App\Imports\AttendanceImport;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function attendanceindex()
    {
        $majors = Student::distinct()->pluck('major');
        $statuses = Attendance::distinct()->pluck('status');
        $attendances = $this->searchByStudent(Attendance::with('student'), request('search'))
        ->when(request('major'), function($query) {
            $query->whereHas('student', function($q) {
                $q->where('major', request('major'));
            });
        })
        ->when(request('status'), function($query) {
            $query->where('status', request('status'));
        })
        ->paginate(10)
        ->withQueryString();

        return view('attendances.index', compact('attendances', 'majors', 'statuses'));
    }

    private function calculateStatus($present, $total)
    {
        $pct = $total > 0 ? round(($present / $total) * 100) : 0;

        if ($pct >= 75) return 'Good';
        elseif ($pct >= 50) return 'At Risk';
        else return 'Critical';
    }

    public function attendanceshow($id)
    {
        \Carbon\Carbon::setTestNow(\Carbon\Carbon::parse('2026-10-28 14:00:00'));
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
        \Carbon\Carbon::setTestNow(\Carbon\Carbon::parse('2027-05-28 14:00:00'));
        $attendance    = Attendance::where('student_id', $id)->firstOrFail();
        $student       = $attendance->student;
        $semesterStart = \Carbon\Carbon::parse($attendance->semester_start)->startOfDay();
        $today         = \Carbon\Carbon::now()->startOfDay();

        // Week 1: starts on semester_start (even if mid-week), ends that Friday
        // Week 2+: always Monday of that calendar week to Friday
        $firstWeekEnd = $semesterStart->copy()->endOfWeek(\Carbon\Carbon::FRIDAY)->startOfDay();

        if ($today->lte($firstWeekEnd)) {
            // Still in week 1 — start from semester_start date
            $weekStart = $semesterStart->copy();
        } else {
            // Week 2+ — snap to Monday of the current calendar week
            $weekStart = $today->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
        }

        // Friday 5PM of the current week
        $friday   = $weekStart->copy()->endOfWeek(\Carbon\Carbon::FRIDAY)->setTime(17, 0, 0);
        $isLocked = !(\Carbon\Carbon::now()->isFriday() && \Carbon\Carbon::now()->lt($friday));

        $weekDays = collect();
        $day      = $weekStart->copy();
        $count    = 0;

        while ($count < 5) {
            if ($day->gt($friday)) {
                break;
            }

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
        \Carbon\Carbon::setTestNow(\Carbon\Carbon::parse('2027-05-28 14:00:00'));
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

        // Count only logs within the current semester
        $presentDays = AttendanceDailyLog::where('student_id', $attendance->student_id)
            ->where('status', 'present')
            ->whereBetween('log_date', [$semesterStart, $semesterEnd])
            ->count();

        $absentDays = AttendanceDailyLog::where('student_id', $attendance->student_id)
            ->where('status', 'absent')
            ->whereBetween('log_date', [$semesterStart, $semesterEnd])
            ->count();

        $totalDays = $attendance->semester_duration ? (int)$attendance->semester_duration * 5 : ($presentDays + $absentDays);
        $status    = $this->calculateStatus($presentDays, $totalDays);

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

        return redirect('/attendances')->with('success', 'Attendance record updated successfully!');
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
        return Excel::download(new AttendanceExport, 'Attendances_' . '.xlsx');
    }
    public function attendanceimport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new AttendanceImport, $request->file('file'));
        return redirect('/welcome')->with('success', 'Attendance record imported successfully!');
    }
    public function attendanceduration()
    {
        return view('attendances.duration');
    }
    public function attendancesetduration(Request $request)
    {
        $request->validate([
            'semester_start'    => 'required|date',
            'semester_duration' => 'required|string|in:15,17,18',
        ]);

        $weeks = (int) $request->semester_duration;
        $deadline = \Carbon\Carbon::parse($request->semester_start)->copy()->addWeeks($weeks)->format('Y-m-d');

        Attendance::query()->update([
            'semester_start'    => $request->semester_start,
            'semester_duration' => $request->semester_duration,
            'deadline'          => $deadline,
        ]);

        Attendance::query()->update([
            'total_days'        => 0,
            'present_days'      => 0,
            'absent_days'       => 0,
            'status'            => 'Critical',
        ]);

        return redirect('/attendances')->with('success', 'Semester duration set successfully!');
    }

    public function attendancecleardeadline()
    {
        // clear ALL attendances
        Attendance::query()->update([
            'semester_start'    => null,
            'semester_duration' => null,
            'deadline'          => null,
        ]);

        return redirect('/attendances')->with('success', 'Attendance deadlines cleared successfully!');
    }
    public function attendanceallhistory(Request $request)
    {
        $majors           = Student::distinct()->pluck('major');
        $attendanceresult = ['Passed', 'Failed'];

        // Get semesters from AttendanceHistory, grouped by year
        $semesters = AttendanceHistory::select('semester_end')
            ->distinct()
            ->orderByDesc('semester_end')
            ->pluck('semester_end')
            ->groupBy(fn($date) => \Carbon\Carbon::parse($date)->format('Y'))
            ->map(fn($group) => $group->values());

        $histories = AttendanceHistory::with('student')
            ->when(request('major'), function($query) {
                $query->whereHas('student', function($q) {
                    $q->where('major', request('major'));
                });
            })
            ->when(request('status'), function($query) {
                $query->where('attendance_result', request('status'));
            })
            ->when(request('semester'), function($query) {
                $query->where('semester_end', request('semester'));
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString(); // preserve filters on pagination

        return view('attendances.all-students-history', compact('majors', 'attendanceresult', 'histories', 'semesters'));
    }
    public function attendanceallhistorydelete(Request $request)
    {
        $semesterEnd = $request->query('semester_end');

        if ($semesterEnd) {
            // Delete all records where semester_end matches the clicked date
            AttendanceHistory::where('semester_end', $semesterEnd)->delete();
            
            return redirect()->route('attendances.studenthistory')
                ->with("success", "All records for the selected semester have been deleted.");
        }

        return redirect()->back()->with("error", "Invalid semester selected.");
    }
}