@props(['label' => '', 'name', 'label_size' => 'lg', 'value' => '', 'placeholder' => 'Pilih Tanggal'])

<div class="w-full pb-2">
    <label for="{{ $name }}" class="text-{{ $label_size }} text-cyan-950 font-medium flex items-center">
        {{ $label }}
        @if($attributes->has('required'))
            <p class="text-red-600 ml-1">*</p>
        @endif
    </label>
    <div class="relative w-full mt-1">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
            </svg>
        </div>
        <input datepicker id="{{ $name }}" name="{{ $name }}" type="text"
               datepicker-format="dd-mm-yyyy"
               datepicker-autohide="true"
               class="text-gray-600 border border-gray-300 text-sm rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 block w-full ps-10 p-2.5"
               value="{{ old($name, $value) }}"
               placeholder="{{ $placeholder }}">
    </div>
</div>
