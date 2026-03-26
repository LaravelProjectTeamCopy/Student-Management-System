<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\AttendanceLog;
use App\Models\AttendanceHistory;
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
        \Carbon\Carbon::setTestNow('2026-06-15');
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

    public function attendanceedit($id)
    {
        $student = Student::findOrFail($id);
        $attendance = Attendance::where('student_id', $id)->firstOrFail();
        return view('attendances.edit', compact('attendance', 'student'));
    }

    public function attendanceupdate(Request $request, $id)
    {
        $attendance = Attendance::where('student_id', $id)->firstOrFail();

        $validated = $request->validate([
            'present_days' => 'required|numeric',
        ]);

        // auto calculate total_days from semester_duration
        $totalDays = $attendance->semester_duration 
            ? (int) $attendance->semester_duration * 5 
            : $attendance->total_days;

        if ($validated['present_days'] > $totalDays) {
            return back()->withErrors(['present_days' => 'Present days cannot exceed total days.'])->withInput();
        }

        $validated['total_days']  = $totalDays;
        $validated['absent_days'] = $totalDays - $validated['present_days'];
        $validated['status']      = $this->calculateStatus($validated['present_days'], $totalDays);

        AttendanceLog::create([
            'student_id'   => $attendance->student_id,
            'total_days'   => $totalDays,
            'present_days' => $validated['present_days'],
            'absent_days'  => $validated['absent_days'],
            'status'       => $validated['status'],
            'log_date'     => now(),
        ]);

        $attendance->update($validated);

        return redirect('/attendances')->with('success', 'Attendance record updated successfully!');
    }
    public function attendancesearch(Request $request)
    {
        $query = $request->input('query');
        $attendances = Attendance::whereHas('student', function($q) use ($query) {
            $q->where('name', 'like', "%$query%")
              ->orWhere('student_id', 'like', "%$query%");
        })->with('student')->paginate(10)->withQueryString();

        return view('attendances.index', compact('attendances'));
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

        $semesterStart = new \DateTime($request->semester_start);
        $weeks         = (int) $request->semester_duration;
        $semesterStart->modify("+{$weeks} weeks");
        $deadline = $semesterStart->format('Y-m-d');

        $data = [
            'semester_start'    => $request->semester_start,
            'semester_duration' => $request->semester_duration,
            'deadline'          => $deadline,
        ];

        if ($request->reset_attendance == 1) {
            $data['present_days'] = 0;
            $data['absent_days']  = 0;
            $data['total_days']   = 0;
        }

        $newStart    = \Carbon\Carbon::parse($deadline)->addDay();
        $newDeadline = $newStart->copy()->addWeeks((int) $semesterDuration);

        Attendance::query()->update($data);

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

        // 1. Get unique semesters grouped by Year for the Accordion
        $semesters = AttendanceHistory::select('semester_end')
            ->distinct()
            ->orderBy('semester_end', 'desc')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->semester_end)->format('Y');
            });

        // 2. Fetch the table data with your existing filters
        $histories = AttendanceHistory::with('student')
            ->when(request('major'), function($query) {
                $query->whereHas('student', function($q) {
                    $q->where('major', request('major'));
                });
            })
            ->when(request('status'), function($query) {
                $query->where('attendance_result', request('status'));
            })
            // Add this new filter to catch the semester selected from the accordion
            ->when(request('semester'), function($query) {
                $query->where('semester_end', request('semester'));
            })
            ->latest('id')
            ->paginate(10);

        return view('attendances.all-students-history', compact('majors', 'attendanceresult', 'histories', 'semesters'));
    }
}