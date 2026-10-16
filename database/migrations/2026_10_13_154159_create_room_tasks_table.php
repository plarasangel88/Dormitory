<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_by')->constrained('users')->cascadeOnDelete();
            $table->string('title', 120);
            $table->date('task_date');
            $table->boolean('is_done')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['room_id', 'task_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_tasks');
    }
};