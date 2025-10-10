<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create($validated);
        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate(); // security

            return redirect()->route('home');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Sorry, incorrect credentials',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken(); // security

        return redirect()->route('show.login');
    }
}