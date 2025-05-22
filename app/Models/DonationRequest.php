<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'donation_id',
        'location', 
        'quantity',
        'notes',
        'status',
    ];

    /**
     * Relasi ke pengguna (penerima)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke donasi
     */
    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    /**
     * Relasi ke restoran
     */
    public function restaurant()
    {
        return $this->belongsTo(User::class, 'location');  // Diubah dari resto_id menjadi location
    }
}