<?php

use App\Models\Table;
use App\Models\Restaurant;
use App\Livewire\CreateRestaurant;
use function Pest\Livewire\livewire;

it('renders successfully', function() {
    livewire(CreateRestaurant::class)
        ->assertStatus(200);
});

it('prevents unauthenticated user to access create', function () {
    $this->get('/restaurants/create')
        ->assertRedirect('/login');
});

it('contains livewire component', function() {
    login()
        ->get('/restaurants/create')
        ->assertSeeLivewire('create-restaurant');
});

it('updates default table seats', function () {
    login()
        ->livewire(CreateRestaurant::class)
        ->set('form.tableInfo', [1, 2, 3])
        ->set('defaultTableSeats', 6)
        ->assertSet('defaultTableSeats', 6)
        ->assertSet('form.tableInfo', [6, 6, 6]);
});

it('updates invalid table seats with default value', function () {
    login()
        ->livewire(CreateRestaurant::class)
        ->set('defaultTableSeats', 6)
        ->set('form.tableInfo', ['a', 0, null])
        ->call('save')
        ->assertSet('defaultTableSeats', 6)
        ->assertSet('form.tableInfo', [6, 6, 6]);
});

it('updates form table array with new table', function () {
    login()
        ->livewire(CreateRestaurant::class)
        ->set('form.tableInfo', [4, 4, 4])
        ->set('form.tables', 4)
        ->assertSet('form.tableInfo', [4, 4, 4, 4]);
});

it('updates form table array with removed table', function () {
    login()
        ->livewire(CreateRestaurant::class)
        ->set('form.tableInfo', [4, 4, 4])
        ->set('form.tables', 2)
        ->assertSet('form.tableInfo', [4, 4]);
});

it('tests ReservationForm validation rules', function(string $field, mixed $value, string $rule) {
    livewire(CreateRestaurant::class)
        ->set('form.'.$field, $value)
        ->call('save')
        ->assertHasErrors([$field => $rule]);
})->with([
    'name is empty' => ['name', '', 'required'],
    'address is empty' => ['address', '', 'required'],
    'tables is null' => ['tables', null, 'required']
]);

it('saves form with redirect', function () {
    login()
        ->livewire(CreateRestaurant::class)
        ->set('form.name', 'Restaurant 541')
        ->set('form.address', '573 Ingram Street')
        ->set('form.tables', 5)
        ->set('form.tableInfo', [1, 3, 5, 7, 9])
        ->call('save')
        ->assertRedirect('/restaurants')
        ->assertSessionHas('success', 'Restaurant created.');

    $restaurant = Restaurant::latest()->first();

    expect($restaurant)
        ->name->toBe('Restaurant 541')
        ->address->toBe('573 Ingram Street');

    $tables = Table::where('restaurant_id', $restaurant->id)->get();

    expect(count($tables))->toBe(5);
    expect($tables[2]->capacity)->toBe(5);
});
