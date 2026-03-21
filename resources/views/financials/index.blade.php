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
            <a href="{{ route('financials.deadline') }}">
                <button class="border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-lg">date_range</span>
                    <span>Set Financial Date</span>
                </button>
            </a>
            <form action="{{ route('financials.cleardeadline') }}" method="POST">
                @csrf
                <button class="border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-lg">date_range</span>
                    <span>Cancel Financial Date</span>
                </button>
            </form>
            <a href="{{ route('financials.create') }}">
                <button class="bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-lg">add</span>
                    <span>Add Financial</span>
                </button>
            </a>
        </div>
    </div>

    {{-- Filters --}}
        <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap gap-3 mb-6">
        <form action="/financials" method="get" class="flex flex-wrap gap-3">
            <label class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">
                <select name="major" class="bg-transparent border-none outline-none focus:ring-0 focus:outline-none text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                    <option value="">All Majors</option>
                    @foreach($majors as $major)
                        <option value="{{ $major }}" {{ request('major') == $major ? 'selected' : '' }}>
                            {{ $major }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">
                <select name="status" class="bg-transparent border-none outline-none focus:ring-0 focus:outline-none text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                    <option value="">All Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </label>
        </form>
        
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
                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ $financial->student->email }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Major --}}
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-xs font-medium">{{ $financial->student->major }}</span>
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
    <script>
        document.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', () => {
                select.closest('form').submit();
            });
        });
    </script>
</x-layouts.master>