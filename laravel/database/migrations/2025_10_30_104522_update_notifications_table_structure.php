<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationsTableStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // 🗑 Remove old columns
            $table->dropMorphs('notifiable'); // removes notifiable_id and notifiable_type
            $table->dropColumn(['type', 'data', 'read_at']);

            // ➕ Add new columns
            $table->string('message', 250)->nullable();
            $table->enum('message_type', ['whatsapp', 'sms']);
            $table->enum('status', ['not_sent', 'sent', 'failed'])->default('not_sent');
            $table->enum('resend', ['yes', 'no'])->default('no');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('sender_mobile_no', 50)->nullable();
            $table->string('recipient_mobile_no', 50)->nullable();
            $table->text('response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Restore dropped columns
            $table->string('type')->nullable();
            $table->morphs('notifiable');
            $table->text('data')->nullable();
            $table->timestamp('read_at')->nullable();

            // Remove newly added columns
            $table->dropColumn([
                'message',
                'message_type',
                'status',
                'resend',
                'created_by',
                'sender_mobile_no',
                'recipient_mobile_no',
                'response',
            ]);
        });
    }
}