<div {{ $attributes->class(['rounded-md border border-slate-300 bg-white p-4 shadow-sm grid grid-cols-2 gap-4']) }}>
    <div class="mb-4">
        <div class="text-lg font-medium">{{ $restaurant->name }}</div>
        <div>{{ $restaurant->address }}</div>
    </div>

    {{ $slot }}
</div>