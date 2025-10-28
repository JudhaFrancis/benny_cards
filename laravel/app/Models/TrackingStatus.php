<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingStatus extends Model
{
    use HasFactory;

     protected $table = 'tracking_status';

     protected $fillable = ['name'];

      public function orders()
    {
        return $this->hasMany(Order::class, 'tracking_status_id');
    }
}


