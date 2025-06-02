<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Comment extends Model
{
    protected $fillable = ["comment", "transaction_id", "user_id", "headline", "rating"];
    //
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function transaction(): BelongsTo {
        return $this->belongsTo(Transaction::class);
    }
}
