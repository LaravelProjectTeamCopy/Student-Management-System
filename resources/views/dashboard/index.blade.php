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
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-5">

        <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Total Students</p>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">All Time</span>
            </div>
            <p class="text-[2rem] font-bold text-slate-900 dark:text-white tracking-tight leading-none mb-4">{{ number_format($totalStudents) }}</p>
            <div class="h-[3px] w-16 rounded-full bg-primary"></div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Active Students</p>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">Active</span>
            </div>
            <p class="text-[2rem] font-bold text-slate-900 dark:text-white tracking-tight leading-none mb-4">{{ number_format($activeStudents) }}</p>
            <div class="h-[3px] w-16 rounded-full bg-primary"></div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">New Enrollments</p>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">This Month</span>
            </div>
            <p class="text-[2rem] font-bold text-slate-900 dark:text-white tracking-tight leading-none mb-4">{{ number_format($newEnrollments) }}</p>
            <div class="h-[3px] w-16 rounded-full bg-primary"></div>
        </div>

    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

        {{-- Enrollment Trend Chart --}}
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-base font-bold text-slate-800 dark:text-white">Student Enrollment Trends</h2>
                <select class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 outline-none cursor-pointer">
                    <option>Last 6 Months</option>
                    <option>Last 12 Months</option>
                    <option>This Year</option>
                </select>
            </div>
            <div class="h-52">
                <canvas id="enrollChart"></canvas>
            </div>
        </div>

        {{-- Department Distribution --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
            <h2 class="text-base font-bold text-slate-800 dark:text-white mb-5">Department Distribution</h2>
            <div class="flex justify-center mb-5">
                <div class="relative w-36 h-36">
                    <canvas id="deptChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($totalStudents) }}</span>
                        <span class="text-[10px] uppercase tracking-widest text-slate-400 dark:text-slate-500 font-semibold">Total</span>
                    </div>
                </div>
            </div>
            <div class="space-y-2.5 text-sm">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 inline-block"></span>
                        <span class="text-slate-600 dark:text-slate-400">Science</span>
                    </span>
                    <span class="font-bold text-slate-700 dark:text-slate-300">40%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                        <span class="text-slate-600 dark:text-slate-400">Arts</span>
                    </span>
                    <span class="font-bold text-slate-700 dark:text-slate-300">30%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span>
                        <span class="text-slate-600 dark:text-slate-400">Tech</span>
                    </span>
                    <span class="font-bold text-slate-700 dark:text-slate-300">20%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-300 dark:bg-slate-600 inline-block"></span>
                        <span class="text-slate-600 dark:text-slate-400">Other</span>
                    </span>
                    <span class="font-bold text-slate-700 dark:text-slate-300">10%</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Recent Activities Table --}}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        let enrollInst = null, deptInst = null;

        function isDark() {
            return document.documentElement.classList.contains('dark');
        }

        function buildEnrollChart() {
            const ctx  = document.getElementById('enrollChart').getContext('2d');
            const dark = isDark();
            const grad = ctx.createLinearGradient(0, 0, 0, 200);
            grad.addColorStop(0, dark ? 'rgba(59,130,246,.25)' : 'rgba(59,130,246,.15)');
            grad.addColorStop(1, 'rgba(59,130,246,0)');

            enrollInst = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        data: [320, 415, 480, 625, 780, 720],
                        fill: true,
                        backgroundColor: grad,
                        borderColor: '#3B82F6',
                        borderWidth: 2.5,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#3B82F6',
                        tension: 0.45,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: dark ? '#1e293b' : '#fff',
                            titleColor:      dark ? '#e2e8f0' : '#1e293b',
                            bodyColor:       dark ? '#94a3b8' : '#64748b',
                            borderColor:     dark ? '#334155' : '#e2e8f0',
                            borderWidth: 1, padding: 10,
                            callbacks: { label: c => ` ${c.parsed.y} students` }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: dark ? '#64748b' : '#94a3b8', font: { size: 11 } }, border: { display: false } },
                        y: { grid: { color: dark ? 'rgba(255,255,255,.05)' : 'rgba(0,0,0,.05)' }, ticks: { color: dark ? '#64748b' : '#94a3b8', font: { size: 11 }, maxTicksLimit: 5 }, border: { display: false } }
                    }
                }
            });
        }

        function buildDeptChart() {
            const ctx  = document.getElementById('deptChart').getContext('2d');
            const dark = isDark();
            deptInst = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [40, 30, 20, 10],
                        backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', dark ? '#334155' : '#E2E8F0'],
                        borderWidth: 0,
                        hoverOffset: 4,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: true, cutout: '74%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: dark ? '#1e293b' : '#fff',
                            titleColor:      dark ? '#e2e8f0' : '#1e293b',
                            bodyColor:       dark ? '#94a3b8' : '#64748b',
                            borderColor:     dark ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            callbacks: { label: c => ` ${c.parsed}%` }
                        }
                    }
                }
            });
        }

        function rebuildCharts() {
            if (enrollInst) enrollInst.destroy();
            if (deptInst)   deptInst.destroy();
            buildEnrollChart();
            buildDeptChart();
        }

        window.addEventListener('DOMContentLoaded', () => {
            buildEnrollChart();
            buildDeptChart();
        });

        const _origToggle = window.toggleTheme;
        if (typeof _origToggle === 'function') {
            window.toggleTheme = function () { _origToggle(); rebuildCharts(); };
        }
    </script>
    @endpush

</x-layouts.master>