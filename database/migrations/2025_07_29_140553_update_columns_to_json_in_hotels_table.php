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
        Schema::table('hotels', function (Blueprint $table) {
            $table->json('utility_bill')->nullable()->change();
            $table->json('policy')->nullable()->change();
            $table->json('service')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('utility_bill')->nullable()->change();
            $table->string('policy')->nullable()->change();
            $table->string('service')->nullable()->change();
        });
    }
};
