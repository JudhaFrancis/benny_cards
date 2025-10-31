<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmsTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sms_templates')->insert([
            'id' => 1,
            'event_name' => 'NEW_ORDER',
            'template_content' => 'Dear {customerName}, thank you for choosing InvitaPrint! Your order #{order_id} has been received. We’re excited to craft your perfect invitations. For assistance, contact us at 9876543210.',
            'parameter' => 'customerName,order_id',
            'allow_to_send' => 1,
            'status' => 1,
            'sender_id' => 'INVITECO',
            'whatsapp_content' => 'Dear {customerName}, thank you for choosing InvitaPrint! Your order #{order_id} has been received. We’re excited to craft your perfect invitations. For assistance, contact us at 9876543210.',
            'module_id' => 1,
        ]);
    }
}
