<x-layouts.auth title="Password Reset Successful">

    <div class="w-full max-w-[480px] flex flex-col items-center">
    <div class="w-full bg-white dark:bg-slate-900 rounded-xl shadow-xl shadow-primary/5 p-8 flex flex-col items-center border border-primary/10">
    <div class="p-8 flex flex-col items-center text-center">

        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="size-10 flex items-center justify-center bg-primary rounded-lg text-white">
                <span class="material-symbols-outlined text-2xl">school</span>
            </div>
            <h2 class="text-slate-900 dark:text-slate-100 text-2xl font-bold leading-tight tracking-[-0.015em]">
                EduAdmin
            </h2>
        </div>

        {{-- Success Icon --}}
        <div class="mb-8 flex items-center justify-center">
            <div class="relative">
                <div class="absolute inset-0 bg-green-100 dark:bg-green-900/30 rounded-full scale-[1.8] opacity-50"></div>
                <div class="relative bg-green-500 text-white rounded-full p-4 flex items-center justify-center">
                    <span class="material-symbols-outlined !text-5xl">check_circle</span>
                </div>
            </div>
        </div>

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-slate-900 dark:text-slate-100 text-2xl font-bold mb-2">
                Password Reset Successful
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">
                Your password has been updated. You can now log in with your new credentials.
            </p>
        </div>

        {{-- Action Button --}}
        <div class="w-full">
            <a
                href="#"
                class="w-full bg-primary hover:bg-blue-700 text-white font-semibold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 group"
            >
                <span class="material-symbols-outlined text-xl">login</span>
                <span>Back to Login</span>
            </a>
        </div>

    </div>
    </div>
    </div>

</x-layouts.auth>