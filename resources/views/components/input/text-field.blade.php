@props(['label', 'name', 'value' => '', 'label_size' => 'lg'])

<div class="w-full pb-2">
    <label for="{{ $name }}" class="text-{{ $label_size }} text-cyan-950 font-medium flex items-center">
        {{ $label }}
        @if($attributes->has('required'))
            <p class="text-red-600 ml-1">*</p>
        @endif
    </label>
    <input type="text" id="{{ $name }}" name="{{ $name }}"
           value="{{ old($name, $value) }}"
           @if($attributes->has('disabled'))
               disabled class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed"
           @else
               class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
           @endif
    >
</div>
