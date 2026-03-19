<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Financial;
use App\Models\Student;
use App\Imports\FinancialImport;
use App\Exports\FinancialExport;
use Maatwebsite\Excel\Facades\Excel;

class FinancialController extends Controller
{
    public function financialindex()
    {
        $majors = Student::distinct()->pluck('major');
        $statuses = Financial::distinct()->pluck('payment_status');
        $financials = $this->searchByStudent(Financial::with('student'), request('search'))
        ->when(request('major'), function($query) {
            $query->whereHas('student', function($q) {
                $q->where('major', request('major'));
            });
        })
        ->when(request('status'), function($query) {
            $query->where('payment_status', request('status'));
        })
        ->paginate(10)
        ->withQueryString();
        return view('financials.index', compact('financials', 'majors', 'statuses'));
    }

    public function financialcreate()
    {
        return view('financials.create');
    }

    public function financialstore(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:students,email',
            'total_fees'     => 'required|numeric',
            'amount_paid'    => 'required|numeric',
            'payment_status' => 'required|string|in:Paid,Partial,Unpaid,Overdue',
            'payment_date'   => 'required|date',
        ]);

        $student = Student::where('email', $request->email)->first();
        Financial::create([
            'student_id'        => $student->id,
            'total_fees'        => $request->total_fees,
            'amount_paid'       => $request->amount_paid,
            'balance_remaining' => $request->total_fees - $request->amount_paid,
            'payment_status'    => $request->payment_status,
            'payment_date'      => $request->payment_date,
        ]);
        return redirect('/financials')->with('success', 'financial record created successfully!');
    }

    public function financialshow($id)
    {
        $student  = Student::findOrFail($id);
        $financial = Financial::where('student_id', $id)->firstOrFail();
        return view('financials.show', compact('student', 'financial'));
    }

    public function financialedit($id)
    {
        $student  = Student::findOrFail($id);
        $financial = Financial::where('student_id', $id)->firstOrFail();
        return view('financials.edit', compact('student', 'financial'));
    }

    public function financialupdate(Request $request, $id)
    {
        $financial = Financial::where('student_id', $id)->firstOrFail();

        $validated = $request->validate([
            'total_fees'     => 'required|numeric',
            'amount_paid'    => 'required|numeric',
            'payment_status' => 'required|string',
            'payment_date'   => 'required|date',
        ]);

        $validated['balance_remaining'] = $validated['total_fees'] - $validated['amount_paid'];

        $financial->update($validated);

        return redirect('/financials')->with('success', 'Financial record updated successfully!');
    }
    public function financialsearch(Request $request)
    {
        $query = $request->input('query');
        $financials = Financial::whereHas('student', function($q) use ($query) {
            $q->where('name', 'like', "%$query%")
              ->orWhere('student_id', 'like', "%$query%");
        })->with('student')->paginate(10)->withQueryString();

        return view('financials.index', compact('financials'));
    }

    public function showfinancialimport()
    {
        return view('financials.import');
    }
    public function showfinancialexport()
    {
        return view('financials.export');
    }
    public function financialexport()
    {
        return Excel::download(new FinancialExport, 'Financials_' . '.xlsx');
    }

    public function financialimport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new FinancialImport, $request->file('file'));

        return redirect('/welcome')->with('success', 'Financial records imported successfully!');
    }
}