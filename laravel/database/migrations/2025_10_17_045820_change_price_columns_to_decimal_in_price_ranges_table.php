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
        Schema::table('price_ranges', function (Blueprint $table) {
 $table->decimal('min_price', 8, 2)->nullable()->change();
        $table->decimal('max_price', 8, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('price_ranges', function (Blueprint $table) {
            $table->integer('min_price')->nullable()->change();
        $table->integer('max_price')->nullable()->change();
        });
    }
};