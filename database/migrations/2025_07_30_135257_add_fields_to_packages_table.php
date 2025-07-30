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
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('no_of_days')->nullable();
            $table->decimal('hotel_price', 10, 2)->nullable();
            $table->string('hotel_trip_type')->nullable();
            $table->date('hotel_from')->nullable();
            $table->date('hotel_to')->nullable();
            $table->string('hotel_type')->nullable(); // Makah or Madinah
            $table->string('hotel_name')->nullable();
            $table->string('hotel_location')->nullable();
            $table->string('room_type')->nullable();
            $table->json('services')->nullable();
            $table->json('hotel_images')->nullable();
            $table->json('short_videos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'no_of_days',
                'hotel_location',
                'hotel_name',
                'hotel_full_location',
                'room_type',
                'services',
                'short_videos'
            ]);
        });
    }
};
