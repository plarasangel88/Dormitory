<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['users', 'students'] as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'emergency_contact_number')) {
                    $table->string('emergency_contact_number', 30)->nullable();
                }

                if (!Schema::hasColumn($tableName, 'residency_place')) {
                    $table->string('residency_place', 255)->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        foreach (['users', 'students'] as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            $columns = array_values(array_filter(
                ['emergency_contact_number', 'residency_place'],
                fn (string $column) => Schema::hasColumn($tableName, $column)
            ));

            if ($columns !== []) {
                Schema::table($tableName, fn (Blueprint $table) => $table->dropColumn($columns));
            }
        }
    }
};
