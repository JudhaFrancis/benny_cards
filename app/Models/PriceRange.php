<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceRange extends Model
{
    use SoftDeletes;
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
