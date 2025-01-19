@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('title', 'Semua Penugasan')

@section('content')
<div class="size-full flex flex-col w-full px-4">
    <div class="w-full pb-6">
        <x-judul text="Semua Penugasan" />
    </div>

    <div class="flex flex-col space-y-6 items-start ml-0">
        <!-- Buttons Row -->
        <div class="flex justify-between items-center w-full">
            <!-- Filter Button -->
            <button
                id="filterToggleButton"
                class="rounded-md bg-blue-500 text-white px-6 py-1 hover:bg-blue-600 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Filter
            </button>

            <!-- Tambah Button -->
            @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan', 'Ketua Tim']))
            <x-tambah-button :route="'/beban-kerja/add'" />
            @endif
        </div>

        <!-- Form Filter -->
        <form
            id="filterForm"
            action="{{ route('beban-kerja-all') }}"
            method="GET"
            class="flex flex-col space-y-6 w-full max-w-4xl p-6 rounded-lg shadow-lg bg-white hidden mt-4 mb-4">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6">
                <!-- Tanggal Mulai -->
                <x-input.datepicker
                    :name="'tanggal_mulai'"
                    :value="$filterParams['tanggal_mulai'] ?? ''"
                    :label_size="'sm'"
                    :placeholder="'Tanggal mulai'"
                    class="w-full md:w-1/2 p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />

                <!-- Tanggal Akhir -->
                <x-input.datepicker
                    :name="'tanggal_akhir'"
                    :value="$filterParams['tanggal_akhir'] ?? ''"
                    :label_size="'sm'"
                    :placeholder="'Tanggal akhir'"
                    class="w-full md:w-1/2 p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Tombol Filter -->
            <div class="flex space-x-4 mt-6 justify-center md:justify-start">
                <button type="submit" class="rounded-md bg-blue-500 text-white px-6 py-1 hover:bg-blue-600 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Enter
                </button>
                <a href="{{route('beban-kerja-all')}}" id="resetButton" class="rounded-md bg-gray-500 text-white px-6 py-1 hover:bg-gray-600 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Reset
                </a>
            </div>
        </form>

    </div>
</div>

