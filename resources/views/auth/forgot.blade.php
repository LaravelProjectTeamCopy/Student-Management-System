<x-layouts.auth title="Forgot Password">

    <div class="w-full max-w-[480px] bg-white dark:bg-slate-900 rounded-xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-800">
    <div class="p-8 flex flex-col items-center">

        {{-- Logo --}}
        <div class="flex items-center gap-2 mb-8">
            <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                <span class="material-symbols-outlined text-3xl">school</span>
            </div>
            <h2 class="text-slate-900 dark:text-slate-100 text-2xl font-bold leading-tight tracking-tight">
                EduAdmin
            </h2>
        </div>

        {{-- Header --}}
        <div class="w-full text-center mb-6">
            <h1 class="text-slate-900 dark:text-slate-100 text-3xl font-bold mb-2">
                Forgot Your Password?
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">
                Enter your email address and we'll send you a 6-digit verification code.
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('sendOtp') }}" method="POST" class="w-full space-y-6">
            @csrf

            {{-- Email --}}
            <div class="flex flex-col gap-2">
                <label class="text-slate-900 dark:text-slate-200 text-sm font-medium leading-normal px-1">
                    Email Address
                </label>
                <div class="relative flex items-center">
                    <input
                        type="email"
                        name="email"
                        placeholder="example@email.com"
                        class="form-input w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 h-14 pl-4 pr-12 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400"
                    />
                    <div class="absolute right-4 text-slate-400 pointer-events-none">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="w-full bg-primary hover:bg-primary/90 text-white text-lg font-bold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2"
            >
                <span>Send Code</span>
                <span class="material-symbols-outlined text-xl">arrow_forward</span>
            </button>

        </form>

        {{-- Footer Link --}}
        <div class="mt-8">
            <a href="/login" class="text-primary font-medium text-sm hover:underline">
                Back to Login
            </a>
        </div>

    </div>
    </div>
    @if($errors->any())
        <ul>
            <div class="fixed top-4 left-1/2 -translate-x-1/2 z-50 bg-red-100 border border-red-400 text-red-700 px-6 py-3 rounded-lg shadow-lg">
                {{ $errors}}
            </div>
        </ul>
    @endif  
</x-layouts.auth>