<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_number');
                $table->string('tracking_number')->nullable();
                $table->datetime('order_date')->nullable();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->integer('items_count')->default(0);
                $table->integer('total_quantity')->default(0);
                $table->decimal('net_amount', 10, 2)->default(0.00);
                $table->foreignId('coupons_id')->nullable(); // Assuming there might be a coupons table later, not constrained strictly yet to avoid errors if missing
                $table->decimal('discount', 10, 2)->default(0.00);
                $table->decimal('total_amount', 10, 2)->default(0.00);
                $table->decimal('balance_due', 10, 2)->default(0.00);
                $table->decimal('paid_amount', 10, 2)->default(0.00);
                $table->enum('status', ['active', 'pending', 'completed', 'returned', 'cancelled'])->default('pending');
                $table->enum('payment_status', ['paid', 'unpaid', 'due'])->default('unpaid');
                $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('modified_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
