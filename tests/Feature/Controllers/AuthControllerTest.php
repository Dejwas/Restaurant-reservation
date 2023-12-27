<?php

use App\Models\User;

it('renders login successfully', function() {
    $this->get('/auth/create')
        ->assertStatus(200);
});

it('logins user successfully', function() {
    $user = User::factory()->create();

    $this->post('/auth', [
        'email' => $user->email,
        'password' => 'password'
    ])
        ->assertStatus(302)
        ->assertRedirect(route('restaurants.index'));
});

it('prevents login if credentials are wrong', function() {
    $this->post('/auth', [
        'email' => fake()->email,
        'password' => 'abc'
    ])
        ->assertStatus(302)
        ->assertRedirect('/')
        ->assertSessionHas(['error' => 'Invalid credentials']);
});

it('logouts user successfully', function() {
    $user = User::factory()->create();
    login($user);

    $this->delete('/auth')
        ->assertStatus(302)
        ->assertRedirect('/');
});