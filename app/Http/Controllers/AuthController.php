<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->route('verification.show')->with('success', 'Inscription réussie !');
    }

    public function sendVerificationEmail(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Vous devez être connecté pour envoyer un e-mail de vérification.']);
        }

        // Logic to send verification email with $user->verification_code

        return redirect()->back()->with('success', 'E-mail de vérification envoyé !');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
