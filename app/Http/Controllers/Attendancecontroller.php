<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendanceindex()
    {
        $attendances = Attendance::paginate(10);
        return view('attendances.index', compact('attendances'));
    }

    public function attendanceshow($id)
    {
        $student = Student::findOrFail($id);
        $attendance = Attendance::where('student_id', $id)->firstOrFail();
        return view('attendances.show', compact('attendance', 'student'));
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

        $attendance->update($validated);

        return redirect('/attendances')->with('success', 'Attendance record updated successfully!');
    }
}