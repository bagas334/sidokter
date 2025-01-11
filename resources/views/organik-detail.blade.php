@extends('components.layout')
@section('title', 'Penugasan')
@section('content')

<?php ?>
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul --}}
    <div class="w-full pb-6">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-teal-600 text-lg">Beban Kerja / Organik / {{$pegawai->nama}}</p>
                <p class="mt-2 text-4xl text-teal-600 font-semibold">{{$pegawai->nama}}</p>
            </div>
            <a class="py-3 px-4 bg-blue-200 text-blue-500 font-bold hover:bg-blue-400 hover:text-blue-700 rounded-xl text-lg" href="{{route('beban-kerja-organik')}}">Kembali</a>

        </div>

        <div class="grid grid-cols-[3fr_1fr] gap-6 pt-6">
            <div class="flex flex-col space-y-6">
                <div class="rounded-xl border bg-white p-6 shadow-md flex flex-col space-y-4">
                    <span class="text-3xl text-teal-600 font-medium">Detail Penugasan</span><br>
                    <div class="w-1/3 p-4 bg-white rounded-lg shadow-lg mt-0">
                        <form action="" method="GET" class="space-y-3">
                            <p class="text-2xl font-semibold text-gray-800 hover:text-teal-600 transition-colors duration-300 font-sans">Pilih tanggal penugasan :</p>
                            <div class="grid grid-cols-2 gap-4">
                                <label for="all">
                                    <input type="radio" name="apt" id="all" value="all" class="hidden" onclick="selectOption('all'); this.form.submit();">
                                    <div class="py-5 text-center bg-gray-200 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-300 focus:outline-none text-xl font-medium tracking-wide">
                                        Semua
                                    </div>
                                </label>

                                <label for="pilih">
                                    <input type="radio" name="apt" id="pilih" value="pilih" class="hidden" onclick="selectOption('pilih')">
                                    <div class="py-5 text-center bg-gray-200 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-300 focus:outline-none text-xl font-medium tracking-wide">
                                        Pilih tanggal
                                    </div>
                                </label>
                            </div>

                            <div class="hidden flex items-center space-x-4" id="selectTanggal">
                                <div id="datepicker" class="space-y-1 text-center mx-auto">
                                    <div>
                                        <label for="tanggal_mulai" class="text-gray-600 text-sm font-medium">Tanggal Mulai:</label>
                                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-input border-gray-300 rounded-md w-full" style="padding: 0.5rem; font-size: 1rem; border-radius: 0.375rem; border: 1px solid #ddd;">
                                    </div>
                                    <div>
                                        <label for="tanggal_akhir" class="text-gray-600 text-sm font-medium">Tanggal Akhir:</label>
                                        <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-input border-gray-300 rounded-md w-full" style="padding: 0.5rem; font-size: 1rem; border-radius: 0.375rem; border: 1px solid #ddd;">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button class="m-auto rounded-lg bg-teal-600 text-white px-4 py-2 text-sm hover:bg-teal-700 transition-all duration-200" type="submit" style="background-color: #319795; color: white; padding: 0.5rem 1rem; font-size: 1rem; border-radius: 0.375rem; transition: background-color 0.2s ease;">
                                        Cari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <p class="mt-5 text-lg text-teal-600 font-semibold">Ringkasan Penugasan</p>

                    {{-- Graph --}}
                    <div class="mt-6">
                        <div id="chart"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-4 mt-6">
                        <!-- Total Penugasan -->
                        <div class="flex flex-col px-6 py-4 overflow-hidden bg-white hover:bg-gradient-to-br hover:from-teal-400 hover:via-teal-500 hover:to-teal-600 rounded-xl shadow-lg transition-transform duration-300 hover:shadow-2xl group">
                            <div class="flex items-center justify-center text-2xl font-bold text-teal-500 group-hover:text-white" id="totalPenugasan">
                            </div>
                            <div class="inline-flex items-center justify-center font-semibold text-lg text-gray-700 group-hover:text-white sm:text-base text-center mt-2">Total Penugasan</div>
                        </div>

                        <!-- Penugasan dalam Proses -->
                        <div class="flex flex-col px-6 py-4 overflow-hidden bg-white hover:bg-gradient-to-br hover:from-teal-400 hover:via-teal-500 hover:to-teal-600 rounded-xl shadow-lg transition-transform duration-300 hover:shadow-2xl group">
                            <div class="flex items-center justify-center text-2xl font-bold text-teal-500 group-hover:text-white" id="penugasanDalamProses">
                            </div>
                            <div class="inline-flex items-center justify-center font-semibold text-lg text-gray-700 group-hover:text-white sm:text-base text-center mt-2">Penugasan dalam Proses</div>
                        </div>

                        <!-- Penugasan telah Dikerjakan -->
                        <div class="flex flex-col px-6 py-4 overflow-hidden bg-white hover:bg-gradient-to-br hover:from-teal-400 hover:via-teal-500 hover:to-teal-600 rounded-xl shadow-lg transition-transform duration-300 hover:shadow-2xl group">
                            <div class="flex items-center justify-center text-2xl font-bold text-teal-500 group-hover:text-white" id="penugasanDikerjakan">
                            </div>
                            <div class="inline-flex items-center justify-center font-semibold text-lg text-gray-700 group-hover:text-white sm:text-base text-center mt-2">Penugasan telah Dikerjakan</div>
                        </div>
                    </div><br>

                    <div class="flex flex-col px-4 py-3 overflow-hidden bg-white hover:bg-gradient-to-br hover:from-teal-400 hover:via-teal-500 hover:to-teal-600 rounded-xl shadow-lg transition-all duration-300 hover:shadow-2xl group">
                        <div class="flex items-center justify-center text-xl font-bold text-teal-500 group-hover:text-white">
                            DETAIL
                        </div>
                    </div><br>

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
                            @foreach($penugasan_pegawai as $item)
                            <tr>
                                <td class="text-center">{{$loop->iteration + ($penugasan_pegawai->currentPage() - 1) * $penugasan_pegawai->perPage() }}</td>
                                <td>{{$item->kegiatan->nama}}</td>
                                <td>{{$item->kegiatan->asal_fungsi}}</td>
                                <td class="text-center">{{$item->kegiatan->tanggal_mulai}}</td>
                                <td class="text-center">{{$item->kegiatan->tanggal_akhir}}</td>
                                <td class="text-end">{{$item->target}}</td>
                                <td class="text-end">{{$item->terlaksana}}</td>
                                <td class="text-center">
                                    <div class="flex justify-center px-2">
                                        <a class="px-4 py-2 rounded-lg bg-teal-500 text-white hover:bg-teal-600 transition duration-200" href="{{ route('beban-kerja-tugas', ['id' => $item->kegiatan->id]) }}">Detail</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <x-paginator :paginator="$penugasan_pegawai" :url="request()->fullUrlWithQuery([])" />
            </div>

            <div class="flex flex-col justify-between bg-white border border-gray-200 rounded-lg p-6 max-w-[50vw] shadow-md hover:shadow-lg transition-all" style="height: auto; max-height: 550px; overflow: hidden;">
                <div class="w-full pb-4">
                    <span class="text-3xl text-teal-700 font-semibold">Informasi Organik</span>
                </div>
                <div class="space-y-4">
                    <div class="text-lg text-gray-800 font-semibold">Nama:</div>
                    <div class="text-xl text-gray-600">{{$pegawai->nama}}</div>
                </div>
                <div class="space-y-4 mt-4">
                    <div class="text-lg text-gray-800 font-semibold">NIP:</div>
                    <div class="text-xl text-gray-600">{{$pegawai->nip}}</div>
                </div>
                <div class="space-y-4 mt-4">
                    <div class="text-lg text-gray-800 font-semibold">NIP BPS:</div>
                    <div class="text-xl text-gray-600">{{$pegawai->nip_bps}}</div>
                </div>
                <div class="space-y-4 mt-4">
                    <div class="text-lg text-gray-800 font-semibold">Alias:</div>
                    <div class="text-xl text-gray-600">{{$pegawai->alias}}</div>
                </div>
                <div class="space-y-4 mt-4">
                    <div class="text-lg text-gray-800 font-semibold">Jabatan:</div>
                    <div class="text-xl text-gray-600">{{$pegawai->jabatan}}
                        @if($pegawai->jabatan == 'Ketua Tim')
                        <span class="text-cyan-700">{{$pegawai->fungsi_ketua_tim}}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    function selectOption(option) {
        const allLabel = document.querySelector('label[for="all"]');
        const pilihLabel = document.querySelector('label[for="pilih"]');
        const selectTanggal = document.getElementById('selectTanggal');

        allLabel.querySelector('div').classList.remove('bg-teal-600', 'text-white');
        allLabel.querySelector('div').classList.add('bg-gray-200', 'text-gray-700');
        pilihLabel.querySelector('div').classList.remove('bg-teal-600', 'text-white');
        pilihLabel.querySelector('div').classList.add('bg-gray-200', 'text-gray-700');

        if (option === 'pilih') {
            pilihLabel.querySelector('div').classList.add('bg-teal-600', 'text-white');
            selectTanggal.classList.remove('hidden');
            selectTanggal.classList.add('flex-row');
        } else {
            allLabel.querySelector('div').classList.add('bg-teal-600', 'text-white');
            selectTanggal.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const radioButtons = document.querySelectorAll('input[name="apt"]');
        radioButtons.forEach(button => {
            button.checked = false;
        });
        selectOption('');
    });
