<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
protected $fillable = [
    'user_id',
    'order_number',
    'tracking_id',
    'order_date',
    'items_count',
    'total_quantity',
    'net_amount',
    'coupons_id',
    'discount',
    'total_amount',
    'paid_amount',
    'payment_method',
    'payment_status',
    'status',
    'tracking_status_id',
    'name',
    'email',
    'phone',
    'country',
    'post_code',
    'address_1',
    'address_2',
    'remarks'
];
    public function cart_info(){
        return $this->hasMany('App\Models\Cart','order_id','id');
    }
    public static function getAllOrder($id){
        return Order::with('cart_info')->find($id);
    }
    public static function countActiveOrder(){
        $data=Order::count();
        if($data){
            return $data;
        }
        return 0;
    }
    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function shipping(){
        return $this->belongsTo(Shipping::class,'shipping_id');
    }
    // public function user()
    // {
    //     return $this->belongsTo('App\User', 'user_id');
    // }

// Order -> Order Items
public function items(){
    return $this->hasMany(OrderItems::class, 'orders_id', 'id')
                ->where('status', 1);
}


// Order -> Tracking history
public function trackingHistory(){
    return $this->hasMany(OrderTracking::class, 'orders_id', 'id');
}

// Order -> User
public function user(){
    return $this->belongsTo(User::class, 'user_id', 'id');
}

// Order -> Tracking Status
public function trackingStatus(){
    return $this->belongsTo(TrackingStatus::class, 'tracking_status_id', 'id');
}

public function orderItems()
{
    return $this->hasMany(OrderItems::class, 'orders_id', 'id');
}


}
