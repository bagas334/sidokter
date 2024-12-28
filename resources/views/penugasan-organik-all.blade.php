@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('title', 'Semua Penugasan Organik')

@section('content')
<div class="size-full flex flex-col w-full items-center px-4">
    <div class="w-full pb-6 ">
        <x-judul text="Penugasan Organik" />
        <p>Pilih petugas terlebih dahulu.</p>
    </div>

    <div class="w-full flex flex-row justify-between items-center pb-1">
<<<<<<< HEAD
        {{-- Search Input --}}
        <div class="relative flex items-center w-80">
=======
        <div class="relative flex items-center w-64">
>>>>>>> 43d0cb70773b25578ec25a80eeb580df0e03d59c

        </div>
    </div>

    {{-- Tabel--}}
    <div class="flex flex-col justify-center overflow-x-auto max-w-[90vw]">
        <div class="relative min-w-[1200px]">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th scope="col" rowspan="1" class="w-12 text-center">No</th>
                        <th scope="col" rowspan="1" class="w-32">NIP BPS</th>
                        <th scope="col" rowspan="1" class="w-48 text-center">Pelaksana</th>
                        <th scope="col" rowspan="1" class="w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawai as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nip_bps }}</td>
                        <td>{{ $item->nama }}</td>
                        <td class="text-center">
                            <div class="flex justify-center px-2">
<<<<<<< HEAD
                                <x-detail-button-table :id="$item->id" :route="''" />
=======
                                <a class="px-2 py-1 rounded-md border border-gray-500" href="{{route('detail-organik',['id'=>$item->id])}}">Detail</a>
>>>>>>> 43d0cb70773b25578ec25a80eeb580df0e03d59c
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <x-paginator :paginator="$pegawai" />

</div>
@endsection
