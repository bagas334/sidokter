@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('title', 'Manajemen Sampel')

@section('content')
    <div class="size-full flex flex-col w-full items-center px-4 space-y-0.5">
        <div class="w-full">
            <x-judul text="Manajemen Sampel"/>
        </div>
        <div class="grid grid-cols-[5fr_3fr] grid-rows-auto size-full pt-6 gap-4">
            <!-- First row -->
            <div class="row-span-1 max-h-[75vh]">
                <div class="size-full bg-gray-50 shadow-md p-4">
                    <div class="w-full pl-2 pb-6">
                        <span class="text-2xl text-teal-600 font-medium">Peringkat Kegiatan Perusahaan</span>
                    </div>

                    <div class="flex flex-col justify-center overflow-x-auto max-w-[70vw]">
                        <div class="relative">
                            <table class="table-custom">
                                <thead>
                                <tr>
                                    <th scope="col" class="w-8 text-center">Rank</th>
                                    <th scope="col" class="w-56">Nama</th>
                                    <th scope="col" class="w-8 text-center">Kode KBLI</th>
                                    <th scope="col" class="w-8 text-center">Kegiatan</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($ranking as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->rank }}</td>
                                        <td>{{ $item->nama_usaha }}</td>
                                        <td class="text-center">{{ $item->kode_kbli }}</td>
                                        <td class="text-center">{{ $item->jumlah_kegiatan }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-span-1 flex flex-col justify-between max-w-[75vw]">
                <div class="size-full bg-gray-50 shadow-md p-4">
                    <div class="w-full pl-2 pb-6">
                        <span class="text-2xl text-teal-600 font-medium">Empty Space</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="size-full pt-6">
            <div class="size-full bg-gray-50 shadow-md p-4">
                <div class="w-full pl-2 pb-6 flex flex-row justify-between">
                    <span class="text-2xl text-teal-600 font-medium">Daftar Kegiatan dan Sampel</span>
                </div>

                <div class="w-full flex flex-row justify-between items-center pb-1">
                    {{--                    Pencarian--}}
                    <div class="relative flex items-center w-64 ">
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
                </div>

                <div class="flex flex-col justify-center overflow-x-auto max-w-[78vw]">
                    <div class="relative">
                        <table class="table-custom">
                            <thead>
                            <tr>
                                <th scope="col" class="w-8 text-center">No</th>
                                <th scope="col" class="w-56">Nama</th>
                                <th scope="col" class="w-8 text-center">Jumlah Sampel</th>
                                <th scope="col" class="w-8 text-center">Status</th>
                                <th scope="col" class="w-16 text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($kegiatan as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td class="text-center">{{ $item->banyak_sampel }}</td>
                                    <td class="text-center">{{ $item->status_sampel }}</td>
                                    <td class="text-center w-16">
                                        <div class="justify-center">
                                            <x-view-button :id="$item->id" :route="'sampel-show'" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <x-paginator :paginator="$kegiatan"/>
        </div>
    </div>
@endsection
