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
        // Modify hotels table
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['service_ids', 'policy_ids']);
            $table->string('service')->nullable();
            $table->string('policy')->nullable();
        });

        // Drop policies table
        Schema::dropIfExists('policies');

        // Drop services table (if exists)
        Schema::dropIfExists('services');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert hotels table
        Schema::table('hotels', function (Blueprint $table) {
            $table->json('service_ids')->nullable();
            $table->json('policy_ids')->nullable();
            $table->dropColumn(['service', 'policy']);
        });

        // Recreate policies table
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Recreate services table (if it existed before)
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
};
