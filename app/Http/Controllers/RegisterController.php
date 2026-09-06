<?php

namespace App\Http\Controllers;

use App\Models\Registry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:registers,email',
            'course'   => [
                'required', 
                Rule::in([
                    'BS Information Technology', 
                    'BS Computer Science', 
                    'BS Information Systems', 
                    'BS Business Administration'
                ])
            ],
            'username' => 'required|unique:registers,username',
            'password' => 'required|min:6',
        ]);

        Registry::create([
            'name'     => $fields['name'],
            'email'    => $fields['email'],
            'course'   => $fields['course'],
            'username' => $fields['username'],
            'password' => Hash::make($fields['password']),
        ]);
        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }
}