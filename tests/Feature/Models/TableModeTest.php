<?php

use App\Models\Table;
use App\Models\Restaurant;
use App\Models\ReservationTable;

it('attaches reservation table relations correctly', function() {
    $restaurant = Restaurant::factory()->hasReservations(1)->hasTables(1)->create();

    $reservationTable = ReservationTable::create([
        'reservation_id' => $restaurant->reservations()->first()->id,
        'table_id' => $restaurant->tables()->first()->id
    ]);

    expect(Table::first()->restaurant->id)->toBe($restaurant->id);
    expect(Table::first()->reservationTables()->first()->id)->toBe($reservationTable->id);
});