@props(['label' => '', 'options', 'name', 'label_size' => 'lg', 'selected' => ''])

<div class="w-full pb-2">
    <label for="{{ $name }}" class="text-{{ $label_size }} text-cyan-950 font-medium flex items-center">
        {{ $label }}
        @if($attributes->has('required'))
        <p class="text-red-600 ml-1">*</p>
        @endif
    </label>
    <select id="{{ $name }}" name="{{ $name }}"
        @if($attributes->has('disabled'))
        disabled
        class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed">
        @else
        class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
        @endif
        <option value="">-- Pilih Opsi --</option>
        @foreach ($options as $option)
        <option value="{{ $option->id }}" {{ $selected == $option->nama ? 'selected' : '' }}>
            {{ $option->id.' '.$option->nama.' ('.$option->pendapatan.')' }}
        </option>
        @endforeach
    </select>
</div>