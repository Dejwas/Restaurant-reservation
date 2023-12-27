<?php

use App\Models\Restaurant;
use App\Models\Reservation;

it('renders index successfully', function() {
    $this
        ->get(route('reservations.create'))
        ->assertStatus(200);
});

it('renders show successfully', function() {
    $restaurant = Restaurant::factory()->create();
    $reservation = Reservation::factory()->create([
        'restaurant_id' => $restaurant->id
    ]);

    login()
        ->get(route('reservations.show', ['reservation' => $reservation]))
        ->assertStatus(200);
});