<?php

namespace App\Models;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationTable extends Model
{
    use HasFactory;

    protected $fillable = ['table_id', 'reservation_id'];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
    
    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }
}
