<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        sleep(1);

        // validate
        $fields = $request->validate([
            'avatar' => ['file', 'nullable', 'max:300'],
            'name' => ['required', 'max:225'],
            'email' => ['required', 'email', 'max:225', 'unique:users'],
            'password' => ['required', 'confirmed']
        ]);

        if ($request->hasFile('avatar')) {
            $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
        }

        // register
        $user = User::create($fields);

        // login
        Auth::login($user);

        // redirect
        return redirect()->route('dashboard')->with('greet', 'Welcome to Laravel Inertia Vue app');
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($fields, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard')->with('greet', 'Welcome to Laravel Inertia Vue app');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
