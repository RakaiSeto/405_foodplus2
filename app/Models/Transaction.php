<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = ["quantity", "receiver_id", "donor_id", "donation_id"];
    //
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function donation(): BelongsTo {
        return $this->belongsTo(Donation::class);
    }
}
