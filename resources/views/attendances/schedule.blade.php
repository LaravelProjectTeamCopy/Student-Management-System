<x-layouts.master title="Subject Schedule">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome', 'Attendances' => route('attendances.index')]" current="Subject Schedule" />
    </x-slot>

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Subject Schedule</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Assign subjects to days. Students absent 3+ times on a day fail that subject.</p>
        </div>
        <a href="{{ route('attendances.index') }}">
            <button class="border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-white dark:hover:bg-slate-800 hover:border-primary/30 hover:shadow-md transition-all active:scale-95">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                <span>Back to Attendance</span>
            </button>
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap gap-3 mb-6 shadow-sm">
        <form action="{{ route('attendances.schedule') }}" method="get" class="flex flex-wrap gap-3" id="filterForm">
            <div class="group relative flex items-center px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg hover:border-primary/50 transition-all bg-white dark:bg-slate-900">
                <select name="major" class="bg-transparent border-none outline-none focus:ring-0 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                    @foreach($majors as $major)
                        <option value="{{ $major }}" {{ $currentMajor == $major ? 'selected' : '' }}>{{ $major }}</option>
                    @endforeach
                </select>
            </div>
            <div class="group relative flex items-center px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg hover:border-primary/50 transition-all bg-white dark:bg-slate-900">
                <select name="year" class="bg-transparent border-none outline-none focus:ring-0 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                    <option value="2025/2026" {{ $currentYear == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                    <option value="2026/2027" {{ $currentYear == '2026/2027' ? 'selected' : '' }}>2026/2027</option>
                    <option value="2027/2028" {{ $currentYear == '2027/2028' ? 'selected' : '' }}>2027/2028</option>
                </select>
            </div>
            <div class="group relative flex items-center px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg hover:border-primary/50 transition-all bg-white dark:bg-slate-900">
                <select name="semester" class="bg-transparent border-none outline-none focus:ring-0 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                    <option value="Semester 1" {{ $currentSem == 'Semester 1' ? 'selected' : '' }}>Semester 1</option>
                    <option value="Semester 2" {{ $currentSem == 'Semester 2' ? 'selected' : '' }}>Semester 2</option>
                </select>
            </div>
        </form>

        {{-- Auto-Schedule All Majors --}}
        <form action="{{ route('attendances.scheduleauto') }}" method="POST" class="ml-auto">
            @csrf
            <input type="hidden" name="year" value="{{ $currentYear }}">
            <input type="hidden" name="semester" value="{{ $currentSem }}">
            <button type="submit" onclick="return confirm('Auto-schedule all unscheduled subjects for ALL majors in {{ $currentYear }} {{ $currentSem }}?')"
                    class="bg-slate-900 dark:bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:opacity-90 transition-all active:scale-95 shadow-sm">
                <span class="material-symbols-outlined text-lg">auto_fix_high</span>
                <span>Auto-Schedule All</span>
            </button>
        </form>
    </div>

    {{-- ======================== SECTION 1: Assign Subjects to Days ======================== --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 mb-6">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">add_circle</span>
            Assign Subject to Day
        </h2>

        @if($subjects->isEmpty())
            <div class="text-center py-8">
                <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">menu_book</span>
                <p class="text-sm text-slate-500 dark:text-slate-400">No subjects found for <strong>{{ $currentMajor }}</strong> — {{ $currentYear }} {{ $currentSem }}.</p>
                <a href="{{ route('academicrecords.subject') }}" class="text-primary text-sm font-bold hover:underline mt-2 inline-block">+ Create a Subject First</a>
            </div>
        @else
            <form action="{{ route('attendances.scheduleset') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Subject</label>
                    <select name="subject_id" required class="w-full px-3 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->subject_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Day</label>
                    <select name="day_of_week" required class="w-full px-3 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        @foreach($days as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Time (optional)</label>
                    <div class="flex gap-2">
                        <input type="time" name="start_time" class="w-full px-3 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary/30 focus:border-primary" placeholder="Start">
                        <input type="time" name="end_time" class="w-full px-3 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary/30 focus:border-primary" placeholder="End">
                    </div>
                </div>
                <div>
                    <button type="submit" class="w-full bg-slate-900 dark:bg-primary px-6 py-2.5 rounded-lg text-white font-bold text-sm shadow-lg hover:opacity-90 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">add</span>
                        Assign
                    </button>
                </div>
            </form>
        @endif
    </div>

    {{-- ======================== SECTION 2: Current Schedule ======================== --}}
    @if($schedules->isNotEmpty())
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm mb-6">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">calendar_month</span>
                Current Schedule — {{ $currentMajor }}
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Subject</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Code</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Day</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Time</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($schedules as $schedule)
                    @php
                        $dayColors = [
                            'Monday'    => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                            'Tuesday'   => 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-300',
                            'Wednesday' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                            'Thursday'  => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                            'Friday'    => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
                        ];
                    @endphp
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all">
                        <td class="px-6 py-4 text-sm font-semibold text-slate-900 dark:text-white">{{ $schedule->subject->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $schedule->subject->subject_code }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $dayColors[$schedule->day_of_week] }}">
                                {{ $schedule->day_of_week }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            @if($schedule->start_time && $schedule->end_time)
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} — {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('attendances.scheduleremove', $schedule->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors" title="Remove">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ======================== SECTION 3: Student Results ======================== --}}
    @if($schedules->isNotEmpty() && $studentResults->isNotEmpty())
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">fact_check</span>
                Student Subject Results
            </h2>
            <p class="text-xs text-slate-500 mt-1">If a student is absent 3+ times on the day a subject is scheduled, they fail that subject.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Student</th>
                        @foreach($schedules as $sch)
                            <th class="px-4 py-4 text-center">
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $sch->subject->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $sch->day_of_week }}</p>
                            </th>
                        @endforeach
                        <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Overall</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($studentResults as $row)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold uppercase">
                                    {{ strtoupper(substr($row['student']->name, 0, 1)) }}{{ strtoupper(substr(strrchr($row['student']->name, ' '), 1, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('attendances.show', $row['student']->id) }}" class="text-sm font-semibold text-slate-900 dark:text-white hover:text-primary transition-colors">
                                        {{ $row['student']->name }}
                                    </a>
                                    <p class="text-xs text-slate-500">{{ $row['student']->email }}</p>
                                </div>
                            </div>
                        </td>
                        @foreach($row['subjects'] as $subj)
                            <td class="px-4 py-4 text-center">
                                @if($row['deadline_passed'])
                                    @if($subj['result'] === 'Pass')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                            <span class="size-1.5 rounded-full bg-emerald-500"></span>Pass
                                        </span>
                                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $subj['absent'] }} absent</p>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                            <span class="size-1.5 rounded-full bg-red-500"></span>Fail
                                        </span>
                                        <p class="text-[10px] text-red-400 mt-0.5">{{ $subj['absent'] }} absent</p>
                                    @endif
                                @else
                                    <span class="text-[10px] text-slate-400 italic">{{ $subj['absent'] }} absent</span>
                                @endif
                            </td>
                        @endforeach
                        <td class="px-4 py-4 text-center">
                            @if($row['deadline_passed'])
                                @if($row['failed_count'] === 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">All Passed</span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">{{ $row['failed_count'] }} Failed</span>
                                @endif
                            @else
                                <span class="text-[10px] text-slate-400 italic">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Legend --}}
        <div class="p-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-6 text-xs text-slate-500">
            <div class="flex items-center gap-1.5">
                <span class="size-2 rounded-full bg-emerald-500"></span>
                <span>Pass — fewer than 3 absences on that day</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="size-2 rounded-full bg-red-500"></span>
                <span>Fail — more than 3 absences on that day</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="size-2 rounded-full bg-slate-300"></span>
                <span>Pending — deadline not yet passed</span>
            </div>
        </div>
    </div>
    @endif

    @if($errors->any())
        <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg shadow-lg z-50" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <script>
        document.querySelectorAll('#filterForm select').forEach(s => s.addEventListener('change', () => document.getElementById('filterForm').submit()));
        setTimeout(() => document.querySelectorAll('[role="alert"]').forEach(el => { el.style.transition = 'opacity 0.5s'; el.style.opacity = '0'; setTimeout(() => el.remove(), 500); }), 4000);
    </script>

</x-layouts.master>