</script>

<script>
    const labels = @json($labels);
    const dataJumlahTugas = @json($dataTarget);
    let dataPenugasan = @json($penugasan_pegawai);

    if (!Array.isArray(dataPenugasan.data)) {
        console.error('dataPenugasan.data is not an array:', dataPenugasan);
        dataPenugasan.data = [];
    }

    const tanggalMulai = @json($tanggalMulai);
    const tanggalAkhir = @json($tanggalAkhir);

    function filterDataByDateRange(data, startDate, endDate) {
        if (!startDate && !endDate) {
            return data;
        }

        startDate = new Date(startDate);
        endDate = new Date(endDate);

        return data.filter(item => {
            const createdAt = new Date(item.created_at);
            const finishedAt = item.finished_at ? new Date(item.finished_at) : null;

            if (finishedAt) {
                return (createdAt >= startDate && createdAt <= endDate) || (finishedAt >= startDate && finishedAt <= endDate);
            } else {
                return createdAt >= startDate && createdAt <= endDate;
            }
        });
    }

    const filteredData = filterDataByDateRange(dataPenugasan.data, tanggalMulai, tanggalAkhir);

    const total = filteredData.reduce((sum, item) => sum + item.target, 0);
    const selesai = filteredData.reduce((sum, item) => sum + item.terlaksana, 0);
    const proses = total - selesai;

    const monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    const filteredLabels = filteredData.map(item => {
        const date = new Date(item.created_at);
        const day = date.getDate();
        const month = monthNames[date.getMonth()];
        return `${day} ${month}`;
    });

    const filteredJumlahTugas = filteredData.map(item => item.target);

    const options = {
        chart: {
            type: 'area',
            height: 350,
            fontFamily: 'Inter, sans-serif',
        },
        series: [{
            name: 'Jumlah Tugas',
            data: filteredJumlahTugas,
        }],
        xaxis: {
            categories: filteredLabels,
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

    const chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    document.getElementById('totalPenugasan').textContent = total;
    document.getElementById('penugasanDalamProses').textContent = proses;
    document.getElementById('penugasanDikerjakan').textContent = selesai;

    document.getElementById('pilih').addEventListener('click', function() {
        let selectTanggal = document.getElementById('selectTanggal');
        selectTanggal.style.display = 'flex';
    });

    document.getElementById('all').addEventListener('click', function() {
        let selectTanggal = document.getElementById('selectTanggal');
        selectTanggal.style.display = 'none';
    });
</script>


@endsection