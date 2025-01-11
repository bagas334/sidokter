@extends('components.layout')

@section('title', 'Master Organik')

@section('content')
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul --}}
    <div class="w-full pb-6">
        <x-judul text="Daftar Pengguna" />
    </div>

    {{-- Pencarian --}}
    <div class="w-full flex flex-col sm:flex-row justify-between items-center pb-4">
        {{-- Search Input --}}
        <form action="{{ route('master-organik') }}" method="GET" class="w-full flex items-center">
            <div class="relative flex items-center w-full sm:w-64 mb-4 sm:mb-0">
                <input type="text"
                    class="input pl-10 m-2 ml-0 w-full bg-gray-50 border border-gray-300 rounded-md input-sm focus:outline-none focus:ring-1 focus:ring-teal-600 focus:border-teal-600 peer"
                    placeholder="Cari pengguna" />


                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="absolute left-4 w-5 h-5 text-gray-500 transition duration-200 ease-in-out peer-focus:text-teal-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
        </form>

        {{-- Tombol Tambah --}}
        <x-tambah-button :route="route('manajemen-user-create')" />
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto w-full">
        <div class="relative">
            <table class="min-w-full table-auto bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="text-left bg-teal-600 text-white">
                        <th scope="col" class="px-4 py-3 text-center">No</th>
                        <th scope="col" class="px-4 py-3 text-center">NIP</th>
                        <th scope="col" class="px-4 py-3 text-center">NIP BPS</th>
                        <th scope="col" class="px-4 py-3">Nama</th>
                        <th scope="col" class="px-4 py-3 text-center">Alias</th>
                        <th scope="col" class="px-4 py-3 text-center">Jabatan</th>
                        @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan']))
                        <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @foreach ($pegawai as $item)

                    <tr class="border-b hover:bg-gray-100">
                        <td class="text-center px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="text-center px-4 py-3">{{ $item->nip }}</td>
                        <td class="text-center px-4 py-3">{{ $item->nip_bps }}</td>
                        <td class="px-4 py-3">{{ $item->nama }}</td>
                        <td class="text-center px-4 py-3">{{ $item->alias }}</td>
                        <td class="text-center px-4 py-3">{{ $item->jabatan }}</td>
                        @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan']))
                        <td class="text-center px-4 py-3">
                            <div class="flex justify-center space-x-2">
                                <x-edit-button-table :id="$item->id" :route="'master-organik-edit-view'" />
                                <form action="{{ route('master-organik-delete', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <x-remove-button />
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <x-paginator :paginator="$pegawai" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[placeholder="Cari pengguna"]');
            searchInput.addEventListener('input', function() {
                const query = this.value;
                fetch(`{{ route('search-pegawai') }}?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.querySelector('tbody');
                        tbody.innerHTML = '';
                        data.forEach((item, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
    <td class="text-center py-2 px-4">${index + 1}</td>
    <td class="text-center py-2 px-4">${item.nip}</td>
    <td class="text-center py-2 px-4">${item.nip_bps}</td>
    <td class="py-2 px-4">${item.nama}</td>
    <td class="text-center py-2 px-4">${item.alias}</td>
    <td class="text-center py-2 px-4">${item.jabatan}</td>
    @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan']))
    <td class="text-center py-2 px-4">
        <div class="flex justify-center space-x-2 px-2">
            <x-edit-button-table :id="$item->id" :route="'master-organik-edit-view'" />
            <form action="{{ route('master-organik-delete', $item->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <x-remove-button />
            </form>
        </div>
    </td>
    @endif
`;

                            tbody.appendChild(row);
                        });
                    });
            });
        });
    </script>
</div>
@endsection