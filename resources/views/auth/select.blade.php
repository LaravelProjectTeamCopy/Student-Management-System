<x-layouts.auth title="Verification Method">

    {{-- Background Decoration --}}
    <div class="fixed -z-10 top-0 left-0 w-full h-full opacity-50 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-[480px] bg-white dark:bg-slate-900 rounded-xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-800">

        {{-- Logo --}}
        <div class="flex flex-col items-center border-slate-100 dark:border-slate-800 pb-4 pt-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-3xl">school</span>
                </div>
                <h2 class="text-slate-900 dark:text-slate-100 text-2xl font-bold leading-tight tracking-tight">
                    EduAdmin
                </h2>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-8">

            {{-- Header --}}
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-2">
                    Select Verification Method
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">
                    Choose how you would like to proceed with your account recovery.
                </p>
            </div>

            {{-- Options --}}
            <div class="space-y-4">

                {{-- Option 1: Email OTP --}}
                <a href="/forgot"><button class="w-full flex items-center gap-4 p-4 rounded-xl border-2 border-slate-100 dark:border-slate-800 hover:border-primary/50 hover:bg-primary/5 transition-all text-left group">
                    <div class="flex items-center justify-center size-12 rounded-lg bg-primary/10 text-primary shrink-0 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-3xl">mail</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-slate-900 dark:text-slate-100 font-semibold text-base">Send OTP to Email</p>
                        <p class="text-slate-500 dark:text-slate-400 text-xs">A code will be sent to your registered email address</p>
                    </div>
                    <div class="text-slate-300 group-hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                </button></a>

                {{-- Option 2: Reset via Password --}}
                <a href = "/reset"><button class="w-full flex items-center gap-4 p-4 rounded-xl border-2 border-slate-100 dark:border-slate-800 hover:border-primary/50 hover:bg-primary/5 transition-all text-left group">
                    <div class="flex items-center justify-center size-12 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 shrink-0 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-3xl">vpn_key</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-slate-900 dark:text-slate-100 font-semibold text-base">Reset via Password</p>
                        <p class="text-slate-500 dark:text-slate-400 text-xs">Use your security questions or old password</p>
                    </div>
                    <div class="text-slate-300 group-hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                </button></a>

            </div>

            {{-- Footer Link --}}
            <div class="mt-8 text-center">
                <a href="/login" class="text-primary hover:text-primary/80 font-medium text-sm inline-flex items-center gap-1 transition-colors">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Back to Login
                </a>
            </div>

        </div>

    </div>

</x-layouts.auth>