<?php

use Carbon\Carbon;
use App\Models\Table;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\ReservationTable;
use App\Livewire\CreateReservation;
use function Pest\Livewire\livewire;

it('renders successfully', function() {
    livewire(CreateReservation::class)
        ->assertStatus(200);
});

it('contains livewire component', function() {
    $this->get('/reservations/create')
        ->assertSeeLivewire('create-reservation');
});

it('sets initial data', function() {
    $currentDateTime = Carbon::now()->format('Y-m-d H:i');
    $restaurantCount = fake()->numberBetween(1, 50);
    Restaurant::factory($restaurantCount)->create();

    livewire(CreateReservation::class)
        ->assertSet('availableSeats', 0)
        ->assertSet('form.reservationStartTime', $currentDateTime)
        ->assertViewHas('restaurants', function($restaurants) use($restaurantCount) {
            return count($restaurants) == $restaurantCount;
        });
});

it('updates available seats count', function() {
    $restaurantId = setupRestaurantWithTables([1, 3, 5]);

    livewire(CreateReservation::class)
        ->set('form.restaurantId', $restaurantId)
        ->set('form.duration', 1)
        ->assertSet('availableSeats', 9);
});

it('updates guest list with new entry', function() {
    $guests = setupGuests(1);
    livewire(CreateReservation::class)
        ->set('guestForm.firstName', $guests[0]['firstName'])
        ->set('guestForm.lastName', $guests[0]['lastName'])
        ->set('guestForm.email', $guests[0]['email'])
        ->set('availableSeats', 1)
        ->call('addGuest')
        ->assertSet('form.reservationGuests', [
            [
                'firstName' => $guests[0]['firstName'],
                'lastName' => $guests[0]['lastName'],
                'email' => $guests[0]['email']
            ]
        ]);
});

it('prevents guest list update if table limti is reached', function() {
    $guests = setupGuests(1);
    livewire(CreateReservation::class)
        ->set('guestForm.firstName', $guests[0]['firstName'])
        ->set('guestForm.lastName', $guests[0]['lastName'])
        ->set('guestForm.email', $guests[0]['email'])
        ->set('availableSeats', 1)
        ->set('form.reservationGuests', setupGuests(1))
        ->call('addGuest')
        ->assertHasErrors(['form.reservationGuests' => 'Restaurant can only seat 1 guests at selected time']);
});

it('renders guest list with removed entry', function() {
    $guests = setupGuests(2);
    livewire(CreateReservation::class)
        ->set('availableSeats', 2)
        ->set('form.reservationGuests', $guests)
        ->call('removeGuest', 0)
        ->assertSet('form.reservationGuests', [[
            'firstName' => $guests[1]['firstName'],
            'lastName' => $guests[1]['lastName'],
            'email' => $guests[1]['email']
        ]]);
});

it('prevents form submit when limit is exceeded', function() {
    $restaurantId = setupRestaurantWithTables([1]);

    livewire(CreateReservation::class)
        ->set('form.restaurantId', $restaurantId)
        ->set('form.reservationGuests', setupGuests(2))
        ->call('save')
        ->assertSet('availableSeats', 1)
        ->assertHasErrors(['form.reservationGuests']);
});

it('prevents form submit when no tables are available', function() {
    $restaurant = Restaurant::factory()->create();

    livewire(CreateReservation::class)
        ->set('form.restaurantId', $restaurant->id)
        ->call('save')
        ->assertHasErrors(['form.restaurantId']);
});

it('tests ReservationForm validation rules', function(string $field, mixed $value, string $rule) {
    livewire(CreateReservation::class)
        ->set('form.'.$field, $value)
        ->call('save')
        ->assertHasErrors([$field => $rule]);
})->with([
    'restaurantId is null' => ['restaurantId', null, 'required'],
    'reservationStartTime is null' => ['reservationStartTime', null, 'required'],
    'reservationDuration is null' => ['reservationDuration', null, 'required'],
    'firstName is empty' => ['firstName', '', 'required'],
    'lastName is nuemptyll' => ['lastName', '', 'required'],
    'email is empty' => ['email', '', 'required'],
    'phone is empty' => ['phone', '', 'required'],
    'reservationGuests is null' => ['reservationGuests', null, 'required']
]);

