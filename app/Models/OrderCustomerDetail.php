<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderCustomerDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'name',
        'email',
        'phone',
        'country',
        'city_1',
        'state_1',
        'post_code_1',
        'address_1',
        'address_2',
        'city_2',
        'state_2',
        'post_code_2',
        'remarks',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
