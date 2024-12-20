@props(['label' => '', 'name', 'label_size' => 'lg', 'value' => ''])

<div class="w-full pb-2">
    <label for="{{ $name }}" class="text-{{ $label_size }} text-cyan-950 font-medium flex items-center">
        {{ $label }}
        @if($attributes->has('required'))
            <p class="text-red-600 ml-1">*</p>
        @endif
    </label>
    <textarea id="{{ $name }}" name="{{ $name }}" rows="4"
              class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm resize-none overflow-auto">{{$value}}</textarea>
</div>
