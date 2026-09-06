<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('rooms', function (Blueprint $table) {
        $table->id();
        $table->string('room_number');
        $table->string('building')->nullable();
        $table->string('floor')->nullable();
        $table->string('type')->nullable();
        $table->integer('capacity')->default(1);
        $table->decimal('monthly_rate', 8, 2)->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
