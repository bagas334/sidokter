<div>
    <div class="size-full flex flex-col">
        <x-judul text="Selamat datang!"/>
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

    </div>

    <div class="grid grid-cols-[5fr_3fr] grid-rows-auto size-full pt-6 gap-4">
        <!-- First row -->
        <div class="row-span-1 max-h-[70vh]">
            <div class="size-full bg-gray-50 shadow-md p-4">
                <div class="w-full pl-2 pb-6">
                    <span class="text-2xl text-teal-600 font-medium">Daftar Tugas Terkini</span>
                </div>
                <div class="flex justify-end px-2">
                    //Chip here
                </div>
                <div class="my-2 flex flex-col justify-center overflow-auto max-w-[50vw] px-2">
                    <div class="relative max-h-96">
                        <table class="table-custom">
                            <thead>
                            <tr>
                                <th scope="col" class="w-56">Tugas</th>
                                <th scope="col" class="w-24">Pemberi Tugas</th>
                                <th scope="col" class="w-8 text-center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--                        @foreach ($kegiatan_user as $item)--}}
                            {{--                            <tr class="clickable-row hover:bg-teal-50 cursor-pointer" data-url="{{ route('penugasan-organik-detail', $item->id) }}">--}}
                            {{--                                <td>{{  $item->nama_tugas }}</td>--}}
                            {{--                                <td>{{ $item->nama_pemberi_tugas }}</td>--}}
                            {{--                                @switch($item->status)--}}
                            {{--                                    @case('ditugaskan')--}}
                            {{--                                        <td class="flex justify-center items-center">--}}
                            {{--                                            <x-badge.blue-badge :width="'28'">{{ $item->status }}</x-badge.blue-badge>--}}
                            {{--                                        </td>--}}
                            {{--                                        @break--}}
                            {{--                                    @case('proses')--}}
                            {{--                                        <td class="flex justify-center items-center">--}}
                            {{--                                            <x-badge.yellow-badge :width="'28'">{{ $item->status }}</x-badge.yellow-badge>--}}
                            {{--                                        </td>--}}
                            {{--                                        @break--}}
                            {{--                                    @case('selesai')--}}
                            {{--                                        <td class="flex justify-center items-center">--}}
                            {{--                                            <x-badge.green-badge :width="'28'">{{ $item->status }}</x-badge.green-badge>--}}
                            {{--                                        </td>--}}
                            {{--                                        @break--}}
                            {{--                                    @default--}}
                            {{--                                        <td class="flex justify-center items-center">--}}
                            {{--                                            <x-badge.gray-badge :width="'28'">#not_found</x-badge.gray-badge>--}}
                            {{--                                        </td>--}}
                            {{--                                @endswitch--}}
                            {{--                            </tr>--}}
                            {{--                        @endforeach--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-span-1 max-h-[70vh]">
            {{--        <x-column-card :judul="'Kegiatan Setiap Organik'" :labels="$kegiatan_organik_labels" :value="$kegiatan_organik_value"/>--}}
        </div>

        <!-- Second row -->
        <div class="row-span-1 max-h-[70vh]">
            <x-line-card :judul="'Kegiatan Setiap Periode'" :labels="$label_linechart_kegiatan" :value="$value_linechart_kegiatan"/>
        </div>
        <div class="row-span-1 max-h-[70vh]">
            {{--        <x-doughnut-card :judul="'Kegiatan Setiap Fungsi'" :labels="$kegiatan_fungsi_labels" :value="$kegiatan_fungsi_value"/>--}}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.clickable-row');
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    const url = row.getAttribute('data-url');
                    if (url) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
</div>
