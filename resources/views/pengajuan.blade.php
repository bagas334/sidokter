@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('title', 'Semua Pengajuan Beban Kerja')

@section('content')

<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul--}}
    <div class="w-full pb-6 ">
        <x-judul text="Semua Pengajuan Beban Kerja" />
    </div>


    {{-- Tabel--}}
    <div class="flex flex-col justify-center overflow-x-auto max-w-[78vw]">
        <div class="relative min-w-[100vw]">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2" class="w-8 text-center">No</th>
                        <th scope="col" rowspan="2" class="w-56">Nama Pegawai</th>
                        <th scope="col" rowspan="2" class="w-56">Nama Kegiatan</th>
                        <th scope="col" rowspan="2" class="w-28">Tanggal Pengajuan</th>
                        <th scope="col" rowspan="2" class="w-28 text-end">Jumlah Pengajuan</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Satuan</th>
                        <th scope="col" rowspan="2" class="w-0 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tugas_pegawai as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->penugasanPegawai->pegawai->nama }}</td>
                        <td>{{ $item->penugasanPegawai->kegiatan->nama }}</td>
                        <td class="text-center">
                            @if($item->created_at)
                            {{ Carbon::parse($item->created_at)->format('d-m-Y') }}
                            @else
                            -
                            @endif
                        </td>
                        <td class="text-end">{{ $item->dikerjakan }}</td>
                        <td class="text-center">{{$item->penugasanPegawai->kegiatan->satuan }}</td>
                        <td class="text-center">
                            <div class="flex justify-between">
                                <x-detail-button-table :id="$item->id" :route="'master-kegiatan-edit-view'" />
                                <form action="{{ route('pengajuan-organik-approve-tabel', ['tugasId' => $item->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('POST')
                                    <x-acc-button />
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}

</div>
@endsection