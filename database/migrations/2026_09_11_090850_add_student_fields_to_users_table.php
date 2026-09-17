<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'contact_number')) {
                $table->string('contact_number')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'room_id')) {
                $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete()->after('contact_number');
            }

            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('room_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'room_id')) {
                $table->dropForeign(['room_id']);
            }

            $table->dropColumn(array_filter([
                Schema::hasColumn('users', 'contact_number') ? 'contact_number' : null,
                Schema::hasColumn('users', 'room_id') ? 'room_id' : null,
                Schema::hasColumn('users', 'status') ? 'status' : null,
            ]));
        });
    }
};