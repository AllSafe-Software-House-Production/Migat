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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'package', 'tour', 'airport_transfer'

            // Shared or type-specific fields
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // Package Request
            $table->unsignedInteger('no_of_people')->nullable();
            $table->string('hotel')->nullable();
            $table->date('date_of_reservation')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('room_type')->nullable();

            // Tour Request
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->string('full_name')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_file')->nullable(); // store file path

            // Airport Transfer Request
            $table->string('religious_id')->nullable();
            $table->string('religious_name')->nullable();
            $table->string('tour_type')->nullable();
            $table->unsignedInteger('no_of_members')->nullable();
            $table->date('transfer_date')->nullable();
            $table->time('transfer_time')->nullable();
            $table->string('transfer_payment_status')->nullable();
            $table->boolean('religious_guide')->nullable();

            $table->string('pickup_location')->nullable();
            $table->string('dropoff_location')->nullable();
            $table->string('flight_number')->nullable();
            $table->unsignedInteger('no_of_guests')->nullable();
            $table->string('transfer_type')->nullable();
            $table->string('transportation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
