<x-layouts.master title="Attendance History">
    
    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome', 'Attendances' => route('attendances.index')]" current="History" />
    </x-slot>

    {{-- Page Title + Actions --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Attendance History</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">View archived attendance records from all semesters.</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap gap-3 mb-6">
        <form action="{{ route('attendances.studenthistory') }}" method="GET" class="flex flex-wrap gap-3">

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
                    <option value="">All Results</option>
                    @foreach($attendanceresult as $result)
                        <option value="{{ $result }}" {{ request('status') == $result ? 'selected' : '' }}>
                            {{ $result }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">
                <span class="text-xs font-bold uppercase text-slate-400">Select Term:</span>
                <select name="semester" class="bg-transparent border-none outline-none focus:ring-0 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                    <option value="">All History</option>
                    
                    @foreach($semesters as $yearLabel => $group)
                        <optgroup label="{{ $yearLabel }}" class="bg-slate-100 dark:bg-slate-800 text-primary font-bold">
                            @foreach($group as $index => $sem)
                                @php 
                                    $dateValue = $sem->semester_end;
                                    $formattedDate = \Carbon\Carbon::parse($dateValue)->format('M d, Y');
                                @endphp
                                <option value="{{ $dateValue }}" {{ request('semester') == $dateValue ? 'selected' : '' }}>
                                    {{-- This displays as "Semester 1 (Mar 20, 2026)" --}}
                                    Semester {{ $group->count() - $index }} ({{ $formattedDate }})
                                </option>
                            @endforeach
                        </optgroup>
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
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Semester Start</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Semester End</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Present</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Absent</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Result</th>
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                    @forelse($histories as $history)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">

                        {{-- Student Name --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold uppercase shrink-0">
                                    {{ strtoupper(substr($history->student->name, 0, 1)) }}{{ strtoupper(substr(strrchr($history->student->name, ' '), 1, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $history->student->name }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ $history->student->email }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Major --}}
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-xs font-medium">{{ $history->student->major }}</span>
                        </td>

                        {{-- Semester Start --}}
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $history->semester_start ? \Carbon\Carbon::parse($history->semester_start)->format('M d, Y') : '—' }}
                        </td>

                        {{-- Semester End --}}
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $history->semester_end ? \Carbon\Carbon::parse($history->semester_end)->format('M d, Y') : '—' }}
                        </td>

                        {{-- Present --}}
                        <td class="px-6 py-4 text-sm font-medium text-emerald-600">
                            {{ $history->present_days }}
                        </td>

                        {{-- Absent --}}
                        <td class="px-6 py-4 text-sm font-medium text-red-500">
                            {{ $history->absent_days }}
                        </td>

                        {{-- Result --}}
                        <td class="px-6 py-4">
                            @if($history->attendance_result === 'Passed')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>Passed
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    <span class="size-1.5 rounded-full bg-red-500"></span>Failed
                                </span>
                            @endif
                        </td>

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
            {{ $histories->links() }}
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