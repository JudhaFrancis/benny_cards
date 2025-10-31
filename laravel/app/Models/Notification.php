<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'message',
        'message_type',
        'status',
        'resend',
        'created_by',
        'response',
        'sender_mobile_no',
        'recipient_mobile_no',
        'created_at',
        'updated_at',
    ];
}
