<x-layout>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-bold">{{ $restaurant->name }}</h2>
        <span class="text-sm">{{ $restaurant->address }}</span>
    </div>

    <div class="mb-4">
        <span class="text-xl">Upcoming reservations:</span>
    </div>

    @forelse ($restaurant->upcomingReservations as $reservation)
        <x-article class="mb-4">
            <div>
                <div>
                    <span>Reserved by: {{ $reservation->contact_first_name }} {{ $reservation->contact_last_name }}</span>
                </div>
                <div>
                    <span>At: {{ \Carbon\Carbon::parse($reservation->reservation_start_time)->settings(['toStringFormat' => 'j F g:i A']) }}</span>
                </div>
                <div>
                    <span>Duration: {{ \Carbon\Carbon::parse($reservation->reservation_end_time)->diffInHours($reservation->reservation_start_time) }} {{ Str::plural('hour', \Carbon\Carbon::parse($reservation->reservation_end_time)->diffInHours($reservation->reservation_start_time)) }}</span>
                </div>
                <div>
                    <span>Tables: {{ $reservation->reservationTables->count() }}</span>
                </div>
            </div>
        </x-article>
    @empty
        <div class="text-center font-medium">
            No upcoming reservations
        </div>
    @endforelse

    <div class="mb-4">
        <span class="text-xl">Past reservations:</span>
    </div>

    @forelse ($restaurant->pastReservations as $reservation)
        <x-article class="mb-4 bg-gray-50">
            <div>
                <div>Reserved by: {{ $reservation->first_name }} {{ $reservation->last_name }}</div>
                <div>At: {{ \Carbon\Carbon::parse($reservation->reservation_start_time)->settings([
                    'toStringFormat' => 'jS F Y g:i A',
                ]) }}</div>
                <div>Duration: {{ \Carbon\Carbon::parse($reservation->reservation_end_time)->diffInHours($reservation->reservation_start_time) }} hours</div>
                <div>Tables: {{ $reservation->reservationTables->count() }}</div>
            </div>
        </x-article>
    @empty
        <div class="text-center font-medium">
            No past reservations
        </div>
    @endforelse
</x-layout>
