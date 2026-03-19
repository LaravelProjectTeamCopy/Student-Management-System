<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\AttendanceLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use App\Imports\AttendanceImport;

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

    public function attendancecreate()
    {
        return view('attendances.create');
    }

    public function attendancestore(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:students,email',
            'total_days'   => 'required|numeric',
            'present_days' => 'required|numeric',
        ]);

        $student = Student::where('email', $request->email)->first();
        Attendance::create([
            'student_id'        => $student->id,
            'total_days'        => $request->total_days,
            'present_days'      => $request->present_days,
            'absent_days'       => $request->total_days - $request->present_days,
            'status'            => $this->calculateStatus($request->present_days, $request->total_days),
        ]);
        return redirect('/attendances')->with('success', 'Attendace record created successfully!');
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
        $student = Student::findOrFail($id);
        $attendance = Attendance::where('student_id', $id)->firstOrFail();
        $logs = AttendanceLog::where('student_id', $id)->orderBy('log_date', 'desc')->get();
        return view('attendances.show', compact('attendance', 'student', 'logs'));
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
            'total_days'   => 'required|numeric|gte:present_days',
            'present_days' => 'required|numeric',
        ]);

        $validated['absent_days'] = $validated['total_days'] - $validated['present_days'];
        $validated['status']      = $this->calculateStatus($validated['present_days'], $validated['total_days']);

        AttendanceLog::create([
            'student_id'   => $attendance->student_id,
            'total_days'   => $validated['total_days'],
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
}