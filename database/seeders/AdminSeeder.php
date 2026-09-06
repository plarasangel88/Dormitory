<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@dormportal.com'], // unique lookup key
            [
                'name'     => 'System Administrator',
                'username' => 'admin',
                'course'   => null, // admins likely don't need a course
                'password' => Hash::make('changeme123'), // change this
                'role'     => 'admin',
            ]
        );
    }
}