<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Financial;
use App\Models\Student;

class FinancialController extends Controller
{
    public function financialindex()
    {
        $financials = Financial::paginate(10);
        return view('financials.index', compact('financials'));
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
}