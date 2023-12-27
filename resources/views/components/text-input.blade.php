<div class="relative">
    <input 
        x-ref="input-{{ $name }}"
        type="{{ $type }}" 
        placeholder="{{ $placeholder }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}"
        id="{{ $name }}"
        @class([
                'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 focus:ring-2',
                'pr-8' => $formRef,
                'ring-slate-300' => !$errors->has($name),
                'ring-red-300' => $errors->has($name),
            ])>

    @error($name)
        <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
    @enderror
</div>