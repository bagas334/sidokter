@extends('components.layout')

@section('title', 'Master Organik')

@section('content')
    <div class="container mx-auto px-4 py-6">
        {{-- Judul --}}
        <div class="pb-6">
            <x-judul text="Daftar Organik" />
        </div>

        {{-- Pencarian --}}
        <div class="flex flex-col md:flex-row justify-between items-center pb-4 gap-4">
            {{-- Search Input --}}
            <div class="relative flex items-center w-full md:w-1/2">
                <input type="text"
                       class="input pl-10 w-full bg-gray-50 border border-gray-300 rounded-lg input-sm focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-teal-600"
                       placeholder="Cari kegiatan" />

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor"
                     class="absolute left-4 w-5 h-5 text-gray-500 transition duration-200 ease-in-out peer-focus:text-teal-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <x-tambah-button :route="'master-organik-create-view'" />
        </div>

        {{-- Tabel --}}
        <div class="relative bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <table class="table-auto w-full text-sm text-left">
                <thead class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
                    <tr>
                        <th class="py-3 px-2 text-center w-[5%]">No</th>
                        <th class="py-3 px-2 text-center w-[10%]">NIP</th>
                        <th class="py-3 px-2 text-center w-[10%]">NIP BPS</th>
                        <th class="py-3 px-2 w-[20%]">Nama</th>
                        <th class="py-3 px-2 text-center w-[10%]">Alias</th>
                        <th class="py-3 px-2 w-[20%]">Jabatan</th>
                        <th class="py-3 px-2 text-center w-[8%]">Golongan</th>
                        <th class="py-3 px-2 text-center w-[8%]">Status</th>
                        <th class="py-3 px-2 text-center w-[9%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($pegawai as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-2 text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 px-2 text-center">{{ $item->nip }}</td>
                            <td class="py-3 px-2 text-center">{{ $item->nip_bps }}</td>
                            <td class="py-3 px-2">{{ $item->nama }}</td>
                            <td class="py-3 px-2 text-center">{{ $item->alias }}</td>
                            <td class="py-3 px-2">{{ $item->jabatan }}</td>
                            <td class="py-3 px-2 text-center">{{ $item->golongan }}</td>
                            <td class="py-3 px-2 text-center">{{ $item->status }}</td>
                            <td class="py-3 px-2 text-center">
                                <div class="flex justify-center space-x-2">
                                    <x-edit-button-table :id="$item->id" :route="'master-organik-edit-view'" />
                                    <form action="{{ route('master-organik-delete', $item->id) }}" method="POST">
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

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            <x-paginator :paginator="$pegawai" />
        </div>
    </div>
@endsection
