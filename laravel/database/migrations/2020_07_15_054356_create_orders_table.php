<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Auto generate in model or observer
            $table->string('tracking_id')->unique();  // Auto generate
            $table->dateTime('order_date')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('items_count')->default(0);
            $table->integer('total_quantity')->default(0);
            $table->decimal('net_amount', 10, 2)->default(0);
            $table->foreignId('coupons_id')->nullable()->constrained('coupons')->nullOnDelete();
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('payment_method', ['cash', 'qr_code', 'upi', 'card', 'net_banking'])->nullable();
            $table->enum('payment_status', ['paid', 'due', 'unpaid'])->default('unpaid');
            $table->enum('status', ['active', 'pending', 'completed', 'returned', 'cancelled'])->default('pending');
            $table->foreignId('tracking_status_id')->nullable()->constrained('tracking_status')->nullOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('post_code')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}