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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('role');
            $table->string('gender')->nullable()->after('phone');
            $table->string('nickname')->nullable()->after('gender');
            $table->string('country')->nullable()->after('nickname');
            $table->string('language')->nullable()->after('country');
            $table->string('timezone')->nullable()->after('language');
            $table->string('extra_email')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['gender', 'nickname', 'country', 'language', 'timezone','extra_email']);
        });
    }
};
