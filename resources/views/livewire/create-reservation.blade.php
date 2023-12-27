<div>
    <form wire:submit="save">
        @csrf
        <div class="mb-8">
            <x-label for="form.restaurantId" :required="true">Restaurant</x-label>
            <select wire:model.live="form.restaurantId" data-dependent="state" class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2">
                <option value=""></option>
                @foreach($restaurants as $restaurant)
                    <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                @endforeach
            </select>
            @error('form.restaurantId')
                <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-8">
            <div class="grid grid-cols-2 gap-2 justify-between">
                <div>
                    <x-label for="form.reservationStartTime" :required="true">Choose a time for reservation</x-label>
                    <input
                        wire:model.live="form.reservationStartTime"
                        class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2"
                        type="datetime-local"
                        min="{{ Carbon\Carbon::now()->format('Y-m-d H:i') }}"
                        max="{{ Carbon\Carbon::now()->addMonths(1)->format('Y-m-d H:i') }}" />
                </div>
                <div>
                    <x-label for="form.reservationDuration" :required="true">Choose visit duration (in hours)</x-label>
                    <input 
                        wire:model.live="form.reservationDuration" 
                        class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" 
                        type="number" 
                        min="1" 
                        max="5"
                    />
                    @error('form.reservationDuration')
                        <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        @if($availableSeats > 0)
            <div class="text-xl mb-4">
                <span class="text-xl" for="form.reservationGuests">Contact information</span>
            </div>
            <div class="mb-8">
                <div class="grid grid-cols-2 gap-2 justify-between">
                    <div>
                        <x-label for="form.firstName" :required="true">First Name</x-label>
                        <input class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" wire:model.live="form.firstName"/>
                        @error('form.firstName')
                            <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-label for="form.lastName" :required="true">Last Name</x-label>
                        <input class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" wire:model="form.lastName" />
                        @error('form.lastName')
                            <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <div class="grid grid-cols-2 gap-2 justify-between">
                    <div>
                        <x-label for="form.email" :required="true">Email</x-label>
                        <input class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" wire:model="form.email" type="email" />
                        @error('form.email')
                            <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-label for="form.phone" :required="true">Phone</x-label>
                        <input class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" wire:model="form.phone" type="phone" />
                        @error('form.phone')
                            <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <div class="text-xl mb-4">
                    <span class="text-xl" for="form.reservationGuests">Guest list</span>
                </div>
                <div class="mb-8 grid grid-cols-4 gap-2 justify-between">
                    <div>
                        <x-label :required="true">First Name</x-label>
                        <input wire:model="guestForm.firstName" class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" />
                        @error('guestForm.firstName')
                            <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-label :required="true">Last Name</x-label>
                        <input wire:model="guestForm.lastName"class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" />
                        @error('guestForm.lastName')
                            <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-label :required="true">Email</x-label>
                        <input wire:model="guestForm.email" class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" />
                        @error('guestForm.email')
                            <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Not inline, should be fixed --}}
                    <div class="relative">
                        <x-button type="button" class="w-full absolute top-6 right-0" wire:click="addGuest">Add</x-button>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                @forelse ($form->reservationGuests as $key => $guest)
                    <div class="flex justify-between">
                        <span>{{ $guest['firstName'] }} {{ $guest['lastName'] }} {{ $guest['email'] }}</span>
                        <x-button type="button" wire:click="removeGuest({{$key}})">Remove</x-button>
                    </div>
                @empty
                    No guests added
                @endforelse
                @error('form.reservationGuests')
                    <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-span-2">
                <x-button class="w-full">Create</x-button>
            </div>
        @endif
    </form>
</div>