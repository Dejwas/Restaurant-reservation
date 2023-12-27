<?php

namespace App\Models;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address'];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class)->orderBy('reservation_start_time');
    }

    public function upcomingReservations(): HasMany
    {
        return $this->hasMany(Reservation::class)->where('reservation_start_time', '>', now())->orderBy('reservation_start_time');
    }

    public function pastReservations(): HasMany
    {
        return $this->hasMany(Reservation::class)->where('reservation_end_time', '<', now())->orderBy('reservation_start_time');
    }

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }
}
