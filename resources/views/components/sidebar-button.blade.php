@props(['title', 'icon', 'href', 'class'])

<li>
    <a href="{{ $href ?? '#' }}" class="flex items-center p-2 text-cyan-950 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $class ?? '' }}">
        @if ($icon)
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
            </svg>
        @endif
        <span class="ms-3">{{ $title }}</span>
    </a>
</li>
