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
        Schema::table('tracking_status', function (Blueprint $table) {
    $table->tinyInteger('status')->nullable()->after('title'); // NULL allowed, no default

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking_status', function (Blueprint $table) {
            //
        });
    }
};
