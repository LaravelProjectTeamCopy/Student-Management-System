<x-layouts.master title="Academic Scores">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome']" current="Academic Scores" />
    </x-slot>

    <x-slot name="search">
        <x-search
            action="{{ route('academicrecords.index') }}"
            placeholder="Search student scores..."
        />
    </x-slot>

    {{-- Page Title + Actions --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Academic Scores</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Grade management across all years, semesters, and majors.</p>
        </div>
        <div class="flex items-center gap-3 ml-auto">
            <a href="{{ route('academicrecords.import') }}">
                <button class="border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-white dark:hover:bg-slate-800 hover:border-primary/30 hover:shadow-md transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">add</span>
                    <span>Add Score</span>
                </button>
            </a>
            <a href="{{ route('academicrecords.subject') }}">
                <button class="border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-white dark:hover:bg-slate-800 hover:border-primary/30 hover:shadow-md transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">add</span>
                    <span>Add Subject</span>
                </button>
            </a>
            <button class="bg-slate-900 dark:bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-slate-800 dark:hover:bg-slate-700 hover:shadow-lg transition-all active:scale-95">
                <span class="material-symbols-outlined text-lg">download</span>
                <span>Export Report</span>
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap items-center gap-6 mb-6 shadow-sm">

        {{-- Year --}}
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Year:</span>
            <div class="flex gap-1.5">
                @foreach(['2023/2024', '2024/2025', '2025/2026'] as $year)
                    <a href="?year={{ $year }}&semester={{ $currentSem }}&major={{ $currentMajor }}"
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

        {{-- Semester --}}
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Semester:</span>
            <div class="flex gap-1.5">
                @foreach(['Semester 1', 'Semester 2'] as $sem)
                    <a href="?semester={{ $sem }}&year={{ $currentYear }}&major={{ $currentMajor }}"
                       class="px-3 py-1.5 rounded-full border text-xs font-bold transition-all
                       {{ $currentSem == $sem
                           ? 'bg-primary text-white border-primary'
                           : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        {{ $sem }}
                    </a>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

        {{-- Class Average --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg">analytics</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Class Average</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ number_format($classAvg ?? 0, 1) }}</p>
            </div>
            <div class="h-1 bg-blue-100 dark:bg-blue-900/30 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500 rounded-full transition-all duration-700" style="width: {{ min($classAvg ?? 0, 100) }}%"></div>
            </div>
        </div>

        {{-- Passing Rate --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-lg">verified</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Passing Rate</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ $passingRate ?? 0 }}%</p>
            </div>
            <div class="h-1 bg-emerald-100 dark:bg-emerald-900/30 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500 rounded-full transition-all duration-700" style="width: {{ $passingRate ?? 0 }}%"></div>
            </div>
        </div>

        {{-- At Risk Students --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-red-500 dark:text-red-400 text-lg">warning</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">At Risk Students</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ $atRisk ?? 0 }}</p>
            </div>
            <p class="text-xs font-medium text-red-500 dark:text-red-400">Needs attention</p>
        </div>

        {{-- Highest Score --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-500 dark:text-amber-400 text-lg">trophy</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Highest Score</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ number_format($topScore ?? 0, 1) }}</p>
            </div>
            <p class="text-xs font-medium text-amber-500 dark:text-amber-400">Top performer</p>
        </div>

    </div>

    {{-- Major Tabs --}}
    <div class="border-b border-slate-200 dark:border-slate-800 mb-6 overflow-x-auto">
        <div class="flex gap-0 min-w-max">
            @foreach($majors as $m)
                <a href="?major={{ $m }}&year={{ $currentYear }}&semester={{ $currentSem }}"
                   class="px-5 py-3 text-sm font-bold border-b-2 transition-colors whitespace-nowrap
                   {{ $currentMajor == $m
                       ? 'border-primary text-primary'
                       : 'border-transparent text-slate-400 hover:text-slate-600 dark:hover:text-slate-300' }}">
                    {{ strtoupper($m) }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Score Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Student</th>
                        @foreach($subjects as $subject)
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">
                                {{ $subject->name }}
                            </th>
                        @endforeach
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-left">Avg</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($academicrecords as $academicrecord)
                        @php
                            $studentScores   = $academicrecord->scores ?? collect();
                            $scoresBySubject = $studentScores->keyBy('subject_id');
                            $studentAvg      = $studentScores->count() > 0
                                                ? $studentScores->avg('total_score')
                                                : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all group">

                            {{-- Student --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold uppercase shrink-0 transition-transform group-hover:scale-110">
                                        {{ strtoupper(substr($academicrecord->name, 0, 1)) }}{{ strtoupper(substr(strrchr($academicrecord->name, ' '), 1, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                            {{ $academicrecord->name }}
                                        </span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">
                                            ID: {{ $academicrecord->id }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Dynamic subject columns --}}
                            @foreach($subjects as $subject)
                                @php
                                    $score      = $scoresBySubject[$subject->id]->total_score ?? null;
                                    $scoreColor = match(true) {
                                        $score === null => 'text-slate-400',
                                        $score < 50     => 'text-red-500',
                                        $score >= 85    => 'text-emerald-500',
                                        default         => 'text-slate-700 dark:text-slate-300',
                                    };
                                @endphp
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-bold {{ $scoreColor }}">
                                        {{ $score !== null ? number_format($score, 0) : '—' }}
                                    </span>
                                </td>
                            @endforeach

                            {{-- Average + progress bar --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-20 h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-700
                                            {{ $studentAvg < 50 ? 'bg-red-500' : ($studentAvg >= 80 ? 'bg-emerald-500' : 'bg-primary') }}"
                                             style="width: {{ min($studentAvg, 100) }}%">
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-slate-700 dark:text-slate-300">
                                        {{ number_format($studentAvg, 1) }}
                                    </span>
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('academicrecords.show', $academicrecord->id) }}"
                                   class="inline-flex items-center gap-1 text-primary font-bold text-xs hover:gap-2 transition-all active:scale-95 group/link">
                                    VIEW DETAILS
                                    <span class="material-symbols-outlined text-sm transition-transform group-hover/link:translate-x-0.5">arrow_forward</span>
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $subjects->count() + 3 }}"
                                class="px-6 py-12 text-center text-slate-400 dark:text-slate-600 text-sm">
                                <span class="material-symbols-outlined text-4xl block mb-2 opacity-20">search_off</span>
                                No records found for the selected filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 flex justify-between items-center flex-wrap gap-3">
            <p class="text-[11px] text-slate-400 font-medium">
                Showing performance for
                <span class="font-bold text-slate-600 dark:text-slate-300">{{ $currentMajor }}</span>
                ·
                <span class="font-bold text-slate-600 dark:text-slate-300">{{ $currentSem }}</span>
                ·
                <span class="font-bold text-slate-600 dark:text-slate-300">{{ $currentYear }}</span>
            </p>
            <div>{{ $academicrecords->links() }}</div>
        </div>
    </div>

</x-layouts.master>