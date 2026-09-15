<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Adjust 'students' to your actual students table name if different.
            $table->foreignId('student_id')
                  ->constrained('students')
                  ->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['cash', 'gcash', 'bank_transfer', 'other'])
                  ->default('cash');
            $table->enum('status', ['paid', 'pending', 'overdue'])
                  ->default('pending');
            $table->string('reference_number', 50)->nullable();
            $table->date('payment_date');
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};