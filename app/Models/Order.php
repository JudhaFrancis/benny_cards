<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_number',
        'tracking_number',
        'order_date',
        'user_id',
        'items_count',
        'total_quantity',
        'net_amount',
        'coupons_id',
        'discount',
        'total_amount',
        'balance_due',
        'paid_amount',
        'status',
        'payment_status',
        'added_by',
        'modified_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'order_date' => 'datetime',
            'net_amount' => 'decimal:2',
            'discount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'balance_due' => 'decimal:2',
            'paid_amount' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
