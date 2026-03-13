    <x-layouts.master title="Edit Financial Record">

        {{-- Page Title --}}
        <div class="mb-8">
            <h2 class="text-3xl font-bold tracking-tight">Edit Financial Record</h2>
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
            <form class="p-8 space-y-10" action = "{{ route('financials.edit', $financial->student_id) }}" method="POST">
            @csrf
            @method('PUT')
                {{-- Financial Information --}}
                <section>
                    <div class="flex items-center gap-2 mb-6 text-primary">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                        <h4 class="text-lg font-bold">Financial Information</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Total Fees Due</label>
                            <input class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary" type="number" step="0.01" name="total_fees" value="{{$financial->total_fees}}" placeholder="0.00" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Amount Paid</label>
                            <input class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary" type="number" step="0.01" name="amount_paid" value="{{$financial->amount_paid}}" placeholder="0.00" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Balance Remaining</label>
                            <input class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-400 cursor-not-allowed" type="number" name="remaining_balance" value="{{$financial->remaining_balance}}" readonly />
                            <p class="text-xs text-slate-400">Auto-calculated: Total Fees − Amount Paid</p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Payment Status</label>
                            <select name="payment_status" class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary">
                                <option value="Paid"    {{ $financial->payment_status === 'Paid'    ? 'selected' : '' }}>Paid</option>
                                <option value="Partial" {{ $financial->payment_status === 'Partial' ? 'selected' : '' }}>Partial</option>
                                <option value="Unpaid"  {{ $financial->payment_status === 'Unpaid'  ? 'selected' : '' }}>Unpaid</option>
                                <option value="Overdue" {{ $financial->payment_status === 'Overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Payment Date</label>
                            <input class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary" type="date" name="payment_date" value="{{$financial->payment_date}}" />
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
        @if($errors->any())
            <ul>
                <div class="fixed top-4 left-1/2 -translate-x-1/2 z-50 bg-red-100 border border-red-400 text-red-700 px-6 py-3 rounded-lg shadow-lg">
                    {{ $errors}}
                </div>
            </ul>
        @endif
    </x-layouts.master>