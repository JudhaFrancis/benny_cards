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
        Schema::create('order_tracking', function (Blueprint $table) {
            $table->id();
           $table->foreignId('orders_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('tracking_status_id')->constrained('tracking_status')->cascadeOnDelete();
            $table->dateTime('tracking_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tracking');
    }
};
