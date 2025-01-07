@extends('components.layout')

@section('title', 'Master Organik')

@section('content')
    <div class="size-full flex flex-col w-full items-center px-4">
        {{-- Breadcrumb --}}
        <nav class="w-full mb-4 text-sm text-gray-500">
            <ol class="inline-flex space-x-1">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-teal-600 hover:underline">Dashboard</a>
                </li>
                <li>
                    <span class="text-gray-400">/</span>
                </li>
                <li class="text-gray-400">Master Organik</li>
            </ol>
        </nav>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="w-full p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="w-full p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif

        {{-- Judul --}}
        <div class="w-full pb-6">
            <x-judul text="Daftar Organik" />
        </div>

        {{-- Pencarian dan Tombol Tambah --}}
        <div class="w-full flex flex-col md:flex-row justify-between items-center pb-4 gap-4">
            {{-- Search Input --}}
            <form action="{{ route('master-organik.index') }}" method="GET" class="relative flex items-center w-full md:w-64">
                <input type="text" name="search" value="{{ request()->get('search') }}"
                       class="input pl-10 w-full bg-gray-50 border border-gray-300 rounded-md input-sm focus:outline-none focus:ring-1 focus:ring-teal-600 focus:border-teal-600 peer"
                       placeholder="Cari pegawai..." />
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="absolute left-4 w-5 h-5 text-gray-500 transition duration-200 ease-in-out peer-focus:text-teal-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </form>

          {{-- Tombol Tambah --}}
<a href="{{ route('manajemen-user-create-view') }}"
class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-md hover:bg-teal-700">Tambah
</a>

</div>

        {{-- Tabel --}}
        <div class="flex flex-col w-full overflow-x-auto">
            <div class="relative">
                <table class="table-custom w-full text-sm border border-gray-200 rounded-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th scope="col" class="text-center p-2">No</th>
                            <th scope="col" class="text-center p-2">NIP</th>
                            <th scope="col" class="text-center p-2">NIP BPS</th>
                            <th scope="col" class="p-2">Nama</th>
                            <th scope="col" class="text-center p-2">Alias</th>
                            <th scope="col" class="p-2">Jabatan</th>
                            <th scope="col" class="text-center p-2">Status</th>
                            <th scope="col" class="text-center p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pegawai as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="text-center p-2">{{ $pegawai->firstItem() + $loop->index }}</td>
                                <td class="text-center p-2">{{ $item->nip }}</td>
                                <td class="text-center p-2">{{ $item->nip_bps }}</td>
                                <td class="p-2">{{ $item->nama }}</td>
                                <td class="text-center p-2">{{ $item->alias }}</td>
                                <td class="p-2">{{ $item->jabatan }}</td>
                                <td class="text-center p-2">{{ $item->status }}</td>
                                <td class="text-center p-2">
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
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-gray-500 p-4">
                                    Tidak ada data yang sesuai dengan pencarian "{{ request()->get('search') }}".
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="w-full flex justify-end mt-4">
            <div class="inline-flex items-center space-x-2">
                @if ($pegawai->onFirstPage())
                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                        Prev
                    </button>
                @else
                    <a href="{{ $pegawai->previousPageUrl() }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-md hover:bg-teal-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                        Prev
                    </a>
                @endif

                @if ($pegawai->hasMorePages())
                    <a href="{{ $pegawai->nextPageUrl() }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-md hover:bg-teal-700">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             class="w-4 h-4 ml-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                @else
                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             class="w-4 h-4 ml-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </div>
@endsection
