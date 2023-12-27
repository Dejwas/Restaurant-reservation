<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationGuest extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'reservation_id'];
    
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
