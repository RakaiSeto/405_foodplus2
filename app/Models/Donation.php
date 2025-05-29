<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donation extends Model
{
    use HasFactory;
    //
    protected $fillable = ["food_name", "quantity", "location", "category", "user_id", "image_url"];

    public function user():BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany {
        return $this->hasMany(Transaction::class);
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany {
        return $this->hasMany(Like::class);
    }
}
