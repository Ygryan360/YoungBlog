<?php

namespace App\Http\Controllers;

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
        // Validation and registration logic here
        // For example, you might want to create a new user and save it to the database

        return redirect()->route('home')->with('success', 'Inscription réussie !');

    }
}
