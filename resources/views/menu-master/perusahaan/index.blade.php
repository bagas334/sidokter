@php
    $seeder_modal_id = 'seeder-modal';
@endphp
@extends('components.layout')

@section('title', 'Master Perusahaan')

@section('content')
    <div class="size-full flex flex-col w-full items-center px-4">
        {{--        Judul--}}
        <div class="w-full pb-6 ">
            <x-judul text="Daftar Perusahaan"/>
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
            <div class="flex space-x-3">
                <x-button.seeder :route="'perusahaan-seeder'" :modal_id="$seeder_modal_id">
                    Seeder
                </x-button.seeder>
                <x-tambah-button :route="'perusahaan-create-view'"/>
            </div>
        </div>


        {{--        Tabel--}}
        <div class="flex flex-col justify-center overflow-x-scroll max-w-[78vw]">
            <div class="relative w-[120vw]">
                <table class="table-custom">
                    <thead>
                    <tr>
                        <th scope="col" rowspan="2" class="w-8 text-center">No</th>
                        <th scope="col" rowspan="2" class="w-8">ID SBR</th>
                        <th scope="col" rowspan="2" class="w-56">Nama Usaha</th>
                        <th scope="col" rowspan="2" class="w-8 text-center">Kode KBLI</th>
                        <th scope="col" rowspan="2" class="w-16">SLS</th>
                        <th scope="colgroup" colspan="3" class="text-center border-b-gray-200 border-b-[1px]">Alamat</th>
                        <th scope="col" rowspan="2" class="w-16 text-center">Email</th>
                        <th scope="colgroup" colspan="2" class="text-center border-b-gray-200 border-b-[1px]">Contact Person</th>
                        <th scope="col" rowspan="2" class="w-16 text-center">Aksi</th>
                    </tr>
                    <tr>
                        <th scope="col" class="w-24 text-center">Kecamatan</th>
                        <th scope="col" class="w-24 text-center">Kelurahan</th>
                        <th scope="col" class="w-48">Detail</th>
                        <th scope="col" class="w-36">Nama</th>
                        <th scope="col" class="w-36 text-center">Telepon</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($perusahaan as $item)
                        <tr class="tr-border-b">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->idsbr }}</td>
                            <td>{{ $item->nama_usaha }}</td>
                            <td class="text-center">{{ $item->kode_kbli }}</td>
                            <td>{{ $item->sls ?: '-' }}</td>
                            <td class="text-center">{{ $item->kecamatan ?: '-' }}</td>
                            <td class="text-center">{{ $item->kelurahan ?: '-' }}</td>
                            <td>{{ $item->alamat_detail ?: '-' }}</td>
                            <td class="text-center">{{ $item->email }}</td>
                            <td>{{ $item->nama_cp }}</td>
                            <td class="text-center">{{ $item->nomor_cp }}</td>
                            <td class="text-center">
                                <div class="flex justify-center space-x-2 px-2">
                                    <x-edit-button-table :id="$item->id" :route="'perusahaan-edit-view'"/>

                                    <form action="{{ route('perusahaan-destroy', $item->id) }}" method="POST" style="display:inline;">
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

        <x-paginator :paginator="$perusahaan"/>
    </div>
    <x-modal.upload-seeder
        :id="$seeder_modal_id"
        :route_template="'template-perusahaan'"
        :route_seeder="'perusahaan-seeder'"
    />
@endsection
