<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Financial;
use App\Models\Student;
use App\Models\PaymentLog;
use App\Models\FinancialHistory;
use App\Models\SystemHistory;
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

        // Summary card variables
        $totalFinancial = Financial::count();
        $paidCount      = Financial::where('payment_status', 'Paid')->count();
        $partialCount   = Financial::where('payment_status', 'Partial')->count();
        $overdueCount   = Financial::where('payment_status', 'Overdue')->count();

        return view('financials.index', compact(
            'financials', 'majors', 'statuses',
            'totalFinancial', 'paidCount', 'partialCount', 'overdueCount'
        ));
    }

    public function financialshow($id)
    {
        $student   = Student::findOrFail($id);
        $financial = Financial::where('student_id', $id)->firstOrFail();
        $logs      = PaymentLog::where('student_id', $id)->orderBy('payment_date', 'desc')->take(3)->get();

        return view('financials.show', compact('student', 'financial', 'logs'));
    }

    public function financialhistory($id)
    {
        $student = Student::findOrFail($id);
        $logs    = PaymentLog::where('student_id', $id)->orderBy('payment_date', 'desc')->paginate(10);

        return view('financials.history', compact('student', 'logs'));
    }

    public function financialedit($id)
    {
        $financial = Financial::where('student_id', $id)->firstOrFail();
        $student   = $financial->student;
        $lastLog   = PaymentLog::where('student_id', $id)->orderBy('payment_date', 'desc')->first();
        $isLocked  = $financial->deadline && now()->gt($financial->deadline);

        return view('financials.edit', compact('financial', 'student', 'lastLog', 'isLocked'));
    }

    public function financialupdate(Request $request, $id)
    {
        $financial = Financial::where('student_id', $id)->firstOrFail();

        if ($financial->deadline && now()->gt($financial->deadline)) {
            return back()->withErrors(['locked' => 'Financial period has ended. Records are now closed.']);
        }

        $validated = $request->validate([
            'total_fees'     => 'required|numeric|min:0',
            'amount_paid'    => 'required|numeric|min:0|lte:total_fees',
            'payment_date'   => 'required|date',
            'payment_method' => 'required|in:Cash,Bank Transfer,Online',
        ]);

        $validated['balance_remaining'] = $validated['total_fees'] - $validated['amount_paid'];

        if ($validated['amount_paid'] <= 0) {
            $validated['payment_status'] = 'Unpaid';
        } elseif ($validated['balance_remaining'] <= 0) {
            $validated['payment_status'] = 'Paid';
        } else {
            $validated['payment_status'] = 'Partial';
        }

        $financial->update($validated);

        PaymentLog::create([
            'student_id'     => $financial->student_id,
            'amount_paid'    => $validated['amount_paid'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_status'],
            'payment_date'   => $validated['payment_date'],
        ]);

        SystemHistory::log(
            'Updated Financial Record',
            'Financial',
            "Updated payment for {$financial->student->name} — {$validated['payment_status']} (\${$validated['amount_paid']})",
            'payments'
        );

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
        SystemHistory::log(
            'Exported Financials',
            'Financial',
            'Exported financial records to Excel',
            'download'
        );

        return Excel::download(new FinancialExport, 'Financials_.xlsx');
    }

    public function financialimport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new FinancialImport, $request->file('file'));

        SystemHistory::log(
            'Imported Financials',
            'Financial',
            "Imported financial records from {$request->file('file')->getClientOriginalName()}",
            'upload_file'
        );

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
            'confirm_reset'     => 'required|in:1',
        ]);

        $semesterStart = \Carbon\Carbon::parse($request->semester_start);
        $weeks         = (int) $request->semester_duration;
        $deadline      = $semesterStart->copy()->addMonth();
        $semesterEnd   = $semesterStart->copy()->addWeeks($weeks);

        // Archive existing records if there's payment data before resetting
        $hasPaymentData = Financial::where('amount_paid', '>', 0)->exists();
        if ($hasPaymentData) {
            $rows = Financial::all()->map(fn($f) => [
                'student_id'        => $f->student_id,
                'semester_start'    => $f->semester_start,
                'semester_end'      => $f->semester_end ?? $f->deadline,
                'total_fees'        => $f->total_fees,
                'amount_paid'       => $f->amount_paid,
                'balance_remaining' => $f->balance_remaining,
                'payment_status'    => $f->payment_status,
                'payment_date'      => $f->payment_date,
                'deadline'          => $f->deadline,
            ])->toArray();

            foreach (array_chunk($rows, 500) as $chunk) {
                FinancialHistory::insert($chunk);
            }
        }

        Financial::query()->update([
            'semester_start'    => $semesterStart->format('Y-m-d'),
            'semester_duration' => $weeks,
            'deadline'          => $deadline->format('Y-m-d'),
            'semester_end'      => $semesterEnd->format('Y-m-d'),
            'total_fees'        => 0,
            'amount_paid'       => 0,
            'balance_remaining' => 0,
            'payment_status'    => 'Unpaid',
            'payment_date'      => null,
        ]);

        SystemHistory::log(
            'Set Financial Deadline',
            'Financial',
            "Semester set from {$semesterStart->format('M d, Y')} — deadline {$deadline->format('M d, Y')} ({$weeks} weeks)",
            'event'
        );

        return redirect('/financials')->with('success', 'Deadline set and all records reset successfully!');
    }

    public function financialcleardeadline()
    {
        Financial::query()->update([
            'semester_start'    => null,
            'semester_duration' => null,
            'semester_end'      => null,
            'deadline'          => null,
        ]);

        Financial::where('payment_status', 'Overdue')
            ->update(['payment_status' => 'Unpaid']);

        SystemHistory::log(
            'Cleared Financial Deadline',
            'Financial',
            'Payment deadlines cleared and overdue statuses reverted to Unpaid',
            'event_busy'
        );

        return redirect('/financials')->with('success', 'Payment deadlines cleared successfully!');
    }

    public function financialallhistory(Request $request)
    {
        $majors          = Student::distinct()->pluck('major');
        $paymentStatuses = ['Paid', 'Partial', 'Unpaid', 'Overdue'];

        $semesters = FinancialHistory::select('semester_end')
            ->distinct()
            ->orderByDesc('semester_end')
            ->pluck('semester_end')
            ->groupBy(fn($date) => \Carbon\Carbon::parse($date)->format('Y'))
            ->map(fn($group) => $group->values());

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
            ->paginate(10)
            ->withQueryString();

        return view('financials.all-students-hisitory', compact('majors', 'paymentStatuses', 'histories', 'semesters'));
    }

    public function financialallhistorydelete(Request $request)
    {
        $semesterEnd = $request->query('semester_end');

        if ($semesterEnd) {
            FinancialHistory::where('semester_end', $semesterEnd)->delete();

            SystemHistory::log(
                'Deleted Financial History',
                'Financial',
                "Deleted all financial history records for semester ending {$semesterEnd}",
                'delete'
            );

            return redirect()->route('financials.studenthistory')
                ->with('success', 'All records for the selected semester have been deleted.');
        }

        return redirect()->back()->with('error', 'Invalid semester selected.');
    }
}