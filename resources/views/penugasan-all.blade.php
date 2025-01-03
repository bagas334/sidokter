@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('title', 'Semua Penugasan')

@section('content')
<div class="size-full flex flex-col w-full items-center px-4">
    <div class="w-full pb-6 ">
        <x-judul text="Semua Penugasan" />
    </div>

    <div class="flex flex-col space-y-4 pb-4">

        <!-- Form Filter -->
        <form action="{{ route('beban-kerja-all') }}" method="GET" class="items-center space-x-4">
            <x-input.datepicker
                :name="'tanggal_mulai'"
                :value="$filterParams['tanggal_mulai'] ?? ''"
                :label_size="'sm'"
                :placeholder="'Tanggal mulai'" />

            <x-input.datepicker
                :name="'tanggal_akhir'"
                :value="$filterParams['tanggal_akhir'] ?? ''"
                :label_size="'sm'"
                :placeholder="'Tanggal akhir'" />

            <button type="submit" class="rounded-md bg-blue-500 text-white px-4 py-2 hover:bg-blue-600 transition">
                Filter
            </button>

        </form>
        <a href="{{route('beban-kerja-all')}}" id="resetButton" value="Reset" class="rounded-md bg-gray-500 text-white px-4 py-2 hover:bg-gray-600 transition">Reset</a>
    </div>

    <div class="flex justify-end">
        @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan', 'Ketua Tim']))
        <x-tambah-button :route="'/beban-kerja/add'" />
        @endif
    </div>
</div>

<div class="flex flex-col justify-center overflow-x-auto max-w-[78vw]">
    <div class="relative min-w-[100vw]">
        @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan', 'Ketua Tim']))
        <table class="table-custom">
            <thead>
                <tr>
                    <th scope="col" rowspan="2" class="w-8 text-center">No</th>
                    <th scope="col" rowspan="2" class="w-56">Nama</th>
                    <th scope="col" rowspan="2" class="w-24">Asal Fungsi</th>
                    <th scope="col" colspan="2" class="text-center border-b-gray-200 border-b-[1px]">Tanggal</th>
                    <th scope="col" rowspan="2" class="w-28 text-end">Target</th>
                    <th scope="col" rowspan="2" class="w-28 text-end">Terlaksana</th>
                    <th scope="col" rowspan="2" class="w-28 text-center">Satuan</th>
                    <th scope="col" rowspan="2" class="w-28 text-end">Harga Satuan</th>
                    <th scope="col" rowspan="2" class="w-28 text-center">Aksi</th>
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
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->asal_fungsi }}</td>
                    <td class="text-center">
                        @if($item->tanggal_mulai)
                        {{ Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}
                        @else
                        -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item->tanggal_akhir)
                        {{ Carbon::parse($item->tanggal_akhir)->format('d-m-Y') }}
                        @else
                        -
                        @endif
                    </td>
                    <td class="text-end">{{ $item->target }}</td>
                    <td class="text-end">{{ $item->terlaksana }}</td>
                    <td class="text-center">{{ $item->satuan }}</td>
                    <td class="text-end">{{ $item->harga_satuan }}</td>
                    <td class="text-center">
                        <div class="flex justify-between px-2">
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
<x-paginator :paginator=" $kegiatan" />

</div>

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