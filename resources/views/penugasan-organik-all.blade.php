@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('title', 'Semua Penugasan Organik')

@section('content')
<div class="size-full flex flex-col w-full items-center px-4">
    <div class="w-full pb-6">
        <x-judul text="Penugasan Organik" />
        <p>Pilih petugas terlebih dahulu.</p>
    </div>

    <div class="flex flex-col justify-center overflow-x-auto w-full">
        <div class="relative w-full">
            <table class="table-custom w-full rounded-md overflow-hidden">
                <thead>
                    <tr>
                        <th scope="col" rowspan="1" class="w-12 text-center">No</th>
                        <th scope="col" rowspan="1" class="w-32 text-center">NIP BPS</th>
                        <th scope="col" rowspan="1" class="w-48 text-center">Pelaksana</th>
                        <th scope="col" rowspan="1" class="w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penugasan as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + ($penugasan->currentPage() - 1) * $penugasan->perPage() }}</td>
                        <td class="text-center">{{ $item->pegawai->nip_bps }}</td>
                        <td class="text-center">{{ $item->pegawai->nama }}</td>
                        <td class="text-center">
                            <div class="flex justify-center px-2">
                                <a class="px-2 py-1 rounded-md bg-blue-500 text-white hover:bg-blue-600" href="{{ route('penugasan-organik-detail', ['id' => $item->kegiatan->id, 'petugas' => $item->pegawai->id]) }}">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <x-paginator :paginator="$penugasan" :url="request()->fullUrlWithQuery([])" />

</div>
</div>

@endsection