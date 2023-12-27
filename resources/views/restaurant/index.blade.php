<x-layout>
    <div class="mb-4 flex justify-end">
        <a class="font-semibold text-black" href="{{ route('restaurants.create') }}">
            <x-button class="text-xl">Create Restaurant</x-button>
        </a>
    </div>

    @foreach ($restaurants as $restaurant)
        <x-restaurant-display class="mb-4" :restaurant="$restaurant">
            <div class="flex justify-end text-center">
                <a class="px-2.5 py-1.5 font-semibold text-black" href="{{ route('restaurants.show', $restaurant) }}">
                    <x-button>Reservations</x-button>
                </a>
            </div>
        </x-restaurant-display>
    @endforeach

</x-layout>
