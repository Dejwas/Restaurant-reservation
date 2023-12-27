<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 month', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate->format('Y-m-d H:i:s').'+1 hour', $startDate->format('Y-m-d H:i:s').'+3 hours');
        return [
            'contact_first_name' => fake()->firstName,
            'contact_last_name' => fake()->lastName,
            'contact_email' => fake()->email,
            'contact_phone' => fake()->phoneNumber,
            'reservation_start_time' => $startDate,
            'reservation_end_time' => $endDate,
        ];
    }
}
