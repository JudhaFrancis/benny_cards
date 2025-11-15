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
        'status',
        'deleted_at',
    ];

     public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Soft delete method
    public function softDelete()
    {
        $this->update([
            'status' => 0,
            'deleted_at' => now(),
        ]);
    }
}
