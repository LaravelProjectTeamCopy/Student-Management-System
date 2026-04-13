<x-layouts.master title="Student Directory">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome']" current="Student Directory" />
    </x-slot>

    <x-slot name="search">
        <x-search
            action="{{ route('students.index') }}"
            placeholder="Search students..."
        />
    </x-slot>

    {{-- Page Title + Actions --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Student Directory</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Manage and view all enrolled students across majors and years.</p>
        </div>
        <div class="flex items-center gap-3 ml-auto">
            <a href="{{ route('students.create') }}">
                <button class="border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-white dark:hover:bg-slate-800 hover:border-primary/30 hover:shadow-md transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">person_add</span>
                    <span>Add Student</span>
                </button>
            </a>
            <a href="{{ route('students.import') }}">
                <button class="border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-white dark:hover:bg-slate-800 hover:border-primary/30 hover:shadow-md transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">upload_file</span>
                    <span>Import</span>
                </button>
            </a>
            <button class="bg-slate-900 dark:bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-slate-800 dark:hover:bg-slate-700 hover:shadow-lg transition-all active:scale-95">
                <span class="material-symbols-outlined text-lg">download</span>
                <span>Export</span>
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap items-center gap-6 mb-6 shadow-sm">

        {{-- Year --}}
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Year:</span>
            <div class="flex gap-1.5">
                <a href="?year=&major={{ $currentMajor }}&status={{ $currentStatus }}"
                   class="px-3 py-1.5 rounded-lg border text-xs font-bold transition-all
                   {{ $currentYear == '' 
                       ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 border-slate-900 dark:border-white shadow-sm'
                       : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:border-slate-300' }}">
                    All Years
                </a>
                @foreach($years as $year)
                    @if($year) {{-- Skip null/empty values --}}
                    <a href="?year={{ $year }}&major={{ $currentMajor }}&status={{ $currentStatus }}"
                       class="px-3 py-1.5 rounded-lg border text-xs font-bold transition-all
                       {{ $currentYear == $year
                           ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 border-slate-900 dark:border-white shadow-sm'
                           : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:border-slate-300' }}">
                        {{ $year }}
                    </a>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="h-8 w-px bg-slate-200 dark:bg-slate-800"></div>

        {{-- Status --}}
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Status:</span>
            <div class="flex gap-1.5">
                <a href="?status=&year={{ $currentYear }}&major={{ $currentMajor }}"
                   class="px-3 py-1.5 rounded-full border text-xs font-bold transition-all
                   {{ $currentStatus == ''
                       ? 'bg-primary text-white border-primary'
                       : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    All
                </a>
                @foreach($statuses as $status)
                    <a href="?status={{ $status }}&year={{ $currentYear }}&major={{ $currentMajor }}"
                       class="px-3 py-1.5 rounded-full border text-xs font-bold transition-all
                       {{ $currentStatus == $status
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

        {{-- Total Students --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg">groups</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Total Students</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ $totalStudents ?? 0 }}</p>
            </div>
            <p class="text-xs font-medium text-blue-600 dark:text-blue-400">All majors</p>
        </div>

        {{-- Active Students --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-lg">verified</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Active Students</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ $activeStudents ?? 0 }}</p>
            </div>
            <div class="h-1 bg-emerald-100 dark:bg-emerald-900/30 rounded-full overflow-hidden">
                @php $activePct = ($totalStudents ?? 0) > 0 ? round((($activeStudents ?? 0) / $totalStudents) * 100) : 0; @endphp
                <div class="h-full bg-emerald-500 rounded-full transition-all duration-700" style="width: {{ $activePct }}%"></div>
            </div>
        </div>

        {{-- New This Month --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-500 dark:text-amber-400 text-lg">person_add</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">New This Month</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ $newThisMonth ?? 0 }}</p>
            </div>
            <p class="text-xs font-medium text-amber-500 dark:text-amber-400">Recently enrolled</p>
        </div>

        {{-- Graduated --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-violet-50 dark:bg-violet-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-violet-500 dark:text-violet-400 text-lg">school</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Graduated</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ $graduated ?? 0 }}</p>
            </div>
            <div class="h-1 bg-violet-100 dark:bg-violet-900/30 rounded-full overflow-hidden">
                @php $gradPct = ($totalStudents ?? 0) > 0 ? round((($graduated ?? 0) / $totalStudents) * 100) : 0; @endphp
                <div class="h-full bg-violet-500 rounded-full transition-all duration-700" style="width: {{ $gradPct }}%"></div>
            </div>
        </div>

    </div>

    {{-- Major Tabs --}}
    <div class="border-b border-slate-200 dark:border-slate-800 mb-6 overflow-x-auto">
        <div class="flex gap-0 min-w-max">
            @foreach($majors as $m)
                <a href="?major={{ $m }}&year={{ $currentYear }}&status={{ $currentStatus }}"
                   class="px-5 py-3 text-sm font-bold border-b-2 transition-colors whitespace-nowrap
                   {{ $currentMajor == $m
                       ? 'border-primary text-primary'
                       : 'border-transparent text-slate-400 hover:text-slate-600 dark:hover:text-slate-300' }}">
                    {{ strtoupper($m) }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Student Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Student</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Student ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Major</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Year</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($students as $student)
                        @php
                            $statusClasses = [
                                'Active'    => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                'Inactive'  => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                'Graduated' => 'bg-violet-100 text-violet-800 dark:bg-violet-900/30 dark:text-violet-300',
                            ];
                            $dotClasses = [
                                'Active'    => 'bg-emerald-500',
                                'Inactive'  => 'bg-red-500',
                                'Graduated' => 'bg-violet-500',
                            ];
                            $statusLabel = $student->status ?? 'Active';
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all group">

                            {{-- Student Name + Email --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold uppercase shrink-0 transition-transform group-hover:scale-110">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}{{ strtoupper(substr(strrchr($student->name, ' '), 1, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                            {{ $student->name }}
                                        </span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">{{ $student->email }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Student ID --}}
                            <td class="px-6 py-4 text-sm font-medium text-slate-600 dark:text-slate-400">
                                {{ $student->id }}
                            </td>

                            {{-- Major --}}
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-bold uppercase">
                                    {{ $student->major }}
                                </span>
                            </td>

                            {{-- Enrollment Year --}}
                            <td class="px-6 py-4 text-sm font-medium text-slate-600 dark:text-slate-400">
                                {{ $student->academic_year }}
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $statusClasses[$statusLabel] ?? $statusClasses['Active'] }}">
                                    <span class="size-1.5 rounded-full {{ $dotClasses[$statusLabel] ?? $dotClasses['Active'] }}"></span>
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('students.show', $student->id) }}"
                                   class="inline-flex items-center gap-1 text-primary font-bold text-xs hover:gap-2 transition-all active:scale-95 group/link">
                                    VIEW PROFILE
                                    <span class="material-symbols-outlined text-sm transition-transform group-hover/link:translate-x-0.5">arrow_forward</span>
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 dark:text-slate-600 text-sm">
                                <span class="material-symbols-outlined text-4xl block mb-2 opacity-20">search_off</span>
                                No students found for the selected filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 flex justify-between items-center flex-wrap gap-3">
            <p class="text-[11px] text-slate-400 font-medium">
                Showing students in
                <span class="font-bold text-slate-600 dark:text-slate-300">{{ $currentMajor ?: 'All Majors' }}</span>
                ·
                <span class="font-bold text-slate-600 dark:text-slate-300">{{ $currentStatus ?: 'All Statuses' }}</span>
                ·
                <span class="font-bold text-slate-600 dark:text-slate-300">{{ $currentYear }}</span>
            </p>
            <div>{{ $students->links() }}</div>
        </div>
    </div>

</x-layouts.master>