@extends('components.layout')

@section('title', 'Buat Kegiatan')

@section('content')
<?php
?>
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul--}}
    <div class="w-full pb-6 ">
        <div class="flex  justify-beetween">
            <div>
                <p class="text-sm">Detail Sampel / {{$sampel->nama}}</p>
                <p class="text-3xl font-bold text-teal-600">Daftar Perusahaan</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col w-full overflow-x-auto">
        <div class="relative">
            <table class="table-custom w-full text-sm border border-gray-200 overflow-hidden rounded-lg">
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
                        <th scope="col" class="text-center p-2 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perusahaan as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="text-center p-2">{{ $loop->iteration + ($perusahaan->currentPage() - 1) * $perusahaan->perPage() }}</td>
                        <td class="text-center p-2">{{ $item->idsbr }}</td>
                        <td class="text-center p-2">{{ $item->kode_wilayah }}</td>
                        <td class="text-center p-2">{{ $item->nama_usaha }}</td>
                        <td class="text-center p-2">{{ $item->sls }}</td>
                        <td class="p-2">{{ $item->alamat_detail }}</td>
                        <td class="text-center p-2">{{ $item->kode_kbli }}</td>
                        <td class="text-center p-2">{{ $item->nama_cp }}</td>
                        <td class="text-center p-2">{{ $item->nomor_cp }}</td>
                        <td class="text-center p-2">{{ $item->email }}</td>
                        <td class="text-center p-2">
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
                </tbody>
            </table>
            <x-paginator :paginator="$perusahaan" :url="request()->fullUrlWithQuery([])" />
        </div>
    </div>
</div>
@endsection