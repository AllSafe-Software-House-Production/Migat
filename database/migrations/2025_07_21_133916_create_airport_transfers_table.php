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
        Schema::create('airport_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_name');
            $table->string('car_plate_number');
            $table->string('whatsapp_number');
            $table->string('type_of_car');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airport_transfers');
    }
};
