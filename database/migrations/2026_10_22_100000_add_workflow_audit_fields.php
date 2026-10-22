<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->boolean('email_verification_required')->default(false);
        });

        Schema::table('maintenance_requests', function (Blueprint $table): void {
            $table->foreignId('assigned_to')->nullable()->after('resolved_by')->constrained('users')->nullOnDelete();
            $table->timestamp('due_at')->nullable()->after('assigned_to');
        });

        Schema::create('payment_audits', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('student_id')->nullable()->index();
            $table->string('reference_number')->nullable()->index();
            $table->string('action', 40);
            $table->string('previous_status', 30)->nullable();
            $table->string('new_status', 30)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->json('details')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_audits');

        Schema::table('maintenance_requests', function (Blueprint $table): void {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn(['assigned_to', 'due_at']);
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn('email_verification_required');
        });
    }
};
