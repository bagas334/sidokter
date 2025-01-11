@extends('components.layout')

@section('title', 'Master Organik')

@section('content')

<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul --}}
    <div class="w-full pb-6">
        <x-judul text="Daftar Organik" />
    </div>

    {{-- Pencarian dan Tombol Tambah --}}
    <div class="w-full flex flex-col md:flex-row justify-between items-center pb-4 gap-4">
        {{-- Search Input Component --}}
        <x-search-bar
            :action="route('master-organik.index')"
            :search="request()->get('search')"
            placeholder="Cari Pengguna"
            formId="search-form-organik"
            inputId="search-input-organik" />


        {{-- Tombol Tambah --}}
        <a href="{{ route('manajemen-user-create-view') }}"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-md hover:bg-teal-700">Tambah
        </a>
    </div>
<<<<<<< HEAD

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
=======
>>>>>>> 5f71af731b1b86261d9abc362a55411b4eb7b591
</div>

{{-- Tabel --}}
<div class="flex flex-col w-full overflow-x-auto">
    <div class="relative">
        <table class="table-custom w-full text-sm border border-gray-200 overflow-hidden rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th scope="col" class="text-center p-2 rounded-tl-lg">No</th>
                    <th scope="col" class="text-center p-2">NIP</th>
                    <th scope="col" class="text-center p-2">NIP BPS</th>
                    <th scope="col" class="text-center p-2">Nama</th>
                    <th scope="col" class="text-center p-2">Alias</th>
                    <th scope="col" class="text-center p-2">Jabatan</th>
                    <th scope="col" class="text-center p-2">Status</th>
                    <th scope="col" class="text-center p-2 rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawai as $item)
                <tr class="hover:bg-gray-50">
                    <td class="text-center p-2 rounded-bl-lg">{{ $loop->iteration + ($pegawai->currentPage() - 1) * $pegawai->perPage() }}</td>
                    <td class="text-center p-2">{{ $item->nip }}</td>
                    <td class="text-center p-2">{{ $item->nip_bps }}</td>
                    <td class="p-2 text-center">{{ $item->nama }}</td>
                    <td class="text-center p-2">{{ $item->alias }}</td>
                    <td class="p-2 text-center">{{ $item->jabatan }}</td>
                    <td class="text-center p-2">{{ $item->status }}</td>
                    <td class="text-center p-2 rounded-br-lg">
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
                    <td colspan="12" class="text-center text-gray-500 p-4">
                        Tidak ada data yang sesuai dengan pencarian "{{ request()->get('search') }}".
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-paginator :paginator="$pegawai" :url="request()->fullUrlWithQuery(['search' => request()->get('search'), 'page' => $pegawai->currentPage()])" />
</div>

@endsection