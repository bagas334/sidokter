@props(['label', 'name'])

<div class="w-full pb-2">
    <label for="{{ $name }}" class="text-lg text-cyan-950 font-medium flex items-center">
        {{ $label }}
        @if($attributes->has('required'))
            <p class="text-red-600 ml-1">*</p>
        @endif
    </label>
    <div class="w-full grid grid-cols-[5fr_5fr] gap-3">
        {{ $slot }}
    </div>
</div>
