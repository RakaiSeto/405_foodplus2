<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    //
    protected $fillable = ["receiver_id", "donor_id"];
    public function  user(): BelongsTo {
        return $this->belongsTo(User::class, "receiver_id");
    }

    public function resto(): BelongsTo {
        return $this->belongsTo(User::class,  "donor_id");
    }

}
