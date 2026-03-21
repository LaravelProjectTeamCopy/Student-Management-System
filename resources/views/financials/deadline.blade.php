<x-layouts.master title="Set Payment Deadline">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome', 'Financials' => route('financials.index')]" current="Set Payment Deadline" />
    </x-slot>

    <div class="max-w-4xl mx-auto">

        {{-- Form Card --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">

            {{-- Card Header --}}
            <div class="p-8 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-2xl font-bold">Set Payment Deadline</h2>
                <p class="text-sm text-slate-500 mt-1">Set a global payment deadline for all students or per individual student.</p>
            </div>

            <form class="p-8 space-y-10" action="{{ route('financials.overdue') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    {{-- Deadline Date --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Payment Deadline Date</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="date" name="deadline" />
                        @error('payment_deadline') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Apply To --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Apply To</label>
                        <select name="apply_to" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all cursor-pointer">
                            <option value="all">All Students</option>
                            <option value="unpaid">Unpaid Students Only</option>
                            <option value="partial">Partial Payment Students Only</option>
                        </select>
                        @error('apply_to') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                </div>

                {{-- Actions --}}
                <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-4">
                    <a href="{{ route('financials.index') }}" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
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
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Auto Overdue</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Students who have not paid by the deadline will automatically be marked as Overdue.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 mb-3">
                    <span class="material-symbols-outlined text-lg">notifications</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Daily Check</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">The system checks payment deadlines every day at midnight automatically.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 mb-3">
                    <span class="material-symbols-outlined text-lg">verified</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Paid Students Safe</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Students who have fully paid will not be affected by the deadline.</p>
            </div>
        </div>

    </div>

</x-layouts.master>