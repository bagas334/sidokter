@php

//    $detail_tugas->tanggal_penugasan = date('d-m-Y', strtotime($detail_tugas->tanggal_penugasan));
@endphp

@extends('components.layout')

@section('title', 'Detail Sampel Kegiatan')

@section('content')
    <div class="size-full flex flex-col items-center px-4 py-6">
        <div class="w-full bg-white shadow-lg rounded-lg p-6">
            <div class="w-full pb-6 flex">
                <x-judul text="Detail Sampel"/>
                <div class="flex w-fit space-x-3">
                    <x-back-button :route="'sampel-index'"/>
                    <x-edit-button :id="request()->route('id')" :route="'sampel-edit-view'"/>
                </div>
            </div>

            <x-output.details-output label="Nama Kegiatan">
                {{$kegiatan->nama}}
            </x-output.details-output>

            <x-output.details-output label="Asal Fungsi">
                {{$kegiatan->asal_fungsi}}
            </x-output.details-output>

            <x-output.details-output label="Jumlah Sampel">
                {{$kegiatan->banyak_sampel}}
            </x-output.details-output>

            <x-output.details-output label="Status Sampel">
                {{$kegiatan->status_sampel}}
            </x-output.details-output>

            <p class="text-lg text-cyan-950 font-medium">Sampel Terpilih</p>
            <div class="my-2 flex flex-col justify-center overflow-auto max-w-[78vw]">
                <div class="relative max-h-96">
                    <table class="table-custom">
                        <thead>
                        <tr>
                            <th scope="col" rowspan="2" class="w-8 text-center">No</th>
                            <th scope="col" rowspan="2" class="w-52">Nama</th>
                            <th scope="col" rowspan="2" class="w-52 text-center">Email</th>
                            <th scope="col" colspan="2" class="w-52 text-center border-b-gray-200 border-b-[1px]">Contact Person</th>
                        </tr>
                        <tr>
                            <th scope="col" class="w-52">Nama</th>
                            <th scope="col" class="w-52 text-center">Telepon</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($daftar_sampel as $item)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td>{{$item->nama_perusahaan}}</td>
                                <td class="text-center">{{$item->email}}</td>
                                <td>{{$item->nama_cp}}</td>
                                <td class="text-center">{{$item->nomor_cp}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
