<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function registerSave(Request $request)
{
    // Validate input
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email', // Ensure email is unique
        'password' => 'required|confirmed'
    ]);

    // Generate a 6-digit PIN
    $pin = mt_rand(100000, 999999);

    // Store the data in the session temporarily
    session([
        'registration_data' => [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ],
        'verification_pin' => $pin,
    ]);

    // Send the PIN to the user's email
    Mail::to($request->email)->send(new \App\Mail\SendVerificationPin($pin));

    // Redirect to the verification page with a message
    return redirect()->route('authentication')->with('message', 'A verification PIN has been sent to your email.');
}


    public function authentication(){
        return view('auth.authentication');
    }

    public function verifyPin(Request $request)
{
    $request->validate([
        'pin' => 'required|array',
        'email' => 'required|email',
    ]);

    // Combine the PIN array into a single string
    $enteredPin = implode('', $request->pin);

    // Retrieve session data
    $sessionPin = session('verification_pin');
    $registrationData = session('registration_data');

    if ($enteredPin == $sessionPin && $request->email == $registrationData['email']) {
        // Save the user to the database
        User::create([
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'password' => Hash::make($registrationData['password']),
            'type' => "0",
        ]);

        // Clear session data   
        session()->forget(['verification_pin', 'registration_data']);

        return redirect()->route('login')->with('message', 'Account verified! You can now login.');
    }

    return back()->withErrors(['pin' => 'Invalid PIN. Please try again.']);
}



    public function login(){
        return view('auth.login');
    }
    
    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        $request->session()->regenerate();

        // Redirect based on user type
        if (auth()->user()->type == 1) {
            // Admin
            return redirect()->route('admin/home');
        } elseif (auth()->user()->type == 3) {
            // Doctor
            return redirect()->route('cashier/home');
        } elseif (auth()->user()->type == 2){
            return redirect()->route('doctor/home');
        } else {
            // Regular user 
            return redirect()->route('home');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token to prevent CSRF attacks
        $request->session()->regenerateToken();

        // Redirect to the login page (or wherever you'd like)
        return redirect('/login');
    }

    public function forgotPassword(){
        return view('auth.forgotPassword');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        $token = Password::getRepository()->create($user); // ✅ Correct way to create token

        $resetUrl = url('/reset-password/' . $token . '?email=' . $request->email);

        // Send email
        Mail::to($request->email)->send(new ForgotPasswordMail($resetUrl));

        return back()->with('success', 'Email sent successfully!');
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Your password has been reset.');
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
