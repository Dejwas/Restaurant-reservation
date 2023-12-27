<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\Restaurant::factory(50)->create();

        $restaurants = \App\Models\Restaurant::all();

        foreach($restaurants as $restaurant) {
            $number = rand(2, 10);
            for($i = 0; $i < $number; $i++){
                \App\Models\Table::factory()->create([
                    'restaurant_id' => $restaurant->id,
                    'table_number' => $i + 1
                ]);
            }
        }

        for($i = 0; $i < 100; $i++) {
            $restaurant_id = $restaurants->random()->id;
            $reservation = \App\Models\Reservation::factory()->create([
                'restaurant_id' => $restaurant_id
            ]);

            $number = rand(1, 2);
            $tables = \App\Models\Table::restaurantFilter($restaurant_id)->get()->shuffle();
            for($j = 0; $j < $number; $j++){
                \App\Models\ReservationTable::factory()->create([
                    'reservation_id' => $reservation->id,
                    'table_id' => $tables->pop()->id
                ]);
            }
        }
    }
}
