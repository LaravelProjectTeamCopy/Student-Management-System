<x-layouts.master title="Academic Profile">
    
    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome', 'Academic Records' => route('academicrecords.index')]" current="{{ $student->name }}" />
    </x-slot>
    
    {{-- Page Header --}}
    <div class="mb-8 flex flex-col items-start justify-between gap-6 rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900 lg:flex-row lg:items-center">
        <div class="flex items-center gap-6">
            <div class="h-24 w-24 rounded-full ring-4 ring-slate-50 dark:ring-slate-800 bg-primary/10 flex items-center justify-center text-primary text-2xl font-bold uppercase">
                {{ strtoupper(substr($student->name, 0, 1)) }}{{ strtoupper(substr(strrchr($student->name, ' '), 1, 1)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold">{{ $student->name }}</h2>
                <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1">
                    <span class="text-sm text-slate-500">ID: {{ $student->id }}</span>
                    <span class="flex items-center gap-1 text-sm font-medium text-primary">
                        <span class="size-2 rounded-full bg-primary"></span>
                        {{ $student->major }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex w-full gap-3 lg:w-auto">
            <button class="flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 lg:flex-none transition-colors">
                <span class="material-symbols-outlined text-sm">download</span>
                Transcript
            </button>
            <a href="{{ route('academicrecords.import') }}">
                <button class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-bold text-white hover:bg-primary/90 lg:flex-none transition-colors">
                    <span class="material-symbols-outlined text-sm">add_chart</span>
                    Update Scores
                </button>
            </a>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        {{-- Left / Middle: Performance Overview --}}
        <div class="lg:col-span-2 flex flex-col gap-8">

            {{-- Grade Summary Cards --}}
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">analytics</span>
                    <h3 class="text-lg font-bold">Academic Performance</h3>
                </div>
                
                @php 
                    $avg = $scores->count() > 0 ? $scores->avg('total_score') : 0;
                @endphp

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Average Score</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($avg, 1) }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Subjects Passed</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-600">{{ $scores->where('total_score', '>=', 50)->count() }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Credits</p>
                        <p class="mt-1 text-2xl font-bold text-amber-600">{{ $scores->count() * 3 }}</p>
                    </div>
                </div>

                {{-- GPA Progress Bar --}}
                <div class="mt-6">
                    <div class="flex justify-between text-xs font-medium text-slate-500 mb-1.5">
                        <span>Overall Completion</span>
                        <span>{{ number_format($avg, 0) }}% proficiency</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $avg >= 80 ? 'bg-emerald-500' : ($avg >= 50 ? 'bg-primary' : 'bg-red-500') }}" style="width: {{ $avg }}%"></div>
                    </div>
                </div>
            </section>

            {{-- Scores Table Breakdown --}}
            <section class="rounded-xl bg-white shadow-sm dark:bg-slate-900 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">list_alt</span>
                        Detailed Scores
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 dark:bg-slate-800/50 text-xs font-bold text-slate-500 uppercase">
                            <tr>
                                <th class="px-6 py-4">Subject</th>
                                <th class="px-6 py-4 text-center">Quiz</th>
                                <th class="px-6 py-4 text-center">Midterm</th>
                                <th class="px-6 py-4 text-center">Final</th>
                                <th class="px-6 py-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($scores as $score)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $score->subject->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $score->subject->code ?? 'SUB-'.$score->subject->id }}</p>
                                </td>
                                <td class="px-6 py-4 text-center text-sm">{{ $score->quiz_score }}</td>
                                <td class="px-6 py-4 text-center text-sm">{{ $score->midterm_score }}</td>
                                <td class="px-6 py-4 text-center text-sm">{{ $score->final_score }}</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold {{ $score->total_score >= 50 ? 'text-emerald-600' : 'text-red-500' }}">
                                        {{ $score->total_score }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        {{-- Right Side - Quick Info --}}
        <div class="lg:col-span-1">
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">assignment_ind</span>
                    <h3 class="text-lg font-bold">Academic Status</h3>
                </div>

                <div class="space-y-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Standing</p>
                        @if ($avg >= 85)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                <span class="material-symbols-outlined text-xs">workspace_premium</span> Honor Student
                            </span>
                        @elseif ($avg >= 50)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                <span class="material-symbols-outlined text-xs">check_circle</span> Satisfactory
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                <span class="material-symbols-outlined text-xs">error</span> Academic Probation
                            </span>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Academic Timeline</p>
                        <div class="space-y-4">
                            <div class="flex gap-3">
                                <div class="size-8 shrink-0 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-sm text-slate-500">event</span>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 dark:text-white">Current Semester</p>
                                    <p class="text-[11px] text-slate-500">Semester 1, 2025/2026</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="mt-8 w-full rounded-lg border border-slate-200 dark:border-slate-800 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all active:scale-95">
                    View Full History
                </button>
            </section>
        </div>

    </div>
</x-layouts.master>