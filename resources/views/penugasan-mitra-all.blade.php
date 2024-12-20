@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('title', 'Semua Penugasan Mitra')

@section('content')
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul--}}
    <div class="w-full pb-6 ">
        <x-judul text="Penugasan Mitra" />
    </div>

    {{-- Pencarian--}}
    <div class="w-full flex flex-row justify-between items-center pb-1">
        {{-- Search Input --}}
        <div class="relative flex items-center w-64">
            <input type="text"
                class="input pl-10 m-2 ml-0 w-full bg-gray-50 border border-gray-300 rounded-md input-sm focus:outline-none focus:ring-1 focus:ring-teal-600 focus:border-teal-600 peer"
                placeholder="Cari kegiatan" />

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="absolute left-4 w-5 h-5 text-gray-500 transition duration-200 ease-in-out peer-focus:text-teal-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </div>
        <x-tambah-button :route="'/beban-kerja/add'" />
    </div>

    {{-- Tabel--}}
    <div class="flex flex-col justify-center overflow-x-auto max-w-[78vw]">
        <div class="relative min-w-[100vw]">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2" class="w-8 text-center">No</th>
                        <th scope="col" rowspan="2" class="w-24">Kegiatan</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Pelaksana</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Target</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Terlaksana</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Satuan</th>
                        <th scope="col" class="w-28 text-center">Mulai</th>
                        <th scope="col" class="w-28 text-center">Selesai</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kegiatan_mitra as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->kegiatan->nama }}</td>
                        <td>{{ $item->mitra->nama }}</td>
                        <td class="text-center">{{ $item->target }}</td>
                        <td class="text-center">{{ $item->terlaksana }}</td>
                        <td class="text-center">{{$item->kegiatan->satuan }}</td>
                        <td class="text-center">{{$item->kegiatan->tanggal_mulai }}</td>
                        <td class="text-center">{{$item->kegiatan->tanggal_akhir }}</td>
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
        </div>
    </div>

    {{-- Pagination --}}
    <x-paginator :paginator="$kegiatan_mitra" />

</div>
@endsection