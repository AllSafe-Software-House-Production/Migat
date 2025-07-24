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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->boolean('availability')->default(true);
            $table->text('description')->nullable();
            $table->json('photos')->nullable();
            $table->string('distance_from_haram')->nullable();
            $table->text('special_check_in_instructions')->nullable();
            $table->string('access_methods')->nullable();
            $table->string('pets')->nullable();
            $table->decimal('commission', 5, 2)->nullable();
            $table->string('commercial_register')->nullable();
            $table->string('tourism_license')->nullable();
            $table->string('utility_bill')->nullable();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('ipan')->nullable();
            $table->string('visa')->nullable();
            $table->integer('number_of_rooms')->default(0);
            $table->string('phone');
            $table->string('email')->unique();

            $table->json('service_ids')->nullable();
            $table->json('policy_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
