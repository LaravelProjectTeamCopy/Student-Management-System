<x-layouts.master title="Financials">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome']" current="Financials" />
    </x-slot>

    <x-slot name="search">
        <x-search
            action="{{ route('financials.index') }}"
            placeholder="Search financial records..."
        />
    </x-slot>

    {{-- Page Title + Actions --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Student Financials</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Monitor and manage student financial records.</p>
        </div>
        <div class="flex items-center gap-3 ml-auto">
            <a href="{{ route('financials.deadline') }}" class="group">
                <button class="border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-white dark:hover:bg-slate-800 hover:border-primary/30 hover:shadow-md transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg group-hover:text-primary transition-colors">date_range</span>
                    <span>Set Financial Date</span>
                </button>
            </a>
            <form action="{{ route('financials.cleardeadline') }}" method="POST">
                @csrf
                <button class="border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-red-50 dark:hover:bg-red-900/10 hover:text-red-600 hover:border-red-200 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">event_busy</span>
                    <span>Cancel Financial Date</span>
                </button>
            </form>
            <a href="{{ route('financials.studenthistory') }}">
                <button class="bg-slate-900 dark:bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-slate-800 dark:hover:bg-slate-700 hover:shadow-lg transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">history</span>
                    <span>Financial History</span>
                </button>
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap items-center gap-6 mb-6 shadow-sm">

        {{-- Year --}}
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Year:</span>
            <div class="flex gap-1.5">
                @foreach(['2023/2024', '2024/2025', '2025/2026'] as $year)
                    <a href="?year={{ $year }}&status={{ request('status') }}&major={{ request('major') }}"
                       class="px-3 py-1.5 rounded-lg border text-xs font-bold transition-all
                       {{ request('year', '2025/2026') == $year
                           ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 border-slate-900 dark:border-white shadow-sm'
                           : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:border-slate-300' }}">
                        {{ $year }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="h-8 w-px bg-slate-200 dark:bg-slate-800"></div>

        {{-- Status --}}
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Status:</span>
            <div class="flex gap-1.5">
                @foreach(['Paid', 'Partial', 'Unpaid', 'Overdue'] as $status)
                    <a href="?status={{ $status }}&year={{ request('year', '2025/2026') }}&major={{ request('major') }}"
                       class="px-3 py-1.5 rounded-full border text-xs font-bold transition-all
                       {{ request('status') == $status
                           ? 'bg-primary text-white border-primary'
                           : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        {{ $status }}
                    </a>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3">
            <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg">receipt_long</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Total Records</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ $totalFinancial }}</p>
            </div>
            <p class="text-xs font-medium text-blue-600 dark:text-blue-400">All semesters</p>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3">
            <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-lg">check_circle</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Paid</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ $paidCount }}</p>
            </div>
            <div class="h-1 bg-emerald-100 dark:bg-emerald-900/30 rounded-full overflow-hidden">
                @php $paidPct = $totalFinancial > 0 ? round(($paidCount / $totalFinancial) * 100) : 0; @endphp
                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $paidPct }}%"></div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-500 dark:text-amber-400 text-lg">hourglass_empty</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Partial</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ $partialCount }}</p>
            </div>
            <div class="h-1 bg-amber-100 dark:bg-amber-900/30 rounded-full overflow-hidden">
                @php $partialPct = $totalFinancial > 0 ? round(($partialCount / $totalFinancial) * 100) : 0; @endphp
                <div class="h-full bg-amber-400 rounded-full" style="width: {{ $partialPct }}%"></div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3">
            <div class="w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-red-500 dark:text-red-400 text-lg">cancel</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Overdue</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ $overdueCount }}</p>
            </div>
            <div class="h-1 bg-red-100 dark:bg-red-900/30 rounded-full overflow-hidden">
                @php $overduePct = $totalFinancial > 0 ? round(($overdueCount / $totalFinancial) * 100) : 0; @endphp
                <div class="h-full bg-red-500 rounded-full" style="width: {{ $overduePct }}%"></div>
            </div>
        </div>

    </div>

    {{-- Major Tabs --}}
    <div class="border-b border-slate-200 dark:border-slate-800 mb-6 overflow-x-auto">
        <div class="flex gap-0 min-w-max">
            @foreach($majors as $major)
                <a href="?major={{ $major }}&year={{ request('year', '2025/2026') }}&status={{ request('status') }}"
                   class="px-5 py-3 text-sm font-bold border-b-2 transition-colors whitespace-nowrap
                   {{ request('major') == $major
                       ? 'border-primary text-primary'
                       : 'border-transparent text-slate-400 hover:text-slate-600 dark:hover:text-slate-300' }}">
                    {{ strtoupper($major) }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Student Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Major</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Total Due</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Paid</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Balance</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($financials as $financial)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold uppercase transition-transform group-hover:scale-110">
                                    {{ strtoupper(substr($financial->student->name, 0, 1)) }}{{ strtoupper(substr(strrchr($financial->student->name, ' '), 1, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-primary transition-colors">{{ $financial->student->name }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ $financial->student->email }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-bold uppercase">{{ $financial->student->major }}</span>
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">
                            ${{ number_format($financial->total_fees, 2) }}
                        </td>

                        <td class="px-6 py-4 text-sm font-bold text-emerald-600">
                            ${{ number_format($financial->amount_paid, 2) }}
                        </td>

                        <td class="px-6 py-4 text-sm font-bold {{ $financial->balance_remaining > 0 ? 'text-red-500' : 'text-emerald-600' }}">
                            ${{ number_format($financial->balance_remaining, 2) }}
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $currentStatus = $financial->payment_status;
                                $statusClasses = [
                                    'Paid'    => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                    'Partial' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                    'Unpaid'  => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400',
                                    'Overdue' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                ];
                                $dotColors = [
                                    'Paid'    => 'bg-emerald-500',
                                    'Partial' => 'bg-amber-500',
                                    'Unpaid'  => 'bg-slate-400',
                                    'Overdue' => 'bg-red-500',
                                ];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $statusClasses[$currentStatus] ?? '' }}">
                                <span class="size-1.5 rounded-full {{ $dotColors[$currentStatus] ?? 'bg-slate-400' }}"></span>
                                {{ $currentStatus }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                            {{ $financial->payment_date ? $financial->payment_date->format('M d, Y') : '—' }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('financials.show', $financial->student_id) }}"
                               class="inline-flex items-center gap-1 text-primary font-bold text-xs hover:gap-2 transition-all active:scale-95">
                                VIEW PROFILE
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30">
            {{ $financials->links() }}
        </div>
    </div>

</x-layouts.master>