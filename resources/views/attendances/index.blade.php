<x-layouts.master title="Attendance">
    
    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome']" current="Attendances" />
    </x-slot>
    
    <x-slot name="search">
        <x-search 
            action="{{ route('attendances.index') }}"
            placeholder="Search attendance records..."
        />
    </x-slot>
    {{-- Page Title + Actions --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Student Attendance</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Monitor and manage student attendance records.</p>
        </div>
        <div class="flex items-center gap-3 ml-auto">
            <a href="{{route('attendances.create')}}"><button class="bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-lg">add</span>
                <span>Add Attendance</span>
            </button></a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap gap-3 mb-6">
        <form action="/attendances" method="get" class="flex flex-wrap gap-3">
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
                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ $attendance->student->email }}</span>
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
                            <a href="{{ route('attendances.show', $attendance->student_id) }}" class="text-primary font-semibold text-sm hover:underline flex items-center gap-1">
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
    <script>
        document.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', () => {
                select.closest('form').submit();
            });
        });
    </script>
</x-layouts.master>