@extends('components.layout')

@section('title', 'Semua Perusahaan')

@section('content')

<style>
</style>
<div class="size-full flex flex-col items-center px-4 overflow-x-hidden max-w-screen-md">
    {{-- Judul --}}
    <div class="w-full pb-6">
        <x-judul text="Semua Perusahaan" />
    </div>

    {{-- Pencarian dan Tombol Tambah --}}
    <div class="w-full flex flex-col md:flex-row justify-between items-center pb-4 gap-4">
        {{-- Search Input Component --}}
        <x-search-bar
            :action="route('perusahaan.index')"
            :search="request()->get('search')"
            placeholder="Cari berdasarkan Nama atau Alamat..."
            formId="search-perusahaan-form"
            inputId="search-perusahaan-input" />

        {{-- Tombol Tambah --}}
        <div class="flex space-x-4 mt-4 sm:mt-0">
            {{-- Tombol Tambah Perusahaan --}}
            <a href="{{ route('perusahaan.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-md hover:bg-teal-700">
                Tambah Perusahaan
            </a>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="flex flex-col w-full">
        <!-- Wrapper untuk scroll horizontal -->
        <div class="overflow-x-auto">
            <div class="relative">
                <table class="table-custom lg:w-full text-sm border border-gray-200 rounded-lg">
                    <thead class="bg-teal-600 text-white">
                        <tr>
                            <th scope="col" class="text-center p-2 rounded-tl-lg">No</th>
                            <th scope="col" class="text-center p-2">ID SBR</th>
                            <th scope="col" class="text-center p-2">Kode Wilayah</th>
                            <th scope="col" class="text-center p-2">Nama Usaha</th>
                            <th scope="col" class="text-center p-2">SLS</th>
                            <th scope="col" class="text-center p-2">Alamat Detail</th>
                            <th scope="col" class="text-center p-2">Kode KBLI</th>
                            <th scope="col" class="text-center p-2">Nama CP</th>
                            <th scope="col" class="text-center p-2">Nomor CP</th>
                            <th scope="col" class="text-center p-2">Email</th>
                            <th scope="col" class="text-center p-2">Jumlah Tersampel</th>
                            <th scope="col" class="text-center p-2 rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($perusahaan->count() > 0)
                        @foreach ($perusahaan as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="text-center p-2 rounded-bl-lg">{{ $loop->iteration + ($perusahaan->currentPage() - 1) * $perusahaan->perPage() }}</td>
                            <td class="text-center p-2">{{ $item->idsbr }}</td>
                            <td class="text-center p-2">{{ $item->kode_wilayah }}</td>
                            <td class="text-center p-2">{{ $item->nama_usaha }}</td>
                            <td class="text-center p-2">{{ $item->sls }}</td>
                            <td class="p-2">{{ $item->alamat_detail }}</td>
                            <td class="text-center p-2">{{ $item->kode_kbli }}</td>
                            <td class="text-center p-2">{{ $item->nama_cp }}</td>
                            <td class="text-center p-2">{{ $item->nomor_cp }}</td>
                            <td class="text-center p-2">{{ $item->email }}</td>
                            <td class="text-center p-2">{{ $item->sampel_count }}</td>
                            <td class="text-center p-2 rounded-br-lg">
                                <div class="flex justify-center space-x-2">
                                    <x-edit-button-table :id="$item->id" :route="'perusahaan.edit'" />
                                    <form action="{{ route('perusahaan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perusahaan ini?');">
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
    </div>

    <x-paginator :paginator="$perusahaan" :url="request()->fullUrlWithQuery(['search' => request()->get('search'), 'page' => $perusahaan->currentPage()])" />
</div>
@endsection