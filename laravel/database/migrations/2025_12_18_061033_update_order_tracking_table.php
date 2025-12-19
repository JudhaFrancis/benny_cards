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
        Schema::table('order_tracking', function (Blueprint $table) {
            // remarks -> tracking_details
            $table->renameColumn('remarks', 'tracking_details');

            // tracking_date remove
            $table->dropColumn('tracking_date');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_tracking', function (Blueprint $table) {
            $table->renameColumn('tracking_details', 'remarks');
            $table->dateTime('tracking_date')->nullable();

           
        });
    }
};
