{{--@php dd($mitra) @endphp--}}
@extends('components.layout')

@section('title', 'Master Mitra')

@section('content')
    <div class="size-full flex flex-col w-full items-center px-4">
        {{--        Judul--}}
        <div class="w-full pb-6 ">
            <x-judul text="Daftar Mitra"/>
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
            <x-tambah-button :route="'master-mitra-create-view'"/>
        </div>


        {{--        Tabel--}}
        <div class="flex flex-col justify-center overflow-x-scroll max-w-[78vw]">
            <div class="relative w-[120vw]">
                <table class="table-custom">
                    <thead>
                    <tr>
                        <th scope="col" rowspan="2" class="w-8 text-center">No</th>
                        <th scope="col" rowspan="2" class="w-12 text-center">Sobat ID</th>
                        <th scope="col" rowspan="2" class="w-56">Nama</th>
                        <th scope="col" rowspan="2" class="w-24 text-center">Jenis Kelamin</th>
                        <th scope="col" colspan="3" class="text-center border-b-gray-200 border-b-[1px]">Alamat</th>
                        <th scope="col" rowspan="2" class="w-16 text-center">Email</th>
                        <th scope="col" rowspan="2" class="w-44 text-center">Posisi</th>
                        <th scope="col" rowspan="2" class="w-32 text-center">Fungsi</th>
                        <th scope="col" rowspan="2" class="w-16 text-center">Aksi</th>
                    </tr>
                    <tr>
                        <th scope="col" class="w-24 text-center">Kecamatan</th>
                        <th scope="col" class="w-24 text-center">Kelurahan</th>
                        <th scope="col" class="w-48">Detail</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($mitra as $item)
                        <tr class="tr-border-b">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $item->sobat_id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td class="text-center">{{ $item->jenis_kelamin }}</td>
                            <td class="text-center">{{ $item->kecamatan ?: '-' }}</td>
                            <td class="text-center">{{ $item->kelurahan ?: '-' }}</td>
                            <td>{{ $item->alamat_detail ?: '-' }}</td>
                            <td class="text-center">{{ $item->email }}</td>
                            <td class="text-center">{{ str_replace(',', ' dan ', $item->posisi) }}</td>
                            <td class="text-center">{{ $item->fungsi }}</td>
                            <td class="text-center">
                                <div class="flex justify-center space-x-2 px-2">
                                    <x-edit-button-table :id="$item->id" :route="'master-mitra-edit-view'"/>

                                    <form action="{{ route('master-mitra-delete', $item->id) }}" method="POST" style="display:inline;">
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

        <x-paginator :paginator="$mitra"/>

    </div>
@endsection
