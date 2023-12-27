<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Reservation
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReservationGuest> $reservationGuests
 * @property-read int|null $reservation_guests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReservationTable> $reservationTables
 * @property-read int|null $reservation_tables_count
 * @property-read \App\Models\Restaurant|null $restaurant
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation query()
 */
	class Reservation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReservationGuest
 *
 * @property-read \App\Models\Reservation|null $reservation
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationGuest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationGuest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationGuest query()
 */
	class ReservationGuest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReservationTable
 *
 * @property-read \App\Models\Reservation|null $reservation
 * @property-read \App\Models\Table|null $table
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationTable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationTable query()
 */
	class ReservationTable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Restaurant
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation> $pastReservations
 * @property-read int|null $past_reservations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation> $reservations
 * @property-read int|null $reservations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Table> $tables
 * @property-read int|null $tables_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation> $upcomingReservations
 * @property-read int|null $upcoming_reservations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant query()
 */
	class Restaurant extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Table
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReservationTable> $reservation_table
 * @property-read int|null $reservation_table_count
 * @property-read \App\Models\Restaurant|null $restaurant
 * @method static \Illuminate\Database\Eloquent\Builder|Table availableTables(int $restaurant_id, \DateTime $reservation_start_time, \DateTime $reservation_end_time)
 * @method static \Illuminate\Database\Eloquent\Builder|Table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table query()
 * @method static \Illuminate\Database\Eloquent\Builder|Table restaurantFilter(int $restaurant_id)
 */
	class Table extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property mixed $password
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 */
	class User extends \Eloquent {}
}

