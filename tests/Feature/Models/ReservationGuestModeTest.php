<?php

use App\Models\Restaurant;
use App\Models\ReservationGuest;

it('attaches reservation guest relations correctly', function() {
    $restaurant = Restaurant::factory()->hasReservations(1)->create();

    $reservationGuest = ReservationGuest::create([
        'reservation_id' => $restaurant->reservations()->first()->id,
        'first_name' => fake()->firstName,
        'last_name' => fake()->lastName,
        'email' => fake()->email
    ]);

    expect($reservationGuest->reservation->id)->toBe($restaurant->reservations()->first()->id);
});