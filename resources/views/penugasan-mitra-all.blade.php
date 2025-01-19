@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('title', 'Semua Penugasan Mitra')

@section('content')
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul --}}
    <div class="w-full pb-6">
        <x-judul text="Penugasan Mitra" />
    </div>

    {{-- Pencarian --}}
    <div class="w-full flex flex-row justify-between items-center pb-1">
        <div class="relative flex items-center w-64">
            <input type="text" class="input pl-10 m-2 ml-0 w-full bg-gray-50 border border-gray-300 rounded-md input-sm focus:outline-none focus:ring-1 focus:ring-teal-600 focus:border-teal-600 peer" placeholder="Cari Kegiatan" />

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute left-4 w-5 h-5 text-gray-500 transition duration-200 ease-in-out peer-focus:text-teal-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21L15.803 15.803M15.803 15.803A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z" />
            </svg>
        </div>
    </div>


    {{-- Tabel --}}
    <div class="flex flex-col justify-center overflow-x-auto w-full">
        <div class="relative w-full">
            <table class="table-custom w-full rounded-lg border-collapse border-none">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2" class="w-8 text-center rounded-tl-lg">No</th>
                        <th scope="col" rowspan="2" class="w-24 text-center">Kegiatan</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Pelaksana</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Target</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Terlaksana</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Satuan</th>
                        <th scope="col" class="w-28 text-center">Mulai</th>
                        <th scope="col" class="w-28 text-center rounded-tr-lg">Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kegiatan_mitra as $item)
                    <tr>
                        <td class="text-center {{ $loop->last ? 'rounded-bl-lg' : '' }}" style="border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #e5e7eb;">
                            {{ $loop->iteration + ($kegiatan_mitra->currentPage() - 1) * $kegiatan_mitra->perPage() }}
                        </td>
                        <td class="text-center" style="border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #e5e7eb;">
                            {{ $item->kegiatan->nama }}
                        </td>
                        <td class="text-center" style="border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #e5e7eb;">
                            {{ $item->mitra->nama }}
                        </td>
                        <td class="text-center" style="border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #e5e7eb;">
                            {{ $item->target }}
                        </td>
                        <td class="text-center" style="border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #e5e7eb;">
                            {{ $item->terlaksana }}
                        </td>
                        <td class="text-center" style="border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #e5e7eb;">
                            {{ $item->kegiatan->satuan }}
                        </td>
                        <td class="text-center" style="border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #e5e7eb;">
                            {{ $item->kegiatan->tanggal_mulai }}
                        </td>
                        <td class="text-center {{ $loop->last ? 'rounded-br-lg' : '' }}" style="border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #e5e7eb;">
                            {{ $item->kegiatan->tanggal_akhir }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <x-paginator :paginator="$kegiatan_mitra" :url="request()->fullUrlWithQuery([])" />
</div>
@endsection