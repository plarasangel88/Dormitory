<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();

            // Student who filed the request. Cascades on delete so orphaned
            // requests can't be left behind if a user account is removed.
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('category');          // e.g. Electrical, Plumbing, Furniture, Other
            $table->string('title');              // short summary
            $table->text('description');          // full details of the issue

            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['pending', 'in_progress', 'resolved'])->default('pending');

            // Optional notes left by staff/admin when updating status.
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};