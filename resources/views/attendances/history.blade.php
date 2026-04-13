<x-layouts.master title="Attendance History">
    
    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/dashboard', 'Attendances' => route('attendances.index') ,'History' => route('attendances.history', $student->id)]" current="{{ $student->name }}" />
    </x-slot>
    
    {{-- Page Header --}}
    <div class="mb-8 flex flex-col items-start justify-between gap-6 rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900 lg:flex-row lg:items-center">
        <div class="flex items-center gap-6">
            <div class="h-16 w-16 rounded-full ring-4 ring-slate-50 dark:ring-slate-800 bg-primary/10 flex items-center justify-center text-primary text-xl font-bold uppercase">
                {{ strtoupper(substr($student->name, 0, 1)) }}{{ strtoupper(substr(strrchr($student->name, ' '), 1, 1)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold">{{ $student->name }}</h2>
                <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1">
                    <span class="text-sm text-slate-500">#{{ $student->id }}</span>
                    <span class="text-sm text-slate-500">{{ $student->major }}</span>
                </div>
            </div>
        </div>
        <a href="{{ route('attendances.show', $student->id) }}">
            <button class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 transition-colors">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back to Attendance
            </button>
        </a>
    </div>

    {{-- History Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">

        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">history</span>
            <h3 class="text-lg font-bold">Full Attendance History</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Days</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Present</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Absent</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Note</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">{{ $log->total_days }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-emerald-600">{{ $log->present_days }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-red-500">{{ $log->absent_days }}</td>
                            <td class="px-6 py-4">
                                @if($log->status === 'Good')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <span class="size-1.5 rounded-full bg-emerald-500"></span>Good
                                    </span>
                                @elseif($log->status === 'At Risk')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                        <span class="size-1.5 rounded-full bg-amber-500"></span>At Risk
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <span class="size-1.5 rounded-full bg-red-500"></span>Critical
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $log->log_date ? $log->log_date->format('M d, Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $log->note ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-slate-400">No attendance history yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4">
            {{ $logs->links() }}
        </div>

    </div>

</x-layouts.master>