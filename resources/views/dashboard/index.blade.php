<x-layouts.master title="Dashboard">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="[]" current="Dashboard" />
    </x-slot>

    {{-- Page Title --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Welcome, {{ $user->name }}</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Here's what's happening across your institution today.</p>
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
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ number_format($totalStudents) }}</p>
            </div>
            <p class="text-xs font-medium text-blue-600 dark:text-blue-400">All Time</p>
        </div>

        {{-- Active Students --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-lg">verified</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Active Students</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ number_format($activeStudents) }}</p>
            </div>
            <div class="h-1 bg-emerald-100 dark:bg-emerald-900/30 rounded-full overflow-hidden">
                @php $activePct = $totalStudents > 0 ? round(($activeStudents / $totalStudents) * 100) : 0; @endphp
                <div class="h-full bg-emerald-500 rounded-full transition-all duration-700" style="width: {{ $activePct }}%"></div>
            </div>
        </div>

        {{-- New This Month --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-500 dark:text-amber-400 text-lg">person_add</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">New Enrollments</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">{{ number_format($newEnrollments) }}</p>
            </div>
            <p class="text-xs font-medium text-amber-500 dark:text-amber-400">This Month</p>
        </div>

        {{-- System Users --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-violet-50 dark:bg-violet-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-violet-500 dark:text-violet-400 text-lg">dashboard</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">System Overview</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none">Ready</p>
            </div>
            <p class="text-xs font-medium text-violet-500 dark:text-violet-400">All Systems Active</p>
        </div>

    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

        {{-- Enrollment Trend Chart --}}
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
            <h2 class="text-base font-bold text-slate-800 dark:text-white mb-5">Student Enrollment Trends</h2>
            <div class="relative h-80">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>

        {{-- Department Distribution Chart --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
            <h2 class="text-base font-bold text-slate-800 dark:text-white mb-5">Student Status Overview</h2>
            <div class="relative h-64 flex justify-center">
                <canvas id="departmentChart"></canvas>
            </div>
        </div>

    </div>

    {{-- Failed Attendance & Scores Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-8">

        {{-- Failed Attendance Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Attendance Performance</h3>
                <span class="material-symbols-outlined text-red-500 text-2xl">warning</span>
            </div>
            
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Failed (< 75%)</span>
                        <span class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $failedAttendance['failed'] }}</span>
                    </div>
                    <p class="text-xs text-slate-500">Students with poor attendance</p>
                </div>
                
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Passed (≥ 75%)</span>
                        <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $failedAttendance['passed'] }}</span>
                    </div>
                    <p class="text-xs text-slate-500">Students meeting attendance requirements</p>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-800">
                    <div class="text-xs text-slate-500">Total Students with Records: <span class="font-bold text-slate-700 dark:text-slate-300">{{ $failedAttendance['total'] }}</span></div>
                </div>
            </div>
        </div>

        {{-- Failed Scores Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Academic Performance</h3>
                <span class="material-symbols-outlined text-red-500 text-2xl">school</span>
            </div>
            
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Failed Subjects (< 60)</span>
                        <span class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $failedScores['failed'] }}</span>
                    </div>
                    <p class="text-xs text-slate-500">Students with at least one failed subject</p>
                </div>
                
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Passed All Subjects</span>
                        <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $failedScores['passed'] }}</span>
                    </div>
                    <p class="text-xs text-slate-500">Students passing all subjects</p>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-800">
                    <div class="text-xs text-slate-500">Total Students with Scores: <span class="font-bold text-slate-700 dark:text-slate-300">{{ $failedScores['total'] }}</span></div>
                </div>
            </div>
        </div>

    </div>

    {{-- Attendance & Financial Summary Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

        {{-- Attendance Summary --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
            <h2 class="text-base font-bold text-slate-800 dark:text-white mb-5">Attendance Status</h2>
            <div class="space-y-4">
                @php
                    $attTotal = $attendanceSummary['excellent'] + $attendanceSummary['good'] + $attendanceSummary['average'] + $attendanceSummary['critical'];
                @endphp
                
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Excellent</span>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            {{ $attendanceSummary['excellent'] ?? 0 }}
                            <span class="text-xs text-slate-500">({{ $attTotal > 0 ? round(($attendanceSummary['excellent'] ?? 0) / $attTotal * 100) : 0 }}%)</span>
                        </span>
                    </div>
                    <div class="h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $attTotal > 0 ? round(($attendanceSummary['excellent'] ?? 0) / $attTotal * 100) : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Good</span>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            {{ $attendanceSummary['good'] ?? 0 }}
                            <span class="text-xs text-slate-500">({{ $attTotal > 0 ? round(($attendanceSummary['good'] ?? 0) / $attTotal * 100) : 0 }}%)</span>
                        </span>
                    </div>
                    <div class="h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: {{ $attTotal > 0 ? round(($attendanceSummary['good'] ?? 0) / $attTotal * 100) : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Average</span>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            {{ $attendanceSummary['average'] ?? 0 }}
                            <span class="text-xs text-slate-500">({{ $attTotal > 0 ? round(($attendanceSummary['average'] ?? 0) / $attTotal * 100) : 0 }}%)</span>
                        </span>
                    </div>
                    <div class="h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ $attTotal > 0 ? round(($attendanceSummary['average'] ?? 0) / $attTotal * 100) : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Critical</span>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            {{ $attendanceSummary['critical'] ?? 0 }}
                            <span class="text-xs text-slate-500">({{ $attTotal > 0 ? round(($attendanceSummary['critical'] ?? 0) / $attTotal * 100) : 0 }}%)</span>
                        </span>
                    </div>
                    <div class="h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-red-500 rounded-full" style="width: {{ $attTotal > 0 ? round(($attendanceSummary['critical'] ?? 0) / $attTotal * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Financial Summary --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
            <h2 class="text-base font-bold text-slate-800 dark:text-white mb-5">Financial Status</h2>
            <div class="space-y-4">
                @php
                    $finTotal = $financialSummary['paid'] + $financialSummary['partial'] + $financialSummary['unpaid'] + $financialSummary['overdue'];
                @endphp
                
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Paid</span>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            {{ $financialSummary['paid'] ?? 0 }}
                            <span class="text-xs text-slate-500">({{ $finTotal > 0 ? round(($financialSummary['paid'] ?? 0) / $finTotal * 100) : 0 }}%)</span>
                        </span>
                    </div>
                    <div class="h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $finTotal > 0 ? round(($financialSummary['paid'] ?? 0) / $finTotal * 100) : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Partial</span>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            {{ $financialSummary['partial'] ?? 0 }}
                            <span class="text-xs text-slate-500">({{ $finTotal > 0 ? round(($financialSummary['partial'] ?? 0) / $finTotal * 100) : 0 }}%)</span>
                        </span>
                    </div>
                    <div class="h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: {{ $finTotal > 0 ? round(($financialSummary['partial'] ?? 0) / $finTotal * 100) : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Unpaid</span>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            {{ $financialSummary['unpaid'] ?? 0 }}
                            <span class="text-xs text-slate-500">({{ $finTotal > 0 ? round(($financialSummary['unpaid'] ?? 0) / $finTotal * 100) : 0 }}%)</span>
                        </span>
                    </div>
                    <div class="h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ $finTotal > 0 ? round(($financialSummary['unpaid'] ?? 0) / $finTotal * 100) : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Overdue</span>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            {{ $financialSummary['overdue'] ?? 0 }}
                            <span class="text-xs text-slate-500">({{ $finTotal > 0 ? round(($financialSummary['overdue'] ?? 0) / $finTotal * 100) : 0 }}%)</span>
                        </span>
                    </div>
                    <div class="h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-red-500 rounded-full" style="width: {{ $finTotal > 0 ? round(($financialSummary['overdue'] ?? 0) / $finTotal * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-800">
            <h2 class="text-base font-bold text-slate-800 dark:text-white">Recent Activities</h2>
            <button class="text-sm font-semibold text-primary hover:underline">View All</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Activity</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Module</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Time</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($activities as $activity)
                        @php
                            $moduleColors = [
                                'Student'    => ['bg' => 'bg-blue-50 dark:bg-blue-900/20',    'text' => 'text-blue-500'],
                                'Attendance' => ['bg' => 'bg-teal-50 dark:bg-teal-900/20',    'text' => 'text-teal-500'],
                                'Academic'   => ['bg' => 'bg-violet-50 dark:bg-violet-900/20','text' => 'text-violet-500'],
                                'Financial'  => ['bg' => 'bg-amber-50 dark:bg-amber-900/20',  'text' => 'text-amber-500'],
                                'System'     => ['bg' => 'bg-slate-100 dark:bg-slate-800',    'text' => 'text-slate-500'],
                            ];
                            $color = $moduleColors[$activity->module] ?? $moduleColors['System'];
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-9 rounded-xl {{ $color['bg'] }} flex items-center justify-center {{ $color['text'] }} shrink-0 transition-transform group-hover:scale-110">
                                        <span class="material-symbols-outlined text-[18px]">{{ $activity->icon ?? 'info' }}</span>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors">
                                        {{ $activity->description }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 whitespace-nowrap">
                                {{ $activity->user->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-bold uppercase">
                                    {{ $activity->module }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-400 dark:text-slate-500 whitespace-nowrap">
                                {{ $activity->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                    Completed
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 dark:text-slate-600 text-sm">
                                <span class="material-symbols-outlined text-4xl block mb-2 opacity-20">history</span>
                                No recent activities yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/10"></div>
    </div>

    @push('scripts')
    @endpush

</x-layouts.master>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    console.log('=== Dashboard Chart Initialization ===');
    console.log('Chart.js loaded:', typeof Chart !== 'undefined');
    
    function initializeCharts() {
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded!');
            return;
        }

        // Get data from controller
        const enrollData = @json($enrollmentTrend);
        const deptData = @json($deptDistribution);

        console.log('Enrollment Data:', enrollData);
        console.log('Department Data:', deptData);

        // Render enrollment chart
        const canvas1 = document.getElementById('enrollmentChart');
        console.log('Enrollment canvas found:', canvas1 !== null);
        
        if (canvas1) {
            try {
                const ctx1 = canvas1.getContext('2d');
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: enrollData.labels,
                        datasets: [
                            {
                                label: 'New Enrollments',
                                data: enrollData.newEnrollments,
                                borderColor: '#EF4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointBackgroundColor: '#EF4444',
                            },
                            {
                                label: 'Total Students',
                                data: enrollData.totalStudents,
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointBackgroundColor: '#3B82F6',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { 
                                display: true,
                                position: 'top'
                            } 
                        },
                        scales: {
                            y: { beginAtZero: true },
                        }
                    }
                });
                console.log('✓ Enrollment chart rendered successfully');
            } catch (error) {
                console.error('✗ Error rendering enrollment chart:', error);
            }
        }

        // Render department chart
        const canvas2 = document.getElementById('departmentChart');
        console.log('Department canvas found:', canvas2 !== null);
        
        if (canvas2) {
            try {
                const ctx2 = canvas2.getContext('2d');
                
                if (!deptData.labels || deptData.labels.length === 0) {
                    console.warn('No department data available');
                    canvas2.parentElement.innerHTML = '<p class="text-center text-slate-400 text-sm py-8">No student status data available</p>';
                } else {
                    new Chart(ctx2, {
                        type: 'doughnut',
                        data: {
                            labels: deptData.labels,
                            datasets: [{
                                data: deptData.data,
                                backgroundColor: deptData.colors,
                                borderWidth: 2,
                                borderColor: '#ffffff',
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { 
                                legend: { 
                                    display: true,
                                    position: 'bottom'
                                } 
                            }
                        }
                    });
                    console.log('✓ Department chart rendered successfully');
                }
            } catch (error) {
                console.error('✗ Error rendering department chart:', error);
            }
        }
    }

    // Initialize when Chart.js loads and DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeCharts);
    } else {
        initializeCharts();
    }
</script>