<div>
    <div class="w-full flex justify-end">
        <div class="pb-2.5 flex flex-row space-x-1">
            <button
                wire:click="$set('selected_period', 'mom')"
                class="btn-sm w-fit text-sm font-medium {{ $selected_period == 'mom' ? 'bg-teal-600 text-white border-teal-600' : 'text-cyan-950 border-gray-300' }} border rounded-lg focus:outline-none transition-colors duration-300"
                id="bulan-btn">
                Bulan (MoM)
            </button>
            <button
                wire:click="$set('selected_period', 'qoq')"
                class="btn-sm w-fit text-sm font-medium {{ $selected_period == 'qoq' ? 'bg-teal-600 text-white border-teal-600' : 'text-cyan-950 border-gray-300' }} border rounded-lg focus:outline-none transition-colors duration-300"
                id="triwulan-btn">
                Triwulan (QoQ)
            </button>
            <button
                wire:click="$set('selected_period', 'ytd')"
                class="btn-sm w-fit text-sm font-medium {{ $selected_period == 'ytd' ? 'bg-teal-600 text-white border-teal-600' : 'text-cyan-950 border-gray-300' }} border rounded-lg focus:outline-none transition-colors duration-300"
                id="tahun-btn">
                Tahun (YtD)
            </button>
        </div>
    </div>


    <div class="flex flex-row space-x-4">
        <x-stat-card :jumlah="$count_kegiatan">Jumlah kegiatan periode ini</x-stat-card>
        <x-stat-card :jumlah="$average_beban_organik">Rata-rata beban organik</x-stat-card>
        <x-stat-card :jumlah="$count_organik_terlibat">Jumlah organik yang terlibat</x-stat-card>
        <x-stat-card :jumlah="$count_mitra_terlibat">Jumlah mitra yang terlibat</x-stat-card>
    </div>
</div>
