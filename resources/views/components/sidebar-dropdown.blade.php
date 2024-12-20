@props(['title', 'toggle_id', 'icon'])

<li>
    <button type="button"
            class="flex items-center w-full p-2 text-base text-cyan-950 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
            aria-controls="{{ $toggle_id }}"
            aria-expanded="false"
            onclick="toggleDropdown('{{ $toggle_id }}')">
        @if ($icon)
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
            </svg>
        @endif
        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $title }}</span>
        <svg class="w-3 h-3 transition-transform duration-300 ease-in-out" id="arrow-{{ $toggle_id }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>
    </button>
    <ul id="{{ $toggle_id }}" class="transition-max-height duration-300 ease-in-out max-h-0 overflow-hidden py-0 space-y-0 opacity-0">
        {{ $slot }}
    </ul>
</li>

<script>
    function toggleDropdown(id) {
        const menu = document.getElementById(id);
        const arrow = document.getElementById('arrow-' + id);
        if (menu.classList.contains('max-h-0')) {
            menu.classList.remove('max-h-0', 'opacity-0');
            menu.classList.add('max-h-screen', 'opacity-100');
            arrow.classList.add('rotate-180');
        } else {
            menu.classList.add('max-h-0', 'opacity-0');
            menu.classList.remove('max-h-screen', 'opacity-100');
            arrow.classList.remove('rotate-180');
        }
    }
</script>
