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
        Schema::create('bills', function (Blueprint $t) {
            $t->id();
            $t->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $t->date('billing_month');                    // always the 1st of the month
            $t->decimal('rent', 10, 2)->default(0);
            $t->decimal('electricity', 10, 2)->default(0);
            $t->decimal('water', 10, 2)->default(0);
            $t->date('due_date')->nullable();
            $t->string('remarks')->nullable();
            $t->timestamps();
            $t->unique(['student_id', 'billing_month']);
        });

        Schema::table('payments', function (Blueprint $t) {
            $t->foreignId('bill_id')->nullable()->after('id')->constrained('bills')->nullOnDelete();
            $t->string('applies_to', 20)->default('rent')->after('bill_id'); // rent | electricity | water
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Payments first, because its foreign key points at bills
        Schema::table('payments', function (Blueprint $t) {
            $t->dropConstrainedForeignId('bill_id');
            $t->dropColumn('applies_to');
        });

        Schema::dropIfExists('bills');
    }
};