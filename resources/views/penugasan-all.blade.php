@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('title', 'Semua Penugasan')

@section('content')
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul--}}
    <div class="w-full pb-6 ">
        <x-judul text="Semua Penugasan" />
    </div>

    {{-- Pencarian--}}
    <div class="w-full flex flex-row justify-between items-center pb-1">
        {{-- Search Input --}}
        <div class="relative flex items-center w-128">
            <x-input.datepicker
                :name="'tanggal_mulai'"
                :label_size="'md'">
            </x-input.datepicker>
            <x-input.datepicker
                :name="'tanggal_akhir'"
                :label_size="'md'">
            </x-input.datepicker>
        </div>
        @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan', 'Ketua Tim']))
        <x-tambah-button :route="'/beban-kerja/add'" />
        @endif

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
                        <th scope="col" class="w-28 text-center">Mulai</th>
                        <th scope="col" class="w-28 text-center">Selesai</th>
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
                        <td class="text-center">{{$item->satuan }}</td>
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
            @if(auth()->user()->jabatan == 'Organik')
            <table class="table-custom">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2" class="w-8 text-center">No</th>
                        <th scope="col" rowspan="2" class="w-56">Nama Kegiatan</th>
                        <th scope="col" rowspan="2" class="w-24">Asal Fungsi</th>
                        <th scope="col" rowspan="2" class="w-24">Deadline</th>
                        <th scope="col" rowspan="2" class="w-28 text-end">Target</th>
                        <th scope="col" rowspan="2" class="w-28 text-end">Terlaksana</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Satuan</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kegiatan as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->kegiatan->nama }}</td>
                        <td>{{ $item->kegiatan->asal_fungsi }}</td>
                        <td class="text-center">
                            @if($item->kegiatan->tanggal_akhir)
                            {{ Carbon::parse($item->kegiatan->tanggal_akhir)->format('d-m-Y') }}
                            @else
                            -
                            @endif
                        </td>

                        <td class="text-end">{{ $item->target }}</td>
                        <td class="text-end">{{ $item->terlaksana }}</td>
                        <td class="text-center">{{ $item->kegiatan->satuan }}</td>
                        <td class="text-center">
                            <div class="flex justify-between px-2">
                                <a class="button border border-gray-500 rounded-md p-1" href="{{ route('penugasan-organik-detail', ['id' => $item->kegiatan->id, 'petugas' => auth()->user()->id]) }}">Coba</a>

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
@endsection