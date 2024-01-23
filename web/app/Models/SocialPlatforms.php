<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialPlatforms extends Model
{
    use HasFactory;
    protected $fillable = [
        'social_name',
        'social_image',
        'social_link'
    ];
}