<div class="flex flex-col justify-center overflow-x-auto w-full">
    <div class="relative w-full mt-4">
        @if(auth()->user()->jabatan == 'Organik')
        <table class="table-custom w-full rounded-lg" id="tabel">
            <thead>
                <tr>
                    <th scope="col" rowspan="2" class="w-8 text-center rounded-tl-lg">No</th>
                    <th scope="col" rowspan="2" class="w-56 text-center">Kegiatan</th>
                    <th scope="col" rowspan="2" class="w-24 text-center">Asal Fungsi</th>
                    <th scope="col" colspan="2" class="text-center border-b-gray-200 border-b-[1px]">Tanggal</th>
                    <th scope="col" rowspan="2" class="w-28 text-center">Target</th>
                    <th scope="col" rowspan="2" class="w-28 text-center">Terlaksana</th>
                    <th scope="col" rowspan="2" class="w-28 text-center rounded-tr-lg">Aksi</th>
                </tr>
                <tr>
                    <th scope="col" class="w-28 text-center">Mulai</th>
                    <th scope="col" class="w-28 text-center">Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatan as $item)
                <tr class="{{ $loop->last ? 'border-b-0' : '' }}">
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">
                        {{ $loop->iteration + ($kegiatan->currentPage() - 1) * $kegiatan->perPage() }}
                    </td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">{{ $item->kegiatan->nama }}</td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">{{ $item->kegiatan->asal_fungsi }}</td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">
                        {{ \Carbon\Carbon::parse($item->kegiatan->tanggal_mulai)->format('d-m-Y') }}
                    </td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">
                        {{ \Carbon\Carbon::parse($item->kegiatan->tanggal_akhir)->format('d-m-Y') }}
                    </td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">{{ $item->target }}</td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">{{ $item->terlaksana }}</td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">
                        <div class="flex justify-center space-x-2">
                            <a href="/beban-kerja/{{$item->kegiatan_id}}/tugas-organik/{{auth()->user()->pegawai_id}}" class="mx-1 button bg-blue-500 py-1 px-2 text-white font-medium rounded-md">Tugas anda</a>
                            <a href="/beban-kerja/{{$item->kegiatan_id}}/penugasan" class="mx-1 button bg-blue-500 py-1 px-2 text-white font-medium rounded-md">Detail</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan', 'Ketua Tim']))
        <table class="table-custom w-full rounded-lg">
            <thead>
                <tr>
                    <th scope="col" rowspan="2" class="w-8 text-center rounded-tl-lg">No</th>
                    <th scope="col" rowspan="2" class="w-56 text-center">Nama</th>
                    <th scope="col" rowspan="2" class="w-24 text-center">Asal Fungsi</th>
                    <th scope="col" colspan="2" class="text-center border-b-gray-200 border-b-[1px]">Tanggal</th>
                    <th scope="col" rowspan="2" class="w-28 text-center">Target</th>
                    <th scope="col" rowspan="2" class="w-28 text-center">Terlaksana</th>
                    <th scope="col" rowspan="2" class="w-28 text-center">Satuan</th>
                    <th scope="col" rowspan="2" class="w-28 text-center">Harga Satuan</th>
                    <th scope="col" rowspan="2" class="w-28 text-center rounded-tr-lg">Aksi</th>
                </tr>
                <tr>
                    <th scope="col" class="w-28 text-center">
                        Mulai
                        <a href="{{ route('beban-kerja-all', ['sort' => 'tanggal_mulai', 'order' => 'asc']) }}" class="{{ $sort == 'tanggal_mulai' && $order == 'asc' ? 'text-blue-500' : '' }}">↑</a>
                        <a href="{{ route('beban-kerja-all', ['sort' => 'tanggal_mulai', 'order' => 'desc']) }}" class="{{ $sort == 'tanggal_mulai' && $order == 'desc' ? 'text-blue-500' : '' }}">↓</a>
                    </th>
                    <th scope="col" class="w-28 text-center">
                        Selesai
                        <a href="{{ route('beban-kerja-all', ['sort' => 'tanggal_akhir', 'order' => 'asc']) }}" class="{{ $sort == 'tanggal_akhir' && $order == 'asc' ? 'text-blue-500' : '' }}">↑</a>
                        <a href="{{ route('beban-kerja-all', ['sort' => 'tanggal_akhir', 'order' => 'desc']) }}" class="{{ $sort == 'tanggal_akhir' && $order == 'desc' ? 'text-blue-500' : '' }}">↓</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kegiatan as $item)
                <tr>
                    <td class="text-center {{ $loop->last ? 'rounded-bl-lg' : '' }}">
                        {{$loop->iteration + ($kegiatan->currentPage() - 1) * $kegiatan->perPage() }}
                    </td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">{{ $item->nama }}</td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">{{ $item->asal_fungsi }}</td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">
                        @if($item->tanggal_mulai)
                        {{ Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}
                        @else
                        -
                        @endif
                    </td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">
                        @if($item->tanggal_akhir)
                        {{ Carbon::parse($item->tanggal_akhir)->format('d-m-Y') }}
                        @else
                        -
                        @endif
                    </td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">{{ $item->target }}</td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">{{ $item->terlaksana }}</td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">{{ $item->satuan }}</td>
                    <td class="text-center {{ $loop->last ? 'rounded-b-lg' : '' }}">{{ $item->harga_satuan }}</td>
                    <td class="text-center {{ $loop->last ? 'rounded-br-lg' : '' }}">
                        <div class="flex justify-center space-x-2">
                            <x-detail-button-table :id="$item->id" :route="'beban-kerja-all'" />
                            <form action="{{ route('beban-kerja-delete', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <x-remove-button />
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

{{-- Pagination --}}
<x-paginator :paginator=" $kegiatan" :url="request()->fullUrlWithQuery([])" />

</div>

<script>
    document.getElementById('filterToggleButton').addEventListener('click', function() {
        const filterForm = document.getElementById('filterForm');
        filterForm.classList.toggle('hidden');
    });
</script>

<script>
    const allButton = document.getElementById('allButton');
    const tanggalMulaiInput = document.getElementById('tanggal_mulai');
    const tanggalAkhirInput = document.getElementById('tanggal_akhir');
    const resetButton = document.getElementById('resetButton');

    allButton.addEventListener('click', function() {
        tanggalMulaiInput.value = '';
        tanggalAkhirInput.value = '';
        const url = new URL(window.location.href);
        url.searchParams.delete('tanggal_mulai');
        url.searchParams.delete('tanggal_akhir');
        window.history.pushState({}, '', url);
        location.reload();
        allButton.checked = true;
    });

    resetButton.addEventListener('click', function() {
        tanggalMulaiInput.value = '';
        tanggalAkhirInput.value = '';
        const url = new URL(window.location.href);
        url.searchParams.delete('tanggal_mulai');
        url.searchParams.delete('tanggal_akhir');
        window.history.pushState({}, '', url);
    });

    document.getElementById('pilih').addEventListener('click', function() {
        let selectTanggal = document.getElementById('selectTanggal');
        selectTanggal.style.display = 'flex';
    });

    document.getElementById('all').addEventListener('click', function() {
        let selectTanggal = document.getElementById('selectTanggal');
        selectTanggal.style.display = 'none';
    });

    document.getElementById('bulan').addEventListener('click', function() {
        let selectTanggal = document.getElementById('selectTanggal');
        selectTanggal.style.display = 'none';
    });
</script>
@endsection