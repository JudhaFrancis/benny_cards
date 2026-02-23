<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;
    use \App\Traits\HasPhotoUrl;

    protected $table = 'banners';

    protected $fillable = [
        'title',
        'slug',
        'photo',
        'description',
        'status',
    ];
}
