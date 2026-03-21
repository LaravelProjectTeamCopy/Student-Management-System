<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use App\Models\Student;
use App\Models\Financial;
use App\Models\Attendance;


class StudentController extends Controller
{
    public function showindex()
    {
        return view('students.index');
    }

    public function showcreate()
    {
        return view('students.create');
    }
    public function studentcreate(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'major' => 'required|string|max:255',
        ]);

        $student = Student::create($validated); // ← $student = here

        Financial::create([
            'student_id'        => $student->id,
            'total_fees'        => 0,
            'amount_paid'       => 0,
            'balance_remaining' => 0,
            'payment_status'    => 'Unpaid',
            'payment_date'      => now(),
        ]);

        Attendance::create([
            'student_id'   => $student->id,
            'total_days'   => 0,
            'present_days' => 0,
            'absent_days'  => 0,
            'status'       => 'Critical',
        ]);

        return redirect('/welcome')->with('success', 'Student created successfully!');
    }

    public function showimport()
    {
        return view('students.import');
    }

    public function showexport()
    {
        return view('students.export');
    }

    public function export()
    {
        return Excel::download(new StudentsExport, 'students_' . now()->format('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new StudentsImport, $request->file('file'));

        return redirect('/welcome')->with('success', 'Students imported successfully!');
    }
}