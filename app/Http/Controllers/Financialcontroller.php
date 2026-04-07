<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Financial;
use App\Models\Student;
use App\Models\PaymentLog;
use App\Models\FinancialHistory;
use App\Imports\FinancialImport;
use App\Exports\FinancialExport;
use Maatwebsite\Excel\Facades\Excel;

class FinancialController extends Controller
{
    public function financialindex()
    {
        $majors   = Student::distinct()->pluck('major');
        $statuses = Financial::distinct()->pluck('payment_status');

        $financials = $this->searchByStudent(Financial::with('student'), request('search'))
            ->when(request('major'), function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('major', request('major'));
                });
            })
            ->when(request('status'), function ($query) {
                $query->where('payment_status', request('status'));
            })
            ->paginate(10)
            ->withQueryString();

        return view('financials.index', compact('financials', 'majors', 'statuses'));
    }

    public function financialshow($id)
    {
        $student   = Student::findOrFail($id);
        $financial = Financial::where('student_id', $id)->firstOrFail();
        $logs      = PaymentLog::where('student_id', $id)->orderBy('payment_date', 'desc')->take(3)->get();

        return view('financials.show', compact('student', 'financial', 'logs'));
    }

    // ✅ Fixed typo: finacialhistory → financialhistory
    public function financialhistory($id)
    {
        $student = Student::findOrFail($id);
        $logs    = PaymentLog::where('student_id', $id)->orderBy('payment_date', 'desc')->paginate(10);

        return view('financials.history', compact('student', 'logs'));
    }

    public function financialedit($id)
    {
        \Carbon\Carbon::setTestNow(\Carbon\Carbon::parse('2026-05-03 14:00:00'));
        $financial = Financial::where('student_id', $id)->firstOrFail();
        $student   = $financial->student;
        $lastLog   = PaymentLog::where('student_id', $id)->orderBy('payment_date', 'desc')->first();
        $isLocked  = $financial->deadline && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($financial->deadline));

        return view('financials.edit', compact('financial', 'student', 'lastLog', 'isLocked'));
    }

    public function financialupdate(Request $request, $id)
    {
        \Carbon\Carbon::setTestNow(\Carbon\Carbon::parse('2026-05-03 14:00:00'));
        $financial = Financial::where('student_id', $id)->firstOrFail();
        $now       = \Carbon\Carbon::now();
        $deadline  = $financial->deadline ? \Carbon\Carbon::parse($financial->deadline) : null;

        if ($deadline && $now->gt($deadline)) {
            return back()->withErrors(['locked' => 'Financial period has ended. Records are now closed.']);
        }

        $validated = $request->validate([
            'total_fees'     => 'required|numeric|min:0',
            'amount_paid'    => 'required|numeric|min:0',
            'payment_status' => 'required|in:Paid,Partial,Unpaid,Overdue',
            'payment_date'   => 'required|date',
            'payment_method' => 'required|in:Cash,Bank Transfer,Online',
        ]);

        $validated['balance_remaining'] = $validated['total_fees'] - $validated['amount_paid'];

        $financial->update($validated);

        PaymentLog::create([
            'student_id'     => $financial->student_id,
            'amount_paid'    => $validated['amount_paid'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_status'],
            'payment_date'   => $validated['payment_date'],
        ]);

        return redirect('/financials')->with('success', 'Financial record updated successfully!');
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
        return Excel::download(new FinancialExport, 'Financials_.xlsx');
    }

    public function financialimport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new FinancialImport, $request->file('file'));

        return redirect('/welcome')->with('success', 'Financial records imported successfully!');
    }

    public function financialdeadline()
    {
        return view('financials.deadline');
    }

    public function financialsetdeadline(Request $request)
    {
        $request->validate([
            'semester_start'    => 'required|date',
            'semester_duration' => 'required|integer|in:15,17,18',
            'confirm_reset'     => 'required|in:1', // force confirmation
        ]);

        $semesterStart = \Carbon\Carbon::parse($request->semester_start);
        $weeks         = (int) $request->semester_duration;

        $deadline    = $semesterStart->copy()->addMonth();
        $semesterEnd = $semesterStart->copy()->addWeeks($weeks);

        // Update deadline fields
        Financial::query()->update([
            'semester_start'    => $semesterStart->format('Y-m-d'),
            'semester_duration' => $weeks,
            'deadline'          => $deadline->format('Y-m-d'),
            'semester_end'      => $semesterEnd->format('Y-m-d'),
        ]);

        // Reset all financial fields to zero
        Financial::query()->update([
            'total_fees'        => 0,
            'amount_paid'       => 0,
            'balance_remaining' => 0,
            'payment_status'    => 'Unpaid',
        ]);

        return redirect('/financials')->with('success', 'Deadline set and all records reset successfully!');
    }

    public function financialcleardeadline()
    {
        // ✅ Clear all deadline and overdue tracking fields
        Financial::query()->update([
            'deadline'      => null,
            'semester_end'  => null,
        ]);

        // ✅ Revert Overdue back to Unpaid
        Financial::where('payment_status', 'Overdue')
            ->update(['payment_status' => 'Unpaid']);

        return redirect('/financials')->with('success', 'Payment deadlines cleared successfully!');
    }

    public function financialallhistory(Request $request)
    {
        $majors = Student::distinct()->pluck('major');
        $paymentStatuses = ['Paid', 'Partial', 'Unpaid', 'Overdue'];

        // Get semesters from FinancialHistory, grouped by year
        $semesters = FinancialHistory::select('semester_end')
            ->distinct()
            ->orderByDesc('semester_end')
            ->pluck('semester_end')
            ->groupBy(fn($date) => \Carbon\Carbon::parse($date)->format('Y'))
            ->map(fn($group) => $group->values());

        // Build the query for financial history
        $histories = FinancialHistory::with('student')
            ->when(request('major'), function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('major', request('major'));
                });
            })
            ->when(request('status'), function ($query) {
                $query->where('payment_status', request('status'));
            })
            ->when(request('semester'), function ($query) {
                $query->where('semester_end', request('semester'));
            })
            ->latest('id')
            ->paginate(10) // 10 per page
            ->withQueryString(); // preserve filters on pagination

        return view('financials.all-students-hisitory', compact('majors', 'paymentStatuses', 'histories', 'semesters') );
    }

    public function financialallhistorydelete(Request $request)
    {
        $semesterEnd = $request->query('semester_end');

        if ($semesterEnd) {
            FinancialHistory::where('semester_end', $semesterEnd)->delete();

            return redirect()->route('financials.studenthistory')
                ->with('success', 'All records for the selected semester have been deleted.');
        }

        return redirect()->back()->with('error', 'Invalid semester selected.');
    }
}