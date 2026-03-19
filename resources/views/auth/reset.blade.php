<x-layouts.auth title="Set New Password">

    <div class="w-full max-w-[480px]">
    <div class="w-full bg-white dark:bg-slate-900 rounded-xl shadow-xl shadow-primary/5 p-8 flex flex-col items-center border border-primary/10">

        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="size-10 flex items-center justify-center bg-primary rounded-lg text-white">
                <span class="material-symbols-outlined text-2xl">school</span>
            </div>
            <h2 class="text-slate-900 dark:text-slate-100 text-2xl font-bold leading-tight tracking-[-0.015em]">
                EduAdmin
            </h2>
        </div>

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-slate-900 dark:text-slate-100 text-2xl font-bold mb-2">
                Set New Password
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">
                Please enter your new password below to update your account security.
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('handleResetPassword') }}" method="POST" class="w-full space-y-6">
            @csrf
            
            <div class="flex flex-col gap-2">
                <label class="text-slate-700 dark:text-slate-300 text-sm font-medium">
                    Email Address
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email address with account"
                        class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                    />
                </div>
            </div>
            
            {{-- New Password --}}
            <div class="flex flex-col gap-2">
                <label class="text-slate-700 dark:text-slate-300 text-sm font-medium">
                    New Password
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                    <input
                        type="password"
                        name="password"
                        value = "{{ old('password') }}" 
                        placeholder="Enter at least 8 characters"
                        class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                    />
                </div>
            </div>

            {{-- Confirm Password --}}
            <div class="flex flex-col gap-2">
                <label class="text-slate-700 dark:text-slate-300 text-sm font-medium">
                    Confirm New Password
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">verified_user</span>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Re-type new password"
                        class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                    />
                </div>
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="w-full bg-primary hover:bg-blue-700 text-white font-semibold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 group"
            >
                <span>Reset Password</span>
                <span class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>

        </form>

        {{-- Footer Link --}}
        <div class="mt-6 text-center">
            <p class="text-slate-500 dark:text-slate-400 text-sm">
                Remember your password?
                <a href="/login" class="text-primary font-semibold hover:underline">Back to login</a>
            </p>
        </div>

    </div>
    @if($errors->any())
        <div class = "fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</x-layouts.auth>