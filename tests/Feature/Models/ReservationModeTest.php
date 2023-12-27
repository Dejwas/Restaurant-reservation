<?php

use Carbon\Carbon;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\ReservationGuest;

it('attaches reservation relations correctly', function() {
    $restaurant = Restaurant::factory()->create();
    $reservation = Reservation::factory()->create([
        'restaurant_id' => $restaurant->id,
        'reservation_start_time' => Carbon::now()->addHours(1)->format('Y-m-d H:i'),
        'reservation_end_time' => Carbon::now()->addHours(2)->format('Y-m-d H:i')
    ]);

    expect($reservation->restaurant()->first()->id)->toBe($restaurant->id);
    
    $reservation->reservationGuests()->create([
        'first_name' => fake()->firstName,
        'last_name' => fake()->lastName,
        'email' => fake()->email
    ]);

    expect(ReservationGuest::latest()->first()->reservation_id)->toBe($reservation->id);
});