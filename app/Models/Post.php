<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'instagram_id',
        'shortcode',
        'display_url',
        'video_url',
        'description',
        'likes',
        'is_video'
    ];

}
