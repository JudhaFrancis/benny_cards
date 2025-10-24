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
        Schema::create('tracking_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Default statuses
        DB::table('tracking_status')->insert([
            ['name' => 'Confirmed'],
            ['name' => 'Processing'],
            ['name' => 'Packed'],
            ['name' => 'Out for Delivery'],
            ['name' => 'Delivered'],
            ['name' => 'Cancelled'],
            ['name' => 'Return Requested'],
            ['name' => 'Return'],
        ]);
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_status');
    }
};
