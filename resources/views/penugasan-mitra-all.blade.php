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
    <div class="w-full flex flex-col md:flex-row justify-between items-center pb-4 gap-4">
        <x-search-bar
            :action="route('beban-kerja-mitra')"
            :search="request()->get('search')"
            placeholder="Cari Pengguna"
            formId="search-form-organik"
            inputId="search-input-organik" />
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