@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('title', 'Master Kegiatan')

@section('content')
    <div class="size-full flex flex-col w-full items-center px-4">
        {{--        Judul--}}
        <div class="w-full pb-6 ">
            <x-judul text="Daftar Kegiatan"/>
        </div>

        {{--        Pencarian--}}
        <div class="w-full flex flex-row justify-between items-center pb-1">
            {{-- Search Input --}}
            <div class="relative flex items-center w-64">
                <input type="text"
                       class="input pl-10 m-2 ml-0 w-full bg-gray-50 border border-gray-300 rounded-md input-sm focus:outline-none focus:ring-1 focus:ring-teal-600 focus:border-teal-600 peer"
                       placeholder="Cari kegiatan"/>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="absolute left-4 w-5 h-5 text-gray-500 transition duration-200 ease-in-out peer-focus:text-teal-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
            </div>
            <x-tambah-button :route="'master-kegiatan-create-view'"/>
        </div>

        {{--        Tabel--}}
        <div class="flex flex-col justify-center overflow-x-auto max-w-[78vw]">
            <div class="relative min-w-[100vw]">
                <table class="table-custom">
                    <thead>
                    <tr>
                        <th scope="col" rowspan="2" class="w-8 text-center">No</th>
                        <th scope="col" rowspan="2" class="w-56">Nama</th>
                        <th scope="col" rowspan="2" class="w-24">Asal Fungsi</th>
                        <th scope="col" rowspan="2" class="w-20 text-center">Periode</th>
                        <th scope="col" colspan="2" class="text-center border-b-gray-200 border-b-[1px]">Tanggal</th>
                        <th scope="col" rowspan="2" class="w-28 text-end">Target</th>
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
                                @if($item->periode)
                                    {{ $item->periode }}
                                @else
                                    -
                                @endif
                            </td>
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
                            <td class="text-center">{{$item->satuan }}</td>
                            <td class="text-end">{{ $item->harga_satuan }}</td>
                            <td class="text-center">
                                <div class="flex justify-between px-2">
                                    <x-edit-button-table :id="$item->id" :route="'master-kegiatan-edit-view'"/>

                                    <form action="{{ route('master-kegiatan-delete', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <x-remove-button/>
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
        <x-paginator :paginator="$kegiatan"/>

    </div>
@endsection
