<?php

namespace App\Models;

use App\Models\Restaurant;
use App\Models\ReservationTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_first_name',
        'contact_last_name',
        'contact_email',
        'contact_phone',
        'reservation_start_time',
        'reservation_end_time',
        'restaurant_id'
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function reservationGuests(): HasMany
    {
        return $this->hasMany(ReservationGuest::class);
    }

    public function reservationTables(): HasMany
    {
        return $this->hasMany(ReservationTable::class);
    }
}
