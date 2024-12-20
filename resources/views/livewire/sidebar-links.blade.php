<ul class="menu text-gray-50 min-h-full w-80 p-4 bg-teal-600">
    <x-navigation.link
        route="{{ route('dashboard') }}"
        :active="request()->routeIs('dashboard')"
        text="Dashboard"
    />
    <x-navigation.link
        route="{{ route('kegiatan') }}"
        :active="request()->routeIs('kegiatan')"
        text="Kegiatan"
    />
    <x-navigation.link
        route="{{ route('beban-kerja') }}"
        :active="request()->routeIs('beban-kerja')"
        text="Beban Kerja"
    />
</ul>
