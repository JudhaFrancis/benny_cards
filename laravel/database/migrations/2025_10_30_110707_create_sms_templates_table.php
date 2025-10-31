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
        Schema::create('sms_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event_name', 65)->nullable();
            $table->text('template_content')->nullable();
            $table->text('parameter')->nullable();
            $table->tinyInteger('allow_to_send')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->string('sender_id', 45)->nullable();
            $table->text('whatsapp_content')->nullable();
            $table->tinyInteger('module_id')->default(1);

            // Optional Laravel timestamps (created_at, updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_templates');
    }
};
