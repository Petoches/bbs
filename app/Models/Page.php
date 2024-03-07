<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'username';
    }

    protected $fillable = [
        'instagram_id',
        'username',
        'account_type',
        'token',
        'user_id'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function medias(): HasMany {
        return $this->hasMany(Media::class);
    }
}
