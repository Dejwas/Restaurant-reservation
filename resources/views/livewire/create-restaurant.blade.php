<div>
    <form wire:submit="save">
        @csrf

        <div class="mb-8">
            <div>
                <x-label for="form.name" :required="true">Name</x-label>
                <input wire:model.live="form.name" class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" />
                @error('form.name')
                    <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-8">
            <div>
                <x-label for="form.address" :required="true">Address</x-label>
                <input wire:model.live="form.address" class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" />
                @error('form.address')
                    <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-8">
            <div>
                <x-label for="form.tables" :required="true">Tables</x-label>
                <input wire:model.live="form.tables" class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" type="number" min="1" max="100" />
                @error('form.tables')
                    <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-8">
            <div>
                <x-label for="defaultTableSeats" :required="true">Default Table Seats</x-label>
                <input wire:model.live="defaultTableSeats" class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" type="number" min="1" max="100" value="{{ $defaultTableSeats }}" />
                @error('defaultTableSeats')
                    <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-8">
            @foreach ($form->tableInfo as $key => $seats)
                <div class="flex mb-2">
                    <div class="px-2">Table {{ $key + 1 }} seats: </div>
                    <input 
                        wire:model="form.tableInfo.{{ $key }}" 
                        class="rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2" 
                        type="number" 
                        min="1" 
                        max="100" 
                        value="{{ $seats }}" />
                </div>
            @endforeach
            @error('form.tableInfo')
                <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-span-2">
            <x-button class="w-full">Create</x-button>
        </div>
    </form>
</div>