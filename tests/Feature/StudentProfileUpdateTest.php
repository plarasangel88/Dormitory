<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StudentProfileUpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('course')->nullable();
            $table->string('role')->default('student');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('emergency_contact_number', 30)->nullable();
            $table->string('residency_place', 255)->nullable();
            $table->string('status')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function test_student_can_update_emergency_contact_and_residency_place(): void
    {
        $student = User::create([
            'name' => 'Test Student',
            'email' => 'student@example.test',
            'password' => 'password',
            'course' => 'Education',
            'role' => 'student',
        ]);

        $response = $this->actingAs($student)->post(route('profile.update'), [
            'name' => $student->name,
            'email' => $student->email,
            'course' => 'Education',
            'contact_number' => '09171234567',
            'emergency_contact_number' => '09981234567',
            'residency_place' => 'San Fernando, Pampanga',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'emergency_contact_number' => '09981234567',
            'residency_place' => 'San Fernando, Pampanga',
        ]);
    }

    public function test_student_profile_rejects_overlong_emergency_contact_number(): void
    {
        $student = User::create([
            'name' => 'Test Student',
            'email' => 'student@example.test',
            'password' => 'password',
            'course' => 'Education',
            'role' => 'student',
        ]);

        $response = $this->actingAs($student)->from(route('profile'))->post(route('profile.update'), [
            'name' => $student->name,
            'email' => $student->email,
            'course' => 'Education',
            'emergency_contact_number' => str_repeat('1', 31),
        ]);

        $response->assertRedirect(route('profile'));
        $response->assertSessionHasErrors('emergency_contact_number');
    }
}
