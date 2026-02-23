<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \App\Traits\HasPhotoUrl;

    protected $fillable = ['title', 'slug', 'summary', 'photo', 'status'];

    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id');
    }
}
