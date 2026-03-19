<x-layouts.master title="Student Attendance">

    {{-- Page Header --}}
    <div class="mb-8 flex flex-col items-start justify-between gap-6 rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900 lg:flex-row lg:items-center">
        <div class="flex items-center gap-6">
            <div class="h-24 w-24 rounded-full ring-4 ring-slate-50 dark:ring-slate-800 bg-primary/10 flex items-center justify-center text-primary text-2xl font-bold uppercase">
                {{ strtoupper(substr($student->name, 0, 1)) }}{{ strtoupper(substr(strrchr($student->name, ' '), 1, 1)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold">{{$student->name}}</h2>
                <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1">
                    <span class="text-sm text-slate-500">{{$student->id}}</span>
                    <span class="flex items-center gap-1 text-sm font-medium text-emerald-600">
                        <span class="size-2 rounded-full bg-emerald-600"></span>
                        Active
                    </span>
                </div>
            </div>
        </div>
        <div class="flex w-full gap-3 lg:w-auto">
            <button class="flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 lg:flex-none transition-colors">
                <span class="material-symbols-outlined text-sm">print</span>
                Print Report
            </button>
            <a href="{{ route('attendance.edit', $attendance->student_id) }}">
                <button class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-bold text-slate-900 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-100 lg:flex-none transition-colors">
                    <span class="material-symbols-outlined text-sm">edit</span>
                    Edit Record
                </button>
            </a>
            <button class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-bold text-white hover:bg-primary/90 lg:flex-none transition-colors">
                <span class="material-symbols-outlined text-sm">edit_calendar</span>
                Mark Attendance
            </button>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        {{-- Left / Middle --}}
        <div class="lg:col-span-2 flex flex-col gap-8">

            {{-- Attendance Summary Cards --}}
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">calendar_month</span>
                    <h3 class="text-lg font-bold">Attendance Overview</h3>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Days</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">{{ $attendance->total_days }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Present</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-600">{{ $attendance->present_days }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Absent</p>
                        <p class="mt-1 text-2xl font-bold text-red-500">{{ $attendance->absent_days }}</p>
                    </div>
                </div>

                {{-- Progress Bar --}}
                @php $pct = $attendance->total_days > 0 ? round(($attendance->present_days / $attendance->total_days) * 100) : 0; @endphp
                <div class="mt-6">
                    <div class="flex justify-between text-xs font-medium text-slate-500 mb-1.5">
                        <span>Attendance Rate</span>
                        <span>{{ $pct }}% Present</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $pct >= 75 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            </section>

            {{-- Attendance Details --}}
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <h3 class="text-lg font-bold">Attendance Details</h3>
                </div>
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Status</p>
                        @if ($pct >= 75)
                            <span class="mt-1 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                <span class="size-1.5 rounded-full bg-emerald-500"></span>Good
                            </span>
                        @elseif ($pct >= 50)
                            <span class="mt-1 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                <span class="size-1.5 rounded-full bg-amber-500"></span>At Risk
                            </span>
                        @else
                            <span class="mt-1 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                <span class="size-1.5 rounded-full bg-red-500"></span>Critical
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Major</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{ $student->major }}</p>
                    </div>
                </div>
            </section>

        </div>

        {{-- Right Side - Attendance Log --}}
        <div class="lg:col-span-1">
            <section class="h-full rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history</span>
                    <h3 class="text-lg font-bold">Attendance Log</h3>
                </div>

                <div class="flex flex-col gap-6">
                    @forelse($logs as $log)
                        <div class="relative flex gap-4 pb-2">
                            <div class="absolute left-4 top-8 h-full w-px bg-slate-200 dark:bg-slate-800"></div>
                            <div class="relative z-10 flex size-12 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                <span class="material-symbols-outlined text-2xl">calendar_month</span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-sm font-semibold">Attendance Updated</p>
                                <p class="text-xs text-slate-500">Present: {{ $log->present_days }} / {{ $log->total_days }} days</p>
                                <p class="text-xs text-slate-500">Absent: {{ $log->absent_days }} days</p>
                                <p class="text-xs text-slate-500">Status: {{ $log->status }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $log->log_date ? $log->log_date->format('M d, Y') : '—' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">No attendance history yet.</p>
                    @endforelse
                </div>

            </section>
        </div>

    </div>
    
</x-layouts.master>