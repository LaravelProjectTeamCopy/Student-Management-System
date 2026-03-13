<x-layouts.master title="Financials">

    {{-- Page Title + Actions --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Student Financials</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Track tuition fees, payments, and outstanding balances.</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap gap-3 mb-6">

        <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
            <span>Major: All Majors</span>
            <span class="material-symbols-outlined text-lg">expand_more</span>
        </button>

        <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
            <span>Status: All</span>
            <span class="material-symbols-outlined text-lg">expand_more</span>
        </button>

        <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
            <span>Year: 2025-2026</span>
            <span class="material-symbols-outlined text-lg">calendar_month</span>
        </button>

        <div class="ml-auto flex items-center gap-2">
            <button class="p-2 text-slate-500 hover:text-primary">
                <span class="material-symbols-outlined">filter_list</span>
            </button>
            <button class="p-2 text-slate-500 hover:text-primary">
                <span class="material-symbols-outlined">download</span>
            </button>
        </div>

    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                {{-- Table Head --}}
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Student Name</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Major</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Fees Due</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Amount Paid</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Balance Remaining</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Payment Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Payment Date</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                    @foreach ($financials as $financial)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">

                        {{-- Student Name + ID --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold uppercase shrink-0">
                                    {{ strtoupper(substr($financial->student->name, 0, 1)) }}{{ strtoupper(substr(strrchr($financial->student->name, ' '), 1, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $financial->student->name }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ $financial->student->student_id }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Major --}}
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-xs font-medium">{{ $financial->major }}</span>
                        </td>

                        {{-- Total Fees --}}
                        <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">
                            ${{ number_format($financial->total_fees, 2) }}
                        </td>

                        {{-- Amount Paid --}}
                        <td class="px-6 py-4 text-sm font-medium text-emerald-600">
                            ${{ number_format($financial->amount_paid, 2) }}
                        </td>

                        {{-- Balance Remaining --}}
                        <td class="px-6 py-4 text-sm font-medium {{ $financial->balance_remaining > 0 ? 'text-red-500' : 'text-emerald-600' }}">
                            ${{ number_format($financial->balance_remaining, 2) }}
                        </td>

                        {{-- Payment Status --}}
                        <td class="px-6 py-4">
                            @if ($financial->payment_status === 'Paid')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>Paid
                                </span>
                            @elseif ($financial->payment_status === 'Partial')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                    <span class="size-1.5 rounded-full bg-amber-500"></span>Partial
                                </span>
                            @elseif ($financial->payment_status === 'Unpaid')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                    <span class="size-1.5 rounded-full bg-slate-400"></span>Unpaid
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    <span class="size-1.5 rounded-full bg-red-500"></span>Overdue
                                </span>
                            @endif
                        </td>

                        {{-- Payment Date --}}
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                            {{ $financial->payment_date ? $financial->payment_date->format('M d, Y') : '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                            <a href="{{ route('financials.show', $financial->student_id) }}" class="text-primary font-semibold text-sm hover:underline flex items-center gap-1 justify-end ml-auto">
                                View Profile
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4">
            {{ $financials->links() }}
        </div>

    </div>

</x-layouts.master>