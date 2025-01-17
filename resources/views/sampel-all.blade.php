@extends('components.layout')

@section('title', 'Manajemen Sampel')


@section('content')
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul--}}
    <div class="w-full pb-6 ">
        <x-judul text="Daftar Sampel" />
    </div>

    {{-- Pencarian--}}
    <div class="w-full flex flex-row justify-between items-center pb-1">
        {{-- Search Input --}}
        <div class="relative flex items-center w-64">
            <input type="text"
                class="input pl-10 m-2 ml-0 w-full bg-gray-50 border border-gray-300 rounded-md input-sm focus:outline-none focus:ring-1 focus:ring-teal-600 focus:border-teal-600 peer"
                placeholder="Cari sampel" />

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="absolute left-4 w-5 h-5 text-gray-500 transition duration-200 ease-in-out peer-focus:text-teal-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </div>
        <x-tambah-button :route="route('sampel-create')" />
    </div>

    {{-- Tabel--}}
    <div class="flex flex-col justify-center w-full">
        <div class="relative w-full">
            <table class="table-custom rounded-lg overflow-hidden border-separate border-spacing-0 w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold border-t-[1px] border-b-[rgb(229,231,235)] rounded-tl-lg">No</th>
                        <th class="px-4 py-2 text-left font-semibold border-t-[1px] border-b-[rgb(229,231,235)]">Nama sampel</th>
                        <th class="px-4 py-2 text-left font-semibold border-t-[1px] border-b-[rgb(229,231,235)]">Tanggal dibuat</th>
                        <th class="px-4 py-2 text-left font-semibold border-t-[1px] border-b-[rgb(229,231,235)]">Pembuat</th>
                        <th class="px-4 py-2 text-left font-semibold border-t-[1px] border-b-[rgb(229,231,235)]">Kegiatan</th>
                        <th class="px-4 py-2 text-left font-semibold border-t-[1px] border-b-[rgb(229,231,235)] rounded-tr-lg">Aksi</th>
                        <th class="px-4 py-2 text-left font-semibold border-t-[1px] border-b-[rgb(229,231,235)]">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sampel as $item)
                    <tr class="hover:bg-gray-50 border-b-[1px] border-b-[rgb(229,231,235)]">
                        <td class="px-4 py-2 border-b-[1px] border-b-[rgb(229,231,235)]">{{$loop->iteration + ($sampel->currentPage() - 1) * $sampel->perPage() }}</td>
                        <td class="px-4 py-2 border-b-[1px] border-b-[rgb(229,231,235)]">{{$item->nama}}</td>
                        <td class="px-4 py-2 border-b-[1px] border-b-[rgb(229,231,235)]">{{$item->created_at}}</td>
                        <td class="px-4 py-2 border-b-[1px] border-b-[rgb(229,231,235)]">{{$item->pegawai->nama}}</td>
                        <td class="px-4 py-2 border-b-[1px] border-b-[rgb(229,231,235)]">
                            @if($item->kegiatan)
                            {{$item->kegiatan->nama}}
                            @else
                            Tidak ada
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center border-b-[1px] border-b-[rgb(229,231,235)]">
                            <div class="flex justify-center space-x-2 px-2">
                                <a href="{{ route('sampel-detail', ['id' => $item->id]) }}" class="inline-block px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition duration-200">Detail</a>
                            </div>
                        </td>
                        <td class="px-4 py-2 border-b-[1px] border-b-[rgb(229,231,235)]">{{$item->catatan}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <x-paginator :paginator="$sampel" :url="request()->fullUrlWithQuery([])" />
</div>
@endsection