@extends('components.layout')

@section('title', 'Penugasan')

@section('content')

<?php ?>
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul--}}
    <div class="w-full pb-6 ">
        <div class="flex justify-beetween">
            <div>
                <p>Beban Kerja / Organik / {{$pegawai->nama}}</p>
                <p class="text-3xl">{{$pegawai->nama}}</p>
            </div>
        </div>

        <div class="grid grid-cols-[4fr_1.5fr] grid-rows-auto my-5 flex">
            <div class="rounded-md border border-gray-500 mr-1 p-2">
                <p class="text-xl font-medium text-gray-900" style="margin-bottom: 5px;">Detail Penugasan</p>
                <p >Pilih tanggal penugasan :</p>

                <form action="">
                    <div class="flex items-center space-x-4">
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

                            <button class="m-auto rounded-md bg-blue-500 text-white px-4 py-1.5 text-sm hover:bg-blue-600 transition" type="submit">Cari</button>
                        </div>
                    </div>
                </form>

                <p style="margin-top: 5px;">Ringkasan penugasan</p>

                {{-- Graph --}}
                <div class="mt-4">
                    <div id="chart"></div>
                </div>

                <div class="grid grid-cols-3 gap-2 mt-6">
                    <!-- Total Penugasan -->
                    <div class="flex flex-col px-6 py-4 overflow-hidden bg-white hover:bg-gradient-to-br hover:from-purple-400 hover:via-blue-400 hover:to-blue-500 rounded-xl shadow-lg duration-300 hover:shadow-2xl group">
                        <div class="flex items-center justify-center text-2xl font-bold text-blue-500 group-hover:text-gray-200">
                            {{$total}}
                        </div>
                        <div class="inline-flex items-center justify-center font-bold text-lg text-gray-600 group-hover:text-gray-200 sm:text-base text-center mt-2">Total Penugasan</div>
                    </div>

                    <!-- Penugasan dalam Proses -->
                    <div class="flex flex-col px-6 py-4 overflow-hidden bg-white hover:bg-gradient-to-br hover:from-purple-400 hover:via-blue-400 hover:to-blue-500 rounded-xl shadow-lg duration-300 hover:shadow-2xl group">
                        <div class="flex items-center justify-center text-2xl font-bold text-blue-500 group-hover:text-gray-200">
                            {{$proses}}
                        </div>
                        <div class="inline-flex items-center justify-center font-bold text-lg text-gray-600 group-hover:text-gray-200 sm:text-base text-center mt-2">Penugasan dalam Proses</div>
                    </div>

                    <!-- Penugasan telah Dikerjakan -->
                    <div class="flex flex-col px-6 py-4 overflow-hidden bg-white hover:bg-gradient-to-br hover:from-purple-400 hover:via-blue-400 hover:to-blue-500 rounded-xl shadow-lg duration-300 hover:shadow-2xl group">
                        <div class="flex items-center justify-center text-2xl font-bold text-blue-500 group-hover:text-gray-200">
                            {{$selesai}}
                        </div>
                        <div class="inline-flex items-center justify-center font-bold text-lg text-gray-600 group-hover:text-gray-200 sm:text-base text-center mt-2">Penugasan telah Dikerjakan</div>
                    </div>
                </div>

                <p class="rounded-md m-1 p-2 border border-gray-400" id="detailButton" style="margin-top: 20px;">Detail</p>
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

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Data dari backend
        const labels = {!! json_encode($labels) !!}; // Bulan berdasarkan tanggal_mulai dan tanggal_akhir
        const dataJumlahTugas = {!! json_encode($dataTarget) !!}; // Total tugas dari rentang tanggal kegiatan

        // Konfigurasi ApexCharts
        const options = {
            chart: {
                type: 'area', // Menggunakan grafik area
                height: 350,
                fontFamily: 'Inter, sans-serif', // Konsistensi font
            },
            series: [
                {
                    name: 'Jumlah Tugas',
                    data: dataJumlahTugas,
                },
            ],
            xaxis: {
                categories: labels, 
                title: {
                    text: 'Bulan',
                },
                axisBorder: {
                    show: false, 
                },
                axisTicks: {
                    show: false, 
                },
            },
            yaxis: {
                title: {
                    text: 'Jumlah Tugas',
                },
                min: 0,
                show: true, 
            },
            stroke: {
                curve: 'smooth',
                width: 4,
            },
            markers: {
                size: 5,
                colors: ['#1A56DB'],
                strokeWidth: 2,
            },
            colors: ['#1C64F2'], 
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical', 
                    shadeIntensity: 0.5,
                    gradientToColors: ['#1C64F2'], 
                    opacityFrom: 0.65, 
                    opacityTo: 0.2, 
                    stops: [0, 100],
                },
            },
            tooltip: {
                enabled: true,
                x: {
                    show: true,
                },
            },
            grid: {
                show: false, 
                padding: {
                    left: 10,
                    right: 10,
                },
            },
        };

        // Render grafik
        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

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

            if (detailButton.style.backgroundColor === 'rgb(157, 187, 250)') {
                detailButton.style.backgroundColor = '';
                tabel.style.display = 'none';
            } else {
                detailButton.style.backgroundColor = 'rgb(157, 187, 250)';
                tabel.style.display = '';
            }
        });
    </script>


@endsection