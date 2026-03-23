<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductImage extends Model
{
    use \App\Traits\HasPhotoUrl;

    protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'image_path',
    ];

    protected function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $this->normalizeUrl($value),
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
