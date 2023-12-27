<?php

use App\Models\Restaurant;

it('renders index successfully', function() {
    $restaurant = Restaurant::factory()->create();

    login()
        ->get('/restaurants')
        ->assertStatus(200)
        ->assertSee($restaurant->name);
});

it('renders show successfully', function() {
    $restaurant = Restaurant::factory()->create();

    login()
        ->get('/restaurants/'.$restaurant->id)
        ->assertStatus(200);
});