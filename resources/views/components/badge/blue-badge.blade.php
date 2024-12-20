@props(['width' => 'fit'])

<div class="w-{{$width}} bg-blue-100 text-blue-600 font-semibold px-4 text-sm py-0.5 rounded-xl text-center">
    {{ $slot }}
</div>
