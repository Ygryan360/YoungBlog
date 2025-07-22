<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerificationCode;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Mail;
use App\Mail\VerificationEmail;

class AuthController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended();
        }

        return redirect()->back()->withErrors([
            'email' => 'Les identifiants fournis sont incorrects.',
        ])->withInput();
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:4'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validationCode = rand(100000, 999999);
        $username = explode('@', $request->email)[0] . rand(1000, 9999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $username,
            'verification_code' => $validationCode,
            'password' => Hash::make($request->password),
        ]);

        Mail::to($user->email)->send(new EmailVerificationCode($user));

        Auth::login($user);

        return redirect()->route('verification.confirm')->with('success', 'Inscription réussie !');
    }

    public function confirmEmail(Request $request): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Vous devez être connecté pour envoyer un e-mail de vérification.']);
        }

        return view('auth.verify-email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
