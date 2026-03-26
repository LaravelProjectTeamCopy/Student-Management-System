<x-layouts.master title="Set Attendance Deadline">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome', 'Attendance' => route('attendances.index')]" current="Set Attendance Deadline" />
    </x-slot>

    <div class="max-w-4xl mx-auto">

        {{-- Form Card --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">

            {{-- Card Header --}}
            <div class="p-8 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-2xl font-bold">Set Attendance Deadline</h2>
                <p class="text-sm text-slate-500 mt-1">Set a deadline for student attendance submission per semester.</p>
            </div>

            <form class="p-8 space-y-10" action="{{ route('attendances.duration') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Semester Start Date</label>
                        <input id="semester_start" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="date" name="semester_start" />
                        @error('semester_start') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Semester Duration --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Semester Duration</label>
                        <select id="semester_duration" name="semester_duration" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all cursor-pointer">
                            <option value="15">15 Weeks</option>
                            <option value="17">17 Weeks</option>
                            <option value="18">18 Weeks</option>
                        </select>
                        <p id="duration_hint" class="text-[10px] font-medium text-primary mt-1 italic"></p>
                        @error('semester_duration') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Apply To --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Apply To</label>
                        <select name="apply_to" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all cursor-pointer">
                            <option value="all">All Students</option>
                        </select>
                        @error('apply_to') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800/50 rounded-lg">
                        <input type="checkbox" name="reset_attendance" id="reset_attendance" value="1" 
                            class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary cursor-pointer">
                        <label for="reset_attendance" class="text-sm font-medium text-amber-800 dark:text-amber-200 cursor-pointer">
                            Reset all student attendance counts to 0 for this new semester?
                        </label>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-4">
                    <a href="{{ route('attendances.index') }}" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Cancel
                    </a>
                    <button class="px-8 py-2.5 bg-primary text-white rounded-lg text-sm font-bold shadow-sm hover:bg-primary/90 transition-all active:scale-95" type="submit">
                        Set Deadline
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
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Auto Attendance Check</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Students who have not submitted attendance by the deadline will automatically be flagged.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 mb-3">
                    <span class="material-symbols-outlined text-lg">calendar_today</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Daily Update</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">The system checks attendance submission daily to track pending submissions automatically.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 mb-3">
                    <span class="material-symbols-outlined text-lg">verified</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Submitted Students Safe</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Students who have already submitted attendance will not be affected by the deadline update.</p>
            </div>
        </div>

    </div>
    <script>
        // 1. Get all the elements (Added 'duration_hint' here)
        const semesterStartInput = document.getElementById('semester_start');
        const semesterDurationInput = document.getElementById('semester_duration');
        const deadlineInput = document.getElementById('deadline');
        const hint = document.getElementById('duration_hint'); 

        function calculateDeadline() {
            const startDateStr = semesterStartInput.value;
            const durationWeeks = parseInt(semesterDurationInput.value);

            if (startDateStr && durationWeeks) {
                const startDate = new Date(startDateStr);

                // Add weeks in days (e.g., 15 * 7 = 105 days)
                startDate.setDate(startDate.getDate() + durationWeeks * 7);

                // Format as yyyy-mm-dd for the date input
                const yyyy = startDate.getFullYear();
                const mm = String(startDate.getMonth() + 1).padStart(2, '0');
                const dd = String(startDate.getDate()).padStart(2, '0');

                // UPDATE THE INPUT VALUE (The Date)
                deadlineInput.value = `${yyyy}-${mm}-${dd}`;
                
                // UPDATE THE HINT TEXT (The Days)
                if (hint) {
                    hint.innerText = `➔ This loop will cover ${durationWeeks * 7} days of attendance.`;
                }
            } else {
                deadlineInput.value = '';
                if (hint) hint.innerText = '';
            }
        }

        // 2. Event Listeners
        semesterStartInput.addEventListener('change', calculateDeadline);
        semesterDurationInput.addEventListener('change', calculateDeadline);

        // 3. Initial calculation on page load
        window.addEventListener('load', calculateDeadline);
    </script>
</x-layouts.master>