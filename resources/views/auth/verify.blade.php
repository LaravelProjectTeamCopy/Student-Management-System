<x-layouts.auth title="Verify Your Identity">

    <div class="w-full max-w-[480px] bg-white dark:bg-slate-900 rounded-xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-800">

        {{-- Logo + Header --}}
        <div class="pt-8 pb-4 flex flex-col items-center">

            <div class="flex items-center gap-3 mb-6">
                <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-3xl">school</span>
                </div>
                <h2 class="text-slate-900 dark:text-slate-100 text-2xl font-bold leading-tight tracking-tight">
                    EduAdmin
                </h2>
            </div>

            <div class="text-center">
                <h1 class="text-slate-900 dark:text-slate-100 text-3xl font-bold mb-2">
                    Verify Your Identity
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm">
                    Please enter the 6-digit code sent to your email.
                </p>
            </div>

        </div>

        {{-- Form --}}
        <form action="{{ route('verifyOtp') }}" method="POST" class="px-8 pb-10 text-center">
            @csrf

            {{-- Hidden input to hold combined OTP --}}
            <input type="hidden" name="otp" id="otpValue"/>

            {{-- OTP Inputs --}}
            <div class="flex justify-between gap-2 mb-8 mt-8" id="otp-container">
                <input type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code" class="otp-input w-12 h-14 text-center text-xl font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 rounded-lg outline-none transition-all"/>
                <input type="text" inputmode="numeric" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 rounded-lg outline-none transition-all"/>
                <input type="text" inputmode="numeric" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 rounded-lg outline-none transition-all"/>
                <input type="text" inputmode="numeric" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 rounded-lg outline-none transition-all"/>
                <input type="text" inputmode="numeric" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 rounded-lg outline-none transition-all"/>
                <input type="text" inputmode="numeric" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 rounded-lg outline-none transition-all"/>
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 mb-6"
            >
                Verify &amp; Proceed
            </button>

            {{-- Resend Link --}}
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 text-center">
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    Didn't receive the code?
                    <a href="{{route('sendOtp')}}" class="text-primary font-bold hover:underline ml-1">Resend Code</a>
                </p>
            </div>

        </form>

    </div>

    {{-- OTP JS --}}
    <script>
        // Auto jump to next input
        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });

        // Combine all digits into hidden input on submit
        document.querySelector('form').addEventListener('submit', () => {
            const digits = [...document.querySelectorAll('.otp-input')]
                .map(input => input.value)
                .join('');
            document.getElementById('otpValue').value = digits;
        });
    </script>
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