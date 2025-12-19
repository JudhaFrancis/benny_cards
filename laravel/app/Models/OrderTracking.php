<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    use HasFactory;

     protected $table = 'order_tracking';

    protected $fillable = [
        'orders_id',
        'tracking_status_id',
        'tracking_details', 
    ];

      protected $casts = [
        'tracking_details' => 'array', 
    ];

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    // Relationship with TrackingStatus
    public function status()
    {
        return $this->belongsTo(TrackingStatus::class, 'tracking_status_id');
    }
}
