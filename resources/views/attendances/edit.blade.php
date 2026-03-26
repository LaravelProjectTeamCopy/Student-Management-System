<x-layouts.master title="Edit Attendance Record">
    
    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome', 'Attendances' => route('attendances.index') ,'Edit' => route('attendances.edit', $attendance->student_id)]" current="{{ $student->name }}" />
    </x-slot>
    
    {{-- Page Title --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold tracking-tight">Edit Attendance Record</h2>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden max-w-4xl mx-auto">

        {{-- Profile Header --}}
        <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center gap-6">
            <div class="relative group">
                <div class="h-24 w-24 rounded-full ring-4 ring-slate-50 dark:ring-slate-800 bg-primary/10 flex items-center justify-center text-primary text-2xl font-bold uppercase">
                    {{ strtoupper(substr($student->name, 0, 1)) }}{{ strtoupper(substr(strrchr($student->name, ' '), 1, 1)) }}
                </div>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h3 class="text-2xl font-bold">{{$student->name}}</h3>
                <p class="text-slate-500 font-medium">Student ID: {{$student->id}}</p>
                <p class="text-sm text-slate-400 mt-1">{{$student->major}}</p>
            </div>
        </div>

        {{-- Form --}}
        <form class="p-8 space-y-10" action="{{ route('attendances.edit', $attendance->student_id) }}" method="POST">
        @csrf
        @method('PUT')

            <section>
                <div class="flex items-center gap-2 mb-6 text-primary">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <h4 class="text-lg font-bold">Attendance Information</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Total Days</label>
                        <input class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-400 cursor-not-allowed" type="number" value="{{ $attendance->semester_duration ? $attendance->semester_duration * 5 : $attendance->total_days }}" readonly />
                        <p class="text-xs text-slate-400">Auto-calculated from semester duration</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Present Days</label>
                        <input class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary" type="number" name="present_days" value="{{$attendance->present_days}}" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Absent Days</label>
                        <input class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-400 cursor-not-allowed" type="number" id="absent_days"  value="{{$attendance->absent_days}}" readonly />
                        <p class="text-xs text-slate-400">Auto-calculated: Total Days − Present Days</p>
                    </div>

                </div>
            </section>

            {{-- Action Buttons --}}
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex flex-col md:flex-row justify-end gap-3">
                <button class="px-6 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" type="button">
                    Cancel Changes
                </button>
                <button class="px-6 py-2.5 rounded-lg bg-primary hover:bg-primary/90 text-white text-sm font-bold shadow-md shadow-primary/20 transition-colors" type="submit">
                    Save Changes
                </button>
            </div>

        </form>
    </div>
    <script>
        const totalDaysInput = document.querySelector('[value="{{ $attendance->semester_duration ? $attendance->semester_duration * 5 : $attendance->total_days }}"]');
        const presentDays = document.querySelector('[name="present_days"]');
        const absentDays  = document.getElementById('absent_days');

        const totalDays = {{ $attendance->semester_duration ? $attendance->semester_duration * 5 : $attendance->total_days }};

        function calculate() {
            const present = parseInt(presentDays.value) || 0;
            const absent  = totalDays - present;

            absentDays.value = absent;
        }

        presentDays.addEventListener('input', calculate);
    </script>

    @if($errors->any())
        <div class="fixed top-4 left-1/2 -translate-x-1/2 z-50 bg-red-100 border border-red-400 text-red-700 px-6 py-3 rounded-lg shadow-lg">
            {{ $errors }}
        </div>
    @endif

</x-layouts.master>