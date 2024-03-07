<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'media_id',
        'media_type',
        'media_url',
        'permalink',
        'timestamp',
        'page_id',
        'parent_id'
    ];
}
