<?php

namespace App\Models;

use DateTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['capacity', 'table_number', 'restaurant_id'];
    
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
    
    public function reservationTables(): HasMany
    {
        return $this->hasMany(ReservationTable::class);
    }

    public function scopeAvailableTables(
        Builder | QueryBuilder $query,
        int $restaurant_id,
        DateTime $reservation_start_time,
        DateTime $reservation_end_time
    ): Builder | QueryBuilder
    {
        return $query->where('restaurant_id', $restaurant_id)
            ->whereNotIn('id', function($query) use($restaurant_id, $reservation_start_time, $reservation_end_time) {
                $query->select('table_id')
                    ->from('reservation_tables')
                    ->join('reservations', 'reservation_tables.reservation_id', '=', 'reservations.id')
                    ->where('restaurant_id', $restaurant_id)
                    ->where(function($query) use($reservation_start_time, $reservation_end_time) {
                        $query->whereBetween('reservations.reservation_start_time', [$reservation_start_time, $reservation_end_time])
                            ->orWhereBetween('reservations.reservation_end_time', [$reservation_start_time, $reservation_end_time]);
                    });
            });
    }
}
