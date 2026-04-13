<x-layouts.master title="Student Profile">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome', 'Students' => route('students.index')]" current="{{ $student->name }}" />
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
                    <span class="text-sm text-slate-500">ID: {{ $student->student_id }}</span>
                    <span class="text-sm text-slate-500">{{ $student->email }}</span>
                    @php
                        $statusColor = match($student->status ?? 'Active') {
                            'Active'    => 'text-emerald-600',
                            'Inactive'  => 'text-red-500',
                            'Graduated' => 'text-violet-500',
                            default     => 'text-emerald-600',
                        };
                        $dotColor = match($student->status ?? 'Active') {
                            'Active'    => 'bg-emerald-600',
                            'Inactive'  => 'bg-red-500',
                            'Graduated' => 'bg-violet-500',
                            default     => 'bg-emerald-600',
                        };
                    @endphp
                    <span class="flex items-center gap-1 text-sm font-medium {{ $statusColor }}">
                        <span class="size-2 rounded-full {{ $dotColor }}"></span>
                        {{ $student->status ?? 'Active' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex w-full gap-3 lg:w-auto">
            <button class="flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 lg:flex-none transition-colors">
                <span class="material-symbols-outlined text-sm">print</span>
                Print Profile
            </button>
            <a href="{{ route('students.edit', $student->id) }}">
                <button class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-bold text-slate-900 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-100 lg:flex-none transition-colors">
                    <span class="material-symbols-outlined text-sm">edit</span>
                    Edit Student
                </button>
            </a>
            <button type="button" onclick="openDeleteModal()" class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-red-500 px-4 py-2 text-sm font-bold text-white hover:bg-red-600 lg:flex-none transition-colors">
                <span class="material-symbols-outlined text-sm">delete</span>
                Delete
            </button>
            <form id="delete-form" action="{{ route('students.destroy', $student->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        {{-- Left / Middle --}}
        <div class="lg:col-span-2 flex flex-col gap-8">

            {{-- Personal Information --}}
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h3 class="text-lg font-bold">Personal Information</h3>
                </div>
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Full Name</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{ $student->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Email Address</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{ $student->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Phone Number</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{ $student->phone ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Date of Birth</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100">
                            {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Gender</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{ $student->gender ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Address</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{ $student->address ?? '—' }}</p>
                    </div>
                </div>
            </section>

            {{-- Academic Information --}}
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">school</span>
                    <h3 class="text-lg font-bold">Academic Information</h3>
                </div>
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Student ID</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{ $student->student_id }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Major</p>
                        <span class="mt-1 inline-block px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-bold uppercase">
                            {{ $student->major }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Academic Year</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{ $student->academic_year ?? $student->enrollment_year ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Enrollment Date</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100">
                            {{ $student->enrolled_at ? \Carbon\Carbon::parse($student->enrolled_at)->format('M d, Y') : '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Status</p>
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
                        <span class="mt-1 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusClasses[$statusLabel] ?? $statusClasses['Active'] }}">
                            <span class="size-1.5 rounded-full {{ $dotClasses[$statusLabel] ?? $dotClasses['Active'] }}"></span>
                            {{ $statusLabel }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">GPA</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{ $student->gpa ? number_format($student->gpa, 2) : '—' }}</p>
                    </div>
                </div>
            </section>

        </div>

        {{-- Right Side --}}
        <div class="lg:col-span-1 flex flex-col gap-8">

            {{-- Quick Stats --}}
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">analytics</span>
                    <h3 class="text-lg font-bold">Quick Stats</h3>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Attendance Rate</p>
                        @php $pct = isset($attendance) && $attendance->total_days > 0
                            ? round(($attendance->present_days / $attendance->total_days) * 100) : 0; @endphp
                        <div class="mt-2 flex items-center gap-2">
                            <div class="flex-1 h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $pct >= 75 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                     style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $pct }}%</span>
                        </div>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Academic Score</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">
                            {{ $student->gpa ? number_format($student->gpa, 2) : '—' }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Enrolled Since</p>
                        <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                            {{ $student->enrolled_at ? \Carbon\Carbon::parse($student->enrolled_at)->format('M Y') : '—' }}
                        </p>
                    </div>
                </div>
            </section>

            {{-- Activity Log --}}
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history</span>
                    <h3 class="text-lg font-bold">Activity Log</h3>
                </div>

                <div class="flex flex-col gap-6">
                    @forelse($logs ?? [] as $log)
                        <div class="relative flex gap-4 pb-2">
                            <div class="absolute left-4 top-8 h-full w-px bg-slate-200 dark:bg-slate-800"></div>
                            <div class="relative z-10 flex size-9 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">
                                <span class="material-symbols-outlined text-lg">edit_note</span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $log->action ?? 'Record Updated' }}</p>
                                <p class="text-xs text-slate-500">{{ $log->description ?? '—' }}</p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ isset($log->created_at) ? $log->created_at->format('M d, Y') : '—' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">No activity recorded yet.</p>
                    @endforelse
                </div>

                <a href="{{ route('students.index') }}">
                    <button class="mt-8 w-full rounded-lg border border-slate-200 dark:border-slate-800 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Back to Directory
                    </button>
                </a>
            </section>

        </div>

    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="delete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 w-full max-w-md mx-4 p-6">

            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 dark:bg-red-900/30 mx-auto mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>

            <h3 class="text-lg font-bold text-slate-900 dark:text-white text-center">Delete Student?</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 text-center mt-2">
                This will permanently delete <span class="font-semibold text-red-500">{{ $student->name }}</span>
                and all associated records. This action <span class="font-semibold">cannot be undone</span>.
            </p>

            {{-- Student Summary --}}
            <div class="mt-4 p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-500 space-y-1">
                <div class="flex justify-between">
                    <span class="font-semibold">Name</span>
                    <span>{{ $student->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">Student ID</span>
                    <span>{{ $student->student_code ?? $student->student_id ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">Major</span>
                    <span class="text-red-500 font-bold">{{ $student->major }}</span>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                    Cancel
                </button>
                <button type="button" onclick="document.getElementById('delete-form').submit()"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 text-white text-sm font-bold hover:bg-red-600 transition shadow-lg">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal() {
            document.getElementById('delete-modal').classList.remove('hidden');
        }
        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }
        document.getElementById('delete-modal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>

</x-layouts.master>