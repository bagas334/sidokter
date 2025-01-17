@extends('components.layout')

@section('title', 'Master Organik')

@section('content')

<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul --}}
    <div class="w-full pb-6">
        <x-judul text="Manajemen User" />
    </div>

    {{-- Pencarian dan Tombol Tambah --}}
    <div class="w-full flex flex-col md:flex-row justify-between items-center pb-4 gap-4">
        {{-- Search Input Component --}}
        <x-search-bar
            :action="route('master-organik')"
            :search="request()->get('search')"
            placeholder="Cari Pengguna"
            formId="search-form-organik"
            inputId="search-input-organik" />


        {{-- Tombol Tambah --}}
        <a href="{{ route('manajemen-user-create') }}"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-md hover:bg-teal-700">Tambah
        </a>
    </div>
</div>

{{-- Tabel --}}
<div class="flex flex-col w-full overflow-x-auto">
    <div class="relative">
        <table class="table-custom w-full text-sm border border-gray-200 overflow-hidden rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th scope="col" class="text-center p-2 rounded-tl-lg">No</th>
                    <th scope="col" class="text-center p-2">NIP BPS</th>
                    <th scope="col" class="text-center p-2">Nama</th>
                    <th scope="col" class="text-center p-2">Email</th>
                    <th scope="col" class="text-center p-2">Jabatan</th>
                    <th scope="col" class="text-center p-2 rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($user)
                @forelse ($user as $item)
                <tr class="hover:bg-gray-50">
                    <td class="text-center p-2 rounded-bl-lg">{{ $loop->iteration + ($user->currentPage() - 1) * $user->perPage() }}</td>
                    <td class="text-center p-2">{{ $item->pegawai->nip_bps }}</td>
                    <td class="p-2 text-center">{{ $item->pegawai->nama }}</td>
                    <td class="p-2 text-center">{{ $item->email }}</td>
                    <td class="p-2 text-center">{{ $item->jabatan }}</td>
                    <td class="text-center p-2 rounded-br-lg">
                        <div class="flex justify-center space-x-2">
                            <x-edit-button-table :id="$item->id" :route="'manajemen-user-edit'" />
                            <form action="{{ route('manajemen-user-delete', $item->id) }}" method="POST">
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
                @else
                <tr class="hover:bg-gray-50">Kosong.</tr>
                @endif
            </tbody>
        </table>
    </div>
    <x-paginator :paginator="$user" :url="request()->fullUrlWithQuery(['search' => request()->get('search'), 'page' => $user->currentPage()])" />
</div>

@endsection