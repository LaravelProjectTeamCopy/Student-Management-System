<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Mail\emailOTP;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class authcontroller extends Controller
{
    public function showlogin()
    {
        return view('auth.login');
    }
    public function showregister()
    {
        return view('auth.register');
    }
    public function showforgot()
    {
        return view('auth.forgot');
    }
    public function showsuccess()
    {
        return view('auth.success');
    }   
    public function showverify()
    {
        return view('auth.verify');
    }
    public function showotpsuccess()
    {
        return view('auth.otpsuccess');
    }
    public function showselect()
    {
        return view('auth.select');
    }
    public function showreset()
    {
        return view('auth.reset');

    }
    public function showemail()
    {
        return view('emails.email');
    }
    public function messagelogin()
    {
        if (auth()->check()) {
        return redirect('/dashboard')->with('success', 'Welcome back, ' . auth()->user()->name . '!');
        }
        return redirect('/login');
    }
    public function register(Request $request)
    {     
        $validated = $request->validate([
            'name' => 'required|string|unique:users,name|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect('/login')->with('success', 'Registration successful! You can now log in.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have been logged out.');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Login Successful.');
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'  // ← also fix this
        ]);

        $otp = rand(100000, 999999);
        cache()->put('otp_' . $request->email, $otp, now()->addMinutes(10));
        Mail::to($request->email)->send(new emailOTP((string) $otp));

        session(['reset_email' => $request->email]); // ← store email for next steps

        return redirect('/verify');
    }

    public function verifyOtp(Request $request)
    {
        $email = session('reset_email'); // ← get email from session

        $stored = cache()->get('otp_' . $email);

        if (!$stored || $stored != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        cache()->forget('otp_' . $email);
        $user = User::where('email', $email)->first();
        Auth::login($user);
        return redirect('/otpsuccess');
    }

    public function resetpassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('/login')->with('success', 'Password reset successful!');
    }
}
