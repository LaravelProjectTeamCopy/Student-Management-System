<x-layouts.master title="Insert Attendance Record">

    <div class="max-w-4xl mx-auto">

        {{-- Form Card --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">

            {{-- Card Header --}}
            <div class="p-8 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-2xl font-bold">Insert Attendance Record</h2>
                <p class="text-sm text-slate-500 mt-1">Enter the attendance details for a student.</p>
            </div>

            <form class="p-8 space-y-10" action="{{ route('attendances.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    {{-- Student Email --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Student Email</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="email" name="email" placeholder="student@edu.com" value="{{ old('email') }}" />
                        @error('email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Total Days --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Total Days</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="number" name="total_days" placeholder="0" value="{{ old('total_days') }}" />
                        @error('total_days') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Present Days --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Present Days</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="number" name="present_days" placeholder="0" value="{{ old('present_days') }}" />
                        @error('present_days') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Absent Days (readonly) --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Absent Days</label>
                        <input class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-400 cursor-not-allowed" type="number" id="absent_days" readonly placeholder="Auto-calculated" />
                        <p class="text-xs text-slate-400">Auto-calculated: Total Days − Present Days</p>
                    </div>

                </div>

                {{-- Actions --}}
                <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-4">
                    <a href="{{ route('attendances.index') }}" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Cancel
                    </a>
                    <button class="px-8 py-2.5 bg-primary text-white rounded-lg text-sm font-bold shadow-sm hover:bg-primary/90 transition-all active:scale-95" type="submit">
                        Save Record
                    </button>
                </div>

            </form>
        </div>

        {{-- Info Cards --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-primary mb-3">
                    <span class="material-symbols-outlined text-lg">info</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Auto-Calculated</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Absent days and status are automatically calculated from total and present days.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 mb-3">
                    <span class="material-symbols-outlined text-lg">verified_user</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Student Lookup</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Enter the student email to link this record to the correct student.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 mb-3">
                    <span class="material-symbols-outlined text-lg">assignment_late</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Required Fields</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">All fields are required for a complete attendance record.</p>
            </div>
        </div>

    </div>

    <script>
        const totalDays   = document.querySelector('[name="total_days"]');
        const presentDays = document.querySelector('[name="present_days"]');
        const absentDays  = document.getElementById('absent_days');

        function calculateAbsent() {
            const total   = parseInt(totalDays.value) || 0;
            const present = parseInt(presentDays.value) || 0;
            absentDays.value = total - present;
        }

        totalDays.addEventListener('input', calculateAbsent);
        presentDays.addEventListener('input', calculateAbsent);
    </script>

</x-layouts.master>