@props(['label' => ''])
<div class="w-full pb-2">
    <p class="text-lg text-cyan-950 font-medium">{{ $label }}</p>
    <p class="text-md text-gray-600 font-normal">{{ $slot }}</p>
</div>
