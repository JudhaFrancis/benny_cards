<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceRange extends Model
{
    use \App\Traits\HasPhotoUrl;

    protected $fillable = [
        'title',
        'slug',
        'min_price',
        'max_price',
        'photo',
        'status',
        'added_by',
        'modified_by'
    ];
}
