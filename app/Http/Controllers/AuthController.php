<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailVerificationCode;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use Hash;
use Mail;

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

        $username = explode('@', $request->email)[0] . rand(1000, 9999);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $username,
            'password' => Hash::make($request->password),
        ]);

        $user->sendEmailVerificationCode();

        Auth::login($user);

        return redirect()->route('verification.show')->with('success', 'Inscription réussie !');
    }

    public function showConfirmEmailForm(): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Vous devez être connecté pour envoyer un e-mail de vérification.']);
        }

        return view('auth.verify-email');
    }

    public function confirmEmail(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Vous devez être connecté pour confirmer votre e-mail.']);
        } elseif ($user->hasVerifiedEmail()) {
            return redirect()->route('home')->with('success', 'Votre e-mail est déjà vérifié.');
        }

        $request->validate([
            'code' => ['required', 'integer', 'digits:6'],
        ]);

        if ($request->code == $user->verification_code) {
            $user->markEmailAsVerified();
            $user->verification_code = null;
            $user->save();

            return redirect()->route('home')->with('success', 'Votre e-mail a été vérifié avec succès.');
        }

        return redirect()->back()->withErrors(['code' => 'Le code de vérification est incorrect.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
