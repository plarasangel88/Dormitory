<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Try to log in
        if (! Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {

            // Username or password is incorrect
            return back()
                ->withErrors([
                    'login' => 'Incorrect username or password.',
                ])
                ->withInput($request->only('username'));
        }

        // Regenerate session after successful login
        $request->session()->regenerate();

        $user = Auth::user();

        // ADMIN
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        // STUDENT
        return redirect()->route('dashboard');
    }
}