it('allocates optimal tables', function(array $tables, int $guestCount, int $expectedTableCount, array $expectedTableSizes) {
    $restaurantId = setupRestaurantWithTables($tables);

    livewire(CreateReservation::class)
        ->set('form.restaurantId', $restaurantId)
        ->set('form.reservationStartTime', Carbon::now()->addHours(1))
        ->set('form.duration', 1)
        ->set('form.firstName', fake()->firstName)
        ->set('form.lastName', fake()->lastName)
        ->set('form.email', fake()->email)
        ->set('form.phone', fake()->e164PhoneNumber)
        ->set('form.reservationGuests', setupGuests($guestCount))
        ->call('save');

        $assignedTableSizes = Reservation::with('reservationTables.table')
            ->latest()
            ->first()
            ->reservationTables
            ->pluck('table.capacity')
            ->toArray();

        expect(count($assignedTableSizes))
            ->toBe($expectedTableCount);

        expect($assignedTableSizes)
            ->toMatchArray($expectedTableSizes);
})->with([
    [[1, 3, 5, 7, 9], 11, 2, [9, 3]],
    [[2, 3, 5, 7, 9], 10, 2, [9, 2]], 
    [[4, 5, 5, 5, 9], 4, 1, [4]],
    [[4, 5, 6, 6, 7, 7, 9], 20, 3, [9, 7, 4]]
]);


it('skips occupied tables', function() {
    $restaurantId = setupRestaurantWithOccupiedTables([4, 5, 5, 5, 6]);

    livewire(CreateReservation::class)
        ->set('form.restaurantId', $restaurantId)
        ->set('form.reservationStartTime', Carbon::now()->addHours(1))
        ->set('form.duration', 1)
        ->set('form.firstName', fake()->firstName)
        ->set('form.lastName', fake()->lastName)
        ->set('form.email', fake()->email)
        ->set('form.phone', fake()->e164PhoneNumber)
        ->set('form.reservationGuests', setupGuests(5))
        ->call('save');

        $assignedTableSizes = Reservation::with('reservationTables.table')
            ->latest('id')
            ->first()
            ->reservationTables
            ->pluck('table.capacity')
            ->toArray();
        
        expect(count($assignedTableSizes))
            ->toBe(1);

        expect($assignedTableSizes)
            ->toMatchArray([6]);
});

it('saves form with redirect', function () {
    $restaurantId = setupRestaurantWithTables([5]);

    livewire(CreateReservation::class)
        ->set('form.restaurantId', $restaurantId)
        ->set('form.reservationStartTime', Carbon::now()->addHours(1))
        ->set('form.duration', 1)
        ->set('form.firstName', fake()->firstName)
        ->set('form.lastName', fake()->lastName)
        ->set('form.email', fake()->email)
        ->set('form.phone', fake()->e164PhoneNumber)
        ->set('form.reservationGuests', setupGuests(5))
        ->call('save')
        ->assertRedirect(route('reservations.show', ['reservation' => Reservation::latest()->first()]))
        ->assertSessionHas('success', 'Reservation created.');
});

function setupGuests(int $numberOfGuests): array
{
    $guests = [];
    for($i = 0; $i < $numberOfGuests; $i++)
    {
        $guests[] = [
            'firstName' => fake()->firstName,
            'lastName' => fake()->lastName,
            'email' => fake()->email
        ];
    }

    return $guests;
}

function setupRestaurantWithTables(array $tableSizes): int
{
    $restaurant = Restaurant::factory()->create();

    $restaurant->tables()->createMany(array_map(function($key, $value) {
        return [
            'capacity' => $value,
            'table_number' => $key + 1
        ];
    }, array_keys($tableSizes), $tableSizes));

    return $restaurant->id;
}

function setupRestaurantWithOccupiedTables(array $tableSizes): int
{
    $restaurantId = setupRestaurantWithTables($tableSizes);
    $tableIds = Table::where('restaurant_id', $restaurantId)->where('capacity', 5)->pluck('id')->toArray();

    expect(count($tableIds))->toBe(3);

    $reservation = Reservation::factory()->create([
        'restaurant_id' => $restaurantId,
        'reservation_start_time' => Carbon::now()->addHours(1)->format('Y-m-d H:i'),
        'reservation_end_time' => Carbon::now()->addHours(2)->format('Y-m-d H:i')
    ]);

    foreach($tableIds as $tableId)
    {
        ReservationTable::create(
        [
            'reservation_id' => $reservation->id,
            'table_id' => $tableId
        ]);
    }

    return $restaurantId;
}