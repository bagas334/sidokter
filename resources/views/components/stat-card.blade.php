@props(['jumlah'])

@php
    $formattedJumlah = number_format($jumlah, 2, '.', '');
    $formattedJumlah = rtrim(rtrim($formattedJumlah, '0'), '.');
@endphp

<div class="card bg-teal-600 w-full shadow-lg rounded-t-sm">
    <div class="card-body py-2 px-4 flex justify-center items-center">
        <p class="card-title text-gray-50 text-sm px-4 py-4">{{ $slot }}</p>
    </div>
    <div>
        <div class="flex justify-center bg-gray-50 h-20 rounded-b-md">
            <p class="text-5xl text-teal-700 font-semibold self-center pb-2">{{ $formattedJumlah }}</p>
        </div>
    </div>
</div>
