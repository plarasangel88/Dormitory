<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('provider_reference')->nullable()->after('reference_number');
        });

        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('gcash_qr_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('provider_reference');
        });
    }
};
