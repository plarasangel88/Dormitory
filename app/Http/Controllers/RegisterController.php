<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'course'   => [
                'required',
                Rule::in([
                    'Information Technology',
                    'Education',
                    'Criminology',
                    'Office Administration',
                    'Political Science',
                    'Communication',
                ])
            ],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')],
            'password' => [
                'required',
                'string',
                'min:8',
                'different:username',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/',
            ],
        ], [
            'password.min' => 'The password must be at least 8 characters long.',
            'password.different' => 'The password must be different from your username.',
            'password.regex' => 'The password must include lowercase and uppercase letters, a number, and a symbol.',
        ]);

        User::create([
            'name'     => $fields['name'],
            'email'    => $fields['email'],
            'course'   => $fields['course'],
            'username' => $fields['username'],
            'password' => Hash::make($fields['password']),
            'role'     => 'student', // required if your `users` table has no default for this
        ]);

        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }
}
