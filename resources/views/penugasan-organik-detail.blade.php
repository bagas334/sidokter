@php
    $detail_tugas->tanggal_penugasan = date('d-m-Y', strtotime($detail_tugas->tanggal_penugasan));
@endphp

@extends('components.layout')

@section('title', 'Detail Penugasan Mitra')

@section('content')
    <div class="size-full flex flex-col items-center px-4 py-6">
        <div class="w-full bg-white shadow-lg rounded-lg p-6">
            <div class="w-full pb-6 flex">
                <x-judul text="Detail Kegiatan"/>
                <div class="flex w-fit space-x-3">
                    <x-back-button :route="'beban-kerja-tugas'"/>
                    <x-edit-button :id="request()->route('id')" :route="'penugasan-mitra-edit-view'"/>
                </div>
            </div>

            <x-output.details-output label="Nama Kegiatan">
                {{$detail_tugas->nama_kegiatan}}
            </x-output.details-output>

            <x-output.details-output label="Pelaksana">
                {{$detail_tugas->pelaksana}}
            </x-output.details-output>

            <x-output.details-output label="Pemberi Tugas">
                {{$detail_tugas->nama_pemberi_tugas}}
            </x-output.details-output>

            <x-output.details-output label="Jabatan Penugasan">
                {{$detail_tugas->jabatan}}
            </x-output.details-output>

            <x-output.details-output label="Tanggal Ditugaskan">
                {{$detail_tugas->tanggal_penugasan}}
            </x-output.details-output>

            <x-output.details-output label="Kuantitas">
                @if($detail_tugas->satuan_kegiatan)
                    {{ $detail_tugas->volume }} {{ $detail_tugas->satuan_kegiatan }}
                @else
                    -
                @endif
            </x-output.details-output>

            <x-output.details-output label="status">
                {{$detail_tugas->status}}
            </x-output.details-output>

            <x-output.details-output label="Catatan">
                {{$detail_tugas->catatan}}
            </x-output.details-output>

            <div class="w-full pb-2">
                <p class="text-lg text-cyan-950 font-medium">Pendapatan: </p>
                <p class="text-md text-gray-600 font-normal">
                    @php
                        $harga_satuan_kegiatan = $detail_tugas->harga_satuan_kegiatan;
                        $volume = $detail_tugas->volume;
                        $pendapatan = $harga_satuan_kegiatan * $volume;

                        $formatted_harga = number_format($harga_satuan_kegiatan, 0, ',', '.');
                        $formatted_pendapatan = number_format($pendapatan, 0, ',', '.');
                    @endphp

                    @if ($pendapatan === null || $harga_satuan_kegiatan === null || $volume === null)
                        -
                    @else
                        {{ $volume }} x {{'@'}}{{ $formatted_harga }} = Rp{{ $formatted_pendapatan }}
                    @endif
                </p>
            </div>

        </div>
    </div>
@endsection
