@extends('components.layout')

@section('title', 'Master Mitra')

@section('content')
<div class="flex flex-col items-center px-6 py-8 bg-gray-50">
    <div class="w-full max-w-screen-md mx-auto">
        {{-- Judul --}}
        <div class="w-full pb-6">
            <x-judul text="Daftar Mitra" />
        </div>

        {{-- Pencarian --}}
        <div class="w-full flex flex-col sm:flex-row justify-between items-center pb-4">
            {{-- Form Search --}}
            <form action="{{ route('master-mitra') }}" method="GET" class="relative flex items-center w-full sm:w-96">
                <input type="text"
                    name="search"
                    class="input pl-10 w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-teal-600"
                    placeholder="Cari berdasarkan Sobat ID atau Nama..."
                    value="{{ request('search') }}" />

                <button type="submit" class="absolute right-2 bg-teal-600 text-white px-3 py-1 rounded-md hover:bg-teal-700 focus:outline-none">
                    Cari
                </button>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="absolute left-4 w-5 h-5 text-gray-500 transition duration-200 ease-in-out peer-focus:text-teal-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </form>

            {{-- Tombol Tambah --}}
            <div class="flex space-x-4 mt-4 sm:mt-0">
                {{-- Tombol Tambah Mitra --}}
                <a href="{{ route('master-mitra-create-view') }}" class="bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700">
                    Tambah Mitra
                </a>

                {{-- Tombol Tambah File --}}
                <a href="{{ route('master-mitra-tambahfile') }}" class="bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700">
                    Tambah File
                </a>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="w-full bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="table-auto w-full border-collapse">
                <thead class="bg-teal-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-center">No</th>
                        <th class="px-4 py-2 text-center">Sobat ID</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2 text-center">Jenis Kelamin</th>
                        <th class="px-4 py-2 text-center">Kecamatan</th>
                        <th class="px-4 py-2 text-center">Kelurahan</th>
                        <th class="px-4 py-2">Detail Alamat</th>
                        <th class="px-4 py-2 text-center">Email</th>
                        <th class="px-4 py-2 text-center">Posisi</th>
                        <th class="px-4 py-2 text-center">Fungsi</th>
                        <th class="px-4 py-2 text-center">Pendapatan</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($mitra as $item)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2 text-center">{{ $loop->iteration + ($mitra->currentPage() - 1) * $mitra->perPage() }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->sobat_id }}</td>
                        <td class="px-4 py-2">{{ $item->nama }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->jenis_kelamin }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->kecamatan ?: '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->kelurahan ?: '-' }}</td>
                        <td class="px-4 py-2">{{ $item->alamat_detail ?: '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->email }}</td>
                        <td class="px-4 py-2 text-center">{{ str_replace(',', ' dan ', $item->posisi) }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->fungsi }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->pendapatan }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('master-mitra-edit-view', $item->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('master-mitra-delete', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="px-4 py-2 text-center text-gray-500">Data tidak ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination dan Informasi Data --}}
        <div class="w-full flex justify-between items-center mt-4">
            {{-- Informasi jumlah data --}}
            <div class="text-gray-500 text-sm">
                Menampilkan {{ $mitra->firstItem() }} - {{ $mitra->lastItem() }} dari total {{ $mitra->total() }} data
            </div>

            {{-- Tombol Pagination --}}
            <div class="flex justify-end space-x-2">
                @if ($mitra->onFirstPage())
                <span class="bg-gray-300 text-gray-600 px-4 py-2 rounded-md cursor-not-allowed">Prev</span>
                @else
                <a href="{{ $mitra->previousPageUrl() }}" class="bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700">
                    Prev
                </a>
                @endif

                @if ($mitra->hasMorePages())
                <a href="{{ $mitra->nextPageUrl() }}" class="bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700">
                    Next
                </a>
                @else
                <span class="bg-gray-300 text-gray-600 px-4 py-2 rounded-md cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection