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
            'email'  => ['required', 'email', Rule::unique('registers', 'email')->ignore($user->id)],
            'course' => [
                'required',
                Rule::in([
                    'BS Information Technology',
                    'BS Computer Science',
                    'BS Information Systems',
                    'BS Business Administration'
                ])
            ],
        ]);

        $user->update($fields);

        return back()->with('success', 'Profile updated successfully!');
    }
}