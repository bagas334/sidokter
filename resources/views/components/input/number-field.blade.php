@props(['label' => '', 'name', 'label_size' => 'lg', 'value' => ''])

<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
appearance: none;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>

<div class="w-full pb-2">
    <label for="{{ $name }}" class="text-{{ $label_size }} text-cyan-950 font-medium flex items-center">
        {{ $label }}
        @if($attributes->has('required'))
            <p class="text-red-600 ml-1">*</p>
        @endif
    </label>
    <input type="number" id="{{ $name }}" name="{{ $name }}"
              value="{{ old($name, $value) }}"
           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
</div>

