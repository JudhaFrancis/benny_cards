<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use SoftDeletes;

    protected $table = 'product_reviews';

    protected $fillable = [
        'id',
        'user_id',
        'reviewer_name',
        'title',
        'image',
        'product_id',
        'rating',
        'description',
        'status',
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
