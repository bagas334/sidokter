@extends('components.layout')
@section('title', 'Penugasan')
@section('content')
<?php ?>
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul--}}
    <div class="w-full pb-6 ">
        <div class="flex  justify-beetween">
            <div>
                <p>Beban Kerja / Organik / {{$pegawai->nama}}</p>
                <p class="text-3xl">{{$pegawai->nama}}</p>
            </div>
        </div>

        <div class="my-5 flex">
            <div class="rounded-md border border-gray-500 mr-1 p-2">
                <p>Detail Penugasan</p>
                <p>Pilih tanggal penugasan :</p>
                <form action="">
                    <label for="all">Semua</label>
                    <input type="radio" name="apt" id="all" value="all" checked>
                    <label for="pilih">Pilih tanggal</label>
                    <input type="radio" name="apt" id="pilih" value="pilih">
                    <div class="hidden" id="selectTanggal" style="">
                        <x-input.datepicker
                            :name="'tanggal_mulai'"
                            :label_size="'md'">
                        </x-input.datepicker>
                        <x-input.datepicker
                            :name="'tanggal_akhir'"
                            :label_size="'md'">
                        </x-input.datepicker>

                        <button class="rounded-md border border-gray-500 p-1" type="submit">Cari</button>
                    </div>
                </form>
                <p>Ringkasan penugasan</p>
                <p>GRAFIKKKKK</p>
                <div class="flex">
                    <div class="p-2 m-1 border border-gray-400 rounded-md">
                        <p>Total</p>
                        <p class="text-xl font-bold text-center">{{$total}}</p>
                    </div>
                    <div class="p-2 m-1 border border-gray-400 rounded-md">
                        <p>Proses</p>
                        <p class="text-xl font-bold text-center">{{$proses}}</p>
                    </div>
                    <div class="p-2 m-1 border border-gray-400 rounded-md">
                        <p>Dikerjakan</p>
                        <p class="text-xl font-bold text-center">{{$selesai}}</p>
                    </div>
                </div>
                <p class="rounded-md m-1 p-2 border border-gray-400" id="detailButton">Detail</p>
                <table class="table-custom" id="tabel">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2" class="w-8 text-center">No</th>
                            <th scope="col" rowspan="2" class="w-56">Kegiatan</th>
                            <th scope="col" rowspan="2" class="w-24">Asal Fungsi</th>
                            <th scope="col" colspan="2" class="text-center border-b-gray-200 border-b-[1px]">Tanggal</th>
                            <th scope="col" rowspan="2" class="w-28 text-end">Target</th>
                            <th scope="col" rowspan="2" class="w-28 text-end">Terlaksana</th>
                            <th scope="col" rowspan="2" class="w-28 text-center">Aksi</th>
                        </tr>
                        <tr>
                            <th scope="col" class="w-28 text-center">Mulai</th>
                            <th scope="col" class="w-28 text-center">Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatan as $item)
                        <tr>
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td>{{$item->kegiatan->nama}}</td>
                            <td>{{$item->kegiatan->asal_fungsi}}</td>
                            <td class="text-center">{{$item->kegiatan->tanggal_mulai}}</td>
                            <td class="text-center">{{$item->kegiatan->tanggal_akhir}}</td>
                            <td class="text-end">{{$item->target}}</td>
                            <td class="text-end">{{$item->terlaksana}}</td>
                            <td class="text-center">
                                <div class="flex justify-between px-2">
                                    <p class="flex justify-center border border-gray-500 rounded-md m-auto p-2">Detail</p>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="rounded-md border border-gray-500 ml-1 p-3">
                <p class="font-bold text-xl">Informasi Organik</p>
                <p class="font-bold">Nama :</p>
                <p class="">{{$pegawai->nama}}</p>
                <p class="font-bold">NIP :</p>
                <p class="">{{$pegawai->nip}}</p>
                <p class="font-bold">NIP BPS :</p>
                <p class="">{{$pegawai->nip_bps}}</p>
                <p class="font-bold">Alias :</p>
                <p class="">{{$pegawai->alias}}</p>
                <p class="font-bold">Jabatan :</p>
                <p class="">{{$pegawai->jabatan}}
                    <span>
                        @if($pegawai->jabatan == 'Ketua Tim')
                        {{$pegawai->fungsi_ketua_tim}}
                        @endif
                    </span>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('pilih').addEventListener('click', function() {
            let selectTanggal = document.getElementById('selectTanggal');
            selectTanggal.style.display = 'flex';
        });

        document.getElementById('all').addEventListener('click', function() {
            let selectTanggal = document.getElementById('selectTanggal');
            selectTanggal.style.display = 'none';
        });

        document.getElementById('detailButton').addEventListener('click', function() {
            let detailButton = document.getElementById('detailButton');
            let tabel = document.getElementById('tabel');

            if (detailButton.style.backgroundColor === 'blue') {
                detailButton.style.backgroundColor = '';
                tabel.style.display = 'none';
            } else {
                detailButton.style.backgroundColor = 'blue';
                tabel.style.display = '';
            }
        });
    </script>


    @endsection