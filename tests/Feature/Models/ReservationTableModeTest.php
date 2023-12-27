<?php

use App\Models\Restaurant;
use App\Models\ReservationTable;

it('attaches reservation table relations correctly', function() {
    $restaurant = Restaurant::factory()->hasReservations(1)->hasTables(1)->create();

    $reservationTable = ReservationTable::create([
        'reservation_id' => $restaurant->reservations()->first()->id,
        'table_id' => $restaurant->tables()->first()->id
    ]);

    expect($reservationTable->reservation->id)->toBe($restaurant->reservations()->first()->id);
});