@props([
    'route' => '',
    'active' => false,
    'text' => '',
    'icon' => null,
])

@php
    $classes = $active ? 'bg-teal-900 text-white' : 'text-gray-50';
@endphp

<li>
    <a href="{{ $route }}" class="{{ $classes }} flex items-center px-4 py-2 rounded-md">
        @if ($icon)
            <span class="mr-2">
                {{ $icon }}
            </span>
        @endif
        {{ $text }}
    </a>
</li>
