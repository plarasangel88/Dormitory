<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('student.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $fields = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'contact_number' => ['nullable', 'string', 'max:30'],
            'course' => [
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
        ]);

        $user->update($fields);

        return back()->with('success', 'Profile updated successfully!');
    }
}
