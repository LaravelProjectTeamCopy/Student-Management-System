<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use App\Models\Student;
use App\Models\Financial;
use App\Models\Attendance;
use App\Models\SystemHistory;


class StudentController extends Controller
{
    public function studentindex()
    {
        $currentYear   = request('year',   '');
        $currentStatus = request('status', '');
        $currentMajor  = request('major',  '');
        $search        = request('search', '');  // ← add this

        $years    = Student::select('academic_year')->distinct()->pluck('academic_year');
        $majors   = Student::select('major')->distinct()->pluck('major');
        $statuses = ['Active', 'Inactive', 'Graduated'];

        $base = Student::query()
            ->when($currentYear,  fn($q) => $q->where('academic_year', $currentYear))
            ->when($currentMajor, fn($q) => $q->where('major', $currentMajor))
            ->when($search, fn($q) => $q->where(function($q) use ($search) {  // ← add this
                $q->where('name',  'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            }));

        $totalStudents  = (clone $base)->count();
        $activeStudents = (clone $base)->where('status', 'Active')->count();
        $graduated      = (clone $base)->where('status', 'Graduated')->count();
        $newThisMonth   = (clone $base)
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at',  now()->year)
                            ->count();

        $students = (clone $base)
            ->when($currentStatus, fn($q) => $q->where('status', $currentStatus))
            ->paginate(15)
            ->withQueryString();

        return view('students.index', compact(
            'students',
            'years',
            'majors',
            'statuses',
            'currentYear',
            'currentStatus',
            'currentMajor',
            'totalStudents',
            'activeStudents',
            'graduated',
            'newThisMonth',
            'search',  // ← add this
        ));
    }

    public function studentshow($id)
    {
        $student = Student::findOrFail($id);
        return view('students.show', compact('student'));
    }

    public function showstudentcreate()
    {
        return view('students.create');
    }

    public function studentcreate(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:students,email',
            'date_of_birth' => 'nullable|date',
            'gender'        => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:500',
            'major'         => 'required|string|max:255',
            'academic_year' => 'required|string|max:20',
        ]);

        $student = Student::create($validated);

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

        SystemHistory::log(
            'Created Student',
            'Student',
            "Added {$student->name} ({$student->major}) to the directory",
            'person_add'
        );

        return redirect('/student')->with('success', 'Student created successfully!');
    }

    public function showimport()
    {
        return view('students.import');
    }

    public function studentedit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    public function studentupdate(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:students,email,' . $student->id,
            'date_of_birth' => 'nullable|date',
            'gender'        => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:500',
            'major'         => 'required|string|max:255',
            'academic_year' => 'required|string|max:20',
        ]);

        $student->update($validated);

        SystemHistory::log(
            'Updated Student',
            'Student',
            "Updated {$student->name} ({$student->major}) profile",
            'edit'
        );

        return redirect('/student/' . $student->id . '/show')->with('success', 'Student updated successfully!');
    }

    public function studentdestroy($id)
    {
        $student = Student::findOrFail($id);
        $name = $student->name;
        $major = $student->major;
        $student->delete();

        SystemHistory::log(
            'Deleted Student',
            'Student',
            "Removed {$name} ({$major}) from the directory",
            'person_remove'
        );

        return redirect('/student')->with('success', 'Student deleted successfully!');
    }

    public function showexport()
    {
        return view('students.export');
    }

    public function export()
    {
        SystemHistory::log(
            'Exported Students',
            'Student',
            'Exported student list to Excel',
            'download'
        );

        return Excel::download(new StudentsExport, 'students_' . now()->format('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new StudentsImport, $request->file('file'));

        SystemHistory::log(
            'Imported Students',
            'Student',
            "Imported students from CSV file — {$request->file('file')->getClientOriginalName()}",
            'upload_file'
        );

        return redirect('/student')->with('success', 'Students imported successfully!');
    }
}