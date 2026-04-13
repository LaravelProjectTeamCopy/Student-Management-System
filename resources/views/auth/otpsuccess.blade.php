<x-layouts.auth title="Verification Successful">

    <div class="flex min-h-screen items-center justify-center p-4">
    <div class="w-full max-w-[480px] bg-white dark:bg-slate-900 rounded-xl shadow-lg overflow-hidden p-8 md:p-12">
    <div class="flex flex-col items-center">

        {{-- Logo --}}
        <div class="flex items-center gap-2 mb-10">
            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-2xl">school</span>
            </div>
            <span class="text-2xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">
                EduAdmin
            </span>
        </div>

        {{-- Success Icon --}}
        <div class="mb-8 flex items-center justify-center">
            <div class="w-24 h-24 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-6xl">check_circle</span>
            </div>
        </div>

        {{-- Header --}}
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 text-center mb-4">
            Verification Successful
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-center text-lg leading-relaxed mb-10">
            Your identity has been verified. You can now proceed to set your new password.
        </p>

        {{-- Action Button --}}
        <div class="w-full">
            <a
                href="/dashboard"
                class="w-full flex items-center justify-center bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-lg transition-colors text-lg shadow-md shadow-primary/20"
            >
                Continue
            </a>
        </div>

        {{-- Footer --}}
        <div class="mt-8">
            <p class="text-sm text-slate-400 dark:text-slate-500">
                Secure connection verified
            </p>
        </div>

    </div>
    </div>
    </div>

</x-layouts.auth>