<x-layouts.master title="Attendance">

    {{-- Page Title + Actions --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Student Attendance</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Monitor and manage student attendance records.</p>
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
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Days</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Present</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Absent</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Attendance %</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                    @foreach ($attendances as $attendance)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">

                        {{-- Student Name --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold uppercase shrink-0">
                                    {{ strtoupper(substr($attendance->student->name, 0, 1)) }}{{ strtoupper(substr(strrchr($attendance->student->name, ' '), 1, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $attendance->student->name }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">#{{ $attendance->student->id }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Major --}}
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-xs font-medium">{{ $attendance->student->major }}</span>
                        </td>

                        {{-- Total Days --}}
                        <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">
                            {{ $attendance->total_days }}
                        </td>

                        {{-- Present --}}
                        <td class="px-6 py-4 text-sm font-medium text-emerald-600">
                            {{ $attendance->present_days }}
                        </td>

                        {{-- Absent --}}
                        <td class="px-6 py-4 text-sm font-medium text-red-500">
                            {{ $attendance->absent_days }}
                        </td>

                        {{-- Attendance % + Progress Bar --}}
                        <td class="px-6 py-4">
                            @php $pct = $attendance->total_days > 0 ? round(($attendance->present_days / $attendance->total_days) * 100) : 0; @endphp
                            <div class="flex items-center gap-2">
                                <div class="w-20 h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $pct >= 75 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $pct }}%</span>
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if ($pct >= 75)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>Good
                                </span>
                            @elseif ($pct >= 50)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                    <span class="size-1.5 rounded-full bg-amber-500"></span>At Risk
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    <span class="size-1.5 rounded-full bg-red-500"></span>Critical
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4">
                            <a href="{{ route('attendance.show', $attendance->student_id) }}" class="text-primary font-semibold text-sm hover:underline flex items-center gap-1">
                                View Details
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
            {{ $attendances->links() }}
        </div>

    </div>

</x-layouts.master>