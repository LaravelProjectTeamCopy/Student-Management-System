<x-layouts.master title="{{ $student->name }} â€” Academic Record">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/dashboard', 'Academic Records' => route('academicrecords.index')]" current="{{ $student->name }}" />
    </x-slot>

    {{-- Student Header --}}
    <div class="mb-8 flex flex-col items-start justify-between gap-6 rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900 border border-slate-200 dark:border-slate-800 lg:flex-row lg:items-center">
        <div class="flex items-center gap-6">
            <div class="h-20 w-20 rounded-full ring-4 ring-slate-50 dark:ring-slate-800 bg-primary/10 flex items-center justify-center text-primary text-xl font-bold uppercase">
                {{ strtoupper(substr($student->name, 0, 1)) }}{{ strtoupper(substr(strrchr($student->name, ' ') ?: '', 1, 1)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $student->name }}</h2>
                <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1">
                    <span class="text-sm text-slate-500">{{ $student->student_code ?? '' }}</span>
                    <span class="text-sm text-slate-500">{{ $student->email }}</span>
                    <span class="inline-block px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase">
                        {{ $student->major }}
                    </span>
                </div>
            </div>
        </div>
        <a href="{{ route('students.show', $student->id) }}" class="flex items-center gap-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <span class="material-symbols-outlined text-sm">person</span>
            View Full Profile
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap items-center gap-6 mb-6 shadow-sm">
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Year:</span>
            <div class="flex gap-1.5">
                @foreach(['2023/2024', '2024/2025', '2025/2026'] as $year)
                    <a href="?year={{ $year }}&semester={{ $currentSem }}"
                       class="px-3 py-1.5 rounded-lg border text-xs font-bold transition-all
                       {{ $currentYear == $year
                           ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 border-slate-900 dark:border-white shadow-sm'
                           : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:border-slate-300' }}">
                        {{ $year }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="h-8 w-px bg-slate-200 dark:bg-slate-800"></div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Semester:</span>
            <div class="flex gap-1.5">
                @foreach(['Semester 1', 'Semester 2'] as $sem)
                    <a href="?semester={{ $sem }}&year={{ $currentYear }}"
                       class="px-3 py-1.5 rounded-lg border text-xs font-bold transition-all
                       {{ $currentSem == $sem
                           ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 border-slate-900 dark:border-white shadow-sm'
                           : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:border-slate-300' }}">
                        {{ $sem }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Stats Row --}}
    @php
        $totalSubjects = $filteredScores->count();
        $passed = $filteredScores->where('total_score', '>=', 50)->count();
        $failed = $filteredScores->where('total_score', '<', 50)->count();
        $highest = $filteredScores->max('total_score') ?? 0;

        $stats = [
            ['label' => 'Average Score',   'val' => number_format($avgScore, 1),  'icon' => 'analytics',  'color' => 'text-primary'],
            ['label' => 'Subjects Taken',  'val' => $totalSubjects,               'icon' => 'menu_book',  'color' => 'text-blue-500'],
            ['label' => 'Passed',          'val' => $passed,                       'icon' => 'verified',   'color' => 'text-emerald-500'],
            ['label' => 'Failed',          'val' => $failed,                       'icon' => 'warning',    'color' => 'text-red-500'],
            ['label' => 'Highest Score',   'val' => number_format($highest, 1),   'icon' => 'trophy',     'color' => 'text-amber-500'],
        ];
    @endphp
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-6">
        @foreach($stats as $stat)
        <div class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ $stat['label'] }}</p>
                <span class="material-symbols-outlined text-lg {{ $stat['color'] }}">{{ $stat['icon'] }}</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stat['val'] }}</h3>
        </div>
        @endforeach
    </div>

    {{-- Scores Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="p-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">school</span>
            <h3 class="text-base font-bold text-slate-900 dark:text-white">Subject Scores â€” {{ $currentSem }}, {{ $currentYear }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Subject</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Attendance</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Quiz</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Midterm</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Final Exam</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Total</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Grade</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($filteredScores as $score)
                        @php
                            $total = $score->total_score ?? 0;
                            $grade = match(true) {
                                $total >= 90 => ['A+', 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 dark:text-emerald-400'],
                                $total >= 80 => ['A',  'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 dark:text-emerald-400'],
                                $total >= 70 => ['B',  'text-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400'],
                                $total >= 60 => ['C',  'text-amber-600 bg-amber-50 dark:bg-amber-900/20 dark:text-amber-400'],
                                $total >= 50 => ['D',  'text-orange-600 bg-orange-50 dark:bg-orange-900/20 dark:text-orange-400'],
                                default      => ['F',  'text-red-600 bg-red-50 dark:bg-red-900/20 dark:text-red-400'],
                            };
                            $scoreColor = $total < 50 ? 'text-red-500' : ($total >= 80 ? 'text-emerald-500' : 'text-slate-700 dark:text-slate-300');
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $score->subject->name ?? 'â€”' }}</span>
                                    <span class="text-xs text-slate-400">{{ $score->subject->subject_code ?? '' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-bold {{ $scoreColor }}">{{ $score->attendance ?? 'â€”' }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold {{ $scoreColor }}">{{ $score->quiz ?? 'â€”' }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold {{ $scoreColor }}">{{ $score->midterm ?? 'â€”' }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold {{ $scoreColor }}">{{ $score->final_exam ?? 'â€”' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold {{ $scoreColor }}">{{ number_format($total, 1) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $grade[1] }}">{{ $grade[0] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 dark:text-slate-600 text-sm">
                                <span class="material-symbols-outlined text-4xl block mb-2 opacity-20">search_off</span>
                                No scores recorded for this semester.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($filteredScores->count() > 0)
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20 flex justify-between items-center">
            <p class="text-[11px] text-slate-400 font-medium">
                Showing <span class="font-bold text-slate-600 dark:text-slate-300">{{ $filteredScores->count() }}</span> subjects
            </p>
            <p class="text-sm font-bold {{ $avgScore >= 50 ? 'text-emerald-500' : 'text-red-500' }}">
                Overall Average: {{ number_format($avgScore, 1) }}
            </p>
        </div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('academicrecords.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Back to Academic Records
        </a>
    </div>

</x-layouts.master>
