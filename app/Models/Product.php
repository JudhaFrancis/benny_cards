<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use \App\Traits\HasPhotoUrl;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'photo',
        'price',
        'discount',
        'status',
        'condition',
        'is_featured',
        'cat_id',
        'child_cat_id',
        'brand_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
