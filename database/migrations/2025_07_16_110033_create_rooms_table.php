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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->enum('room_type', ['single', 'double', 'large']);
            $table->float('space')->nullable();
            $table->integer('number_of_beds')->default(1);
            $table->integer('number_of_adults')->default(1);
            $table->integer('number_of_children')->default(0);
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
