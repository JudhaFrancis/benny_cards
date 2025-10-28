<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'orders_id',
        'product_id',
        'net_amount',
        'discount',
        'final_amount',
        'quantity',
        'total_amount',
    ];

     public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
