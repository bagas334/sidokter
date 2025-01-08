@extends('components.layout')

@section('title', 'Semua Perusahaan')

@section('content')
<div class="size-full flex flex-col w-full items-center px-4">
    <div class="w-full max-w-screen-lg mx-auto">
        {{-- Judul --}}
        <div class="w-full pb-6 text-center">
            <x-judul text="Semua Perusahaan" />
        </div>

        {{-- Pencarian --}}
        <div class="w-full flex flex-col sm:flex-row justify-between items-center pb-4">
            <form action="{{ route('perusahaan.index') }}" method="GET" class="relative flex items-center w-full sm:w-96">
                <input type="text"
                    name="search"
                    class="input pl-10 w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-teal-600"
                    placeholder="Cari berdasarkan Nama atau Alamat..."
                    value="{{ request('search') }}" />
                <button type="submit" class="absolute right-2 bg-teal-600 text-white px-3 py-1 rounded-md hover:bg-teal-700 focus:outline-none">
                    Cari
                </button>
            </form>

            {{-- Tombol Tambah --}}
            <div class="flex space-x-4 mt-4 sm:mt-0">
                <a href="{{ route('perusahaan.create') }}" class="bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700">
                    Tambah Perusahaan
                </a>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="w-full bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="table-auto w-full border-collapse">
                <thead class="bg-teal-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-center">No</th>
                        <th class="px-4 py-2 text-center">ID SBR</th>
                        <th class="px-4 py-2 text-center">Kode Wilayah</th>
                        <th class="px-4 py-2">Nama Usaha</th>
                        <th class="px-4 py-2 text-center">SLS</th>
                        <th class="px-4 py-2">Alamat Detail</th>
                        <th class="px-4 py-2 text-center">Kode KBLI</th>
                        <th class="px-4 py-2">Nama CP</th>
                        <th class="px-4 py-2 text-center">Nomor CP</th>
                        <th class="px-4 py-2 text-center">Email</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($perusahaan as $item)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2 text-center">{{ $loop->iteration + ($perusahaan->currentPage() - 1) * $perusahaan->perPage() }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->idsbr }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->kode_wilayah }}</td>
                        <td class="px-4 py-2">{{ $item->nama_usaha }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->sls }}</td>
                        <td class="px-4 py-2">{{ $item->alamat_detail }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->kode_kbli }}</td>
                        <td class="px-4 py-2">{{ $item->nama_cp }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->nomor_cp }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->email }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('perusahaan.edit', $item->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">
                                    Edit
                                </a>
                                <form action="{{ route('perusahaan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perusahaan ini?');">
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
                        <td colspan="11" class="px-4 py-2 text-center text-gray-500">Data tidak ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination dan Tombol Navigasi --}}
        <div class="w-full flex justify-between items-center mt-4">
            {{-- Informasi jumlah data --}}
            <div class="text-gray-500 text-sm">
                Menampilkan {{ $perusahaan->firstItem() }} - {{ $perusahaan->lastItem() }} dari total {{ $perusahaan->total() }} data
            </div>

            {{-- Tombol Pagination dan Navigasi Manual --}}
            <div class="flex justify-end space-x-4">
                {{-- Tombol Prev --}}
                @if ($perusahaan->currentPage() > 1)
                <a href="{{ $perusahaan->previousPageUrl() }}" class="bg-teal-600 text-white px-3 py-1 rounded-md hover:bg-teal-700">
                    Prev
                </a>
                @else
                <span class="bg-gray-200 text-gray-500 px-3 py-1 rounded-md cursor-not-allowed">
                    Prev
                </span>
                @endif

                {{-- Pagination Default Laravel --}}
                {{ $perusahaan->links() }}

                {{-- Tombol Next --}}
                @if ($perusahaan->hasMorePages())
                <a href="{{ $perusahaan->nextPageUrl() }}" class="bg-teal-600 text-white px-3 py-1 rounded-md hover:bg-teal-700">
                    Next
                </a>
                @else
                <span class="bg-gray-200 text-gray-500 px-3 py-1 rounded-md cursor-not-allowed">
                    Next
                </span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection