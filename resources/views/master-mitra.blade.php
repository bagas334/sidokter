@extends('components.layout')

@section('title', 'Master Mitra')

@section('content')
<style>
</style>
<div class="size-full flex flex-col items-center px-4 overflow-x-hidden max-w-screen-md md:max-w-screen-xl">
    {{-- Judul --}}
    <div class="w-full pb-6">
        <x-judul text="Daftar Mitra" />
    </div>

    {{-- Pencarian dan Tombol Tambah --}}
    <div class="w-full flex flex-col md:flex-row justify-between items-center pb-4 gap-4">
        {{-- Search Input Component --}}
        <x-search-bar
            :action="route('master-mitra')"
            :search="request()->get('search')"
            placeholder="Cari Mitra"
            formId="search-mitra-form"
            inputId="search-mitra-input" />


        {{-- Tombol Tambah --}}
        <div class="flex space-x-4 mt-4 sm:mt-0">
            {{-- Tombol Tambah Mitra --}}
            <a href="{{ route('master-mitra-create-view') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-md hover:bg-teal-700">
                Tambah Mitra
            </a>

            {{-- Tombol Tambah File --}}
            <a href="{{ route('master-mitra-tambahfile') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-md hover:bg-teal-700">
                Tambah File
            </a>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="flex flex-col w-full overflow-x-auto">
        <div class="relative">
            <table class="table-custom w-full text-sm border border-gray-200 overflow-hidden rounded-lg">
                <thead class="bg-teal-600 text-white">
                    <tr>
                        <th scope="col" class="text-center p-2 rounded-tl-lg">No</th>
                        <th scope="col" class="text-center p-2">Sobat ID</th>
                        <th scope="col" class="text-center p-2">Nama</th>
                        <th scope="col" class="text-center p-2">Jenis Kelamin</th>
                        <th scope="col" class="text-center p-2">Kecamatan</th>
                        <th scope="col" class="text-center p-2">Kelurahan</th>
                        <th scope="col" class="text-center p-2">Detail Alamat</th>
                        <th scope="col" class="text-center p-2">Email</th>
                        <th scope="col" class="text-center p-2">Posisi</th>
                        <th scope="col" class="text-center p-2">Fungsi</th>
                        <th scope="col" class="text-center p-2">Pendapatan</th>
                        <th scope="col" class="text-center p-2 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($mitra->count() > 0)
                    @foreach ($mitra as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="text-center p-2 rounded-bl-lg">{{ $loop->iteration + ($mitra->currentPage() - 1) * $mitra->perPage() }}</td>
                        <td class="text-center p-2">{{ $item->sobat_id }}</td>
                        <td class="text-center p-2">{{ $item->nama }}</td>
                        <td class="text-center p-2">{{ $item->jenis_kelamin }}</td>
                        <td class="text-center p-2">{{ $item->kecamatan ?: '-' }}</td>
                        <td class="text-center p-2">{{ $item->kelurahan ?: '-' }}</td>
                        <td class="p-2">{{ $item->alamat_detail ?: '-' }}</td>
                        <td class="text-center p-2">{{ $item->email }}</td>
                        <td class="text-center p-2">{{ str_replace(',', ' dan ', $item->posisi) }}</td>
                        <td class="text-center p-2">{{ $item->fungsi }}</td>
                        <td class="text-center p-2">{{ $item->pendapatan }}</td>
                        <td class="text-center p-2 rounded-br-lg">
                            <div class="flex justify-center space-x-2">
                                <x-edit-button-table :id="$item->id" :route="'master-mitra-edit-view'" />
                                <form action="{{ route('master-mitra-delete', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-remove-button />
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="12" class="text-center text-gray-500 p-4">
                            Tidak ada data yang sesuai dengan pencarian "{{ request()->get('search') }}".
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <x-paginator :paginator="$mitra" :url="request()->fullUrlWithQuery(['search' => request()->get('search'), 'page' => $mitra->currentPage()])" />
</div>
@endsection