<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasPhotoUrl;

class Setting extends Model
{
    use HasPhotoUrl;

    protected $table = 'settings';

    protected $fillable = [
        'company_name',
        'description',
        'short_des',
        'logo',
        'photo',
        'address',
        'phone',
        'email',
        'facebook_url',
        'instagram_url',
    ];
}
