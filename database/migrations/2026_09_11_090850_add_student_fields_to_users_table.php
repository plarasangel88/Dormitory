<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact_number')->nullable()->after('email');
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete()->after('contact_number');
            $table->string('status')->default('active')->after('room_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropColumn(['contact_number', 'room_id', 'status']);
        });
    }
};