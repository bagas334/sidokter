@extends('components.layout')

@section('title', 'Dashboard')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<div class="mb-4">
    <div class="bg-green-50 text-green-900 p-6 rounded-lg shadow-md border border-green-200 mb-4">
        <p class="text-3xl font-semibold font-sans">Selamat Datang, {{auth()->user()->pegawai->nama}}!</p>
    </div>
    <div class="bg-gray-50 p-4 rounded-lg shadow-md border border-gray-200 flex space-x-4">
        <div class="w-1/3 p-4 bg-white rounded-lg shadow-lg">
            <form action="" method="GET" class="space-y-3">
                <p class="text-2xl font-semibold text-gray-800 hover:text-teal-600 transition-colors duration-300 font-sans">Pilih Periode:</p>
                <div class="grid grid-cols-2 gap-4">
                    <label>
                        <input type="radio" name="periode" id="semua" value="semua" class="hidden" onchange="this.form.submit();">
                        <div class="py-5 text-center bg-gray-200 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-300 focus:outline-none text-xl font-medium tracking-wide">
                            SEMUA
                        </div>
                    </label>

                    <label>
                        <input type="radio" name="periode" id="tahunan" value="tahunan" class="hidden">
                        <div class="py-5 text-center bg-gray-200 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-300 focus:outline-none text-xl font-medium tracking-wide">
                            TAHUNAN
                        </div>
                    </label>

                    <label>
                        <input type="radio" name="periode" id="bulanan" value="bulanan" class="hidden">
                        <div class="py-5 text-center bg-gray-200 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-300 focus:outline-none text-xl font-medium tracking-wide">
                            BULANAN
                        </div>
                    </label>

                    <label>
                        <input type="radio" name="periode" id="pilih" value="pilih" class="hidden">
                        <div class="py-5 text-center bg-gray-200 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-300 focus:outline-none text-xl font-medium tracking-wide">
                            PILIH
                        </div>
                    </label>
                </div>

                <div class="space-y-3">
                    <div id="inputTahun" class="hidden text-center mx-auto w-1/2">
                        <label for="tahun" class="text-gray-600 text-sm font-medium">Pilih Tahun:</label>
                        <input type="number" id="tahun" name="tahun" min="2000" max="2025" placeholder="YYYY"
                            class="form-input border-gray-300 rounded-md w-full">
                    </div>

                    <div id="inputBulan" class="hidden text-center mx-auto w-1/2">
                        <label for="bulan" class="text-gray-600 text-sm font-medium">Pilih Bulan:</label>
                        <input type="month" id="bulan" name="bulan"
                            class="form-input border-gray-300 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div id="datepicker" class="hidden space-y-1 text-center mx-auto w-1/2">
                        <div>
                            <label for="tanggal_mulai" class="text-gray-600 text-sm font-medium">Tanggal Mulai:</label>
                            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                                class="form-input border-gray-300 rounded-md w-full">
                        </div>
                        <div>
                            <label for="tanggal_akhir" class="text-gray-600 text-sm font-medium">Tanggal Akhir:</label>
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir"
                                class="form-input border-gray-300 rounded-md w-full">
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <input type="submit" value="Kirim"
                        class="bg-gray-600 text-white py-2 px-5 rounded-md hover:bg-gray-700 cursor-pointer text-lg font-semibold">
                </div>
                <input type="hidden" id="hiddenTanggalMulai">
                <input type="hidden" id="hiddenTanggalAkhir">
            </form>
        </div>

        <div class="w-2/3 p-4 bg-white rounded-lg shadow-lg flex justify-center items-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 my-4 w-full">
                <div class="bg-white rounded-lg shadow-lg flex flex-col items-center h-full">
                    <div class="border-b border-gray-300 p-3 text-center bg-blue-400 text-white font-semibold text-xl font-sans min-h-[60px] flex items-center justify-center">JUMLAH KEGIATAN PERIODE INI</div>
                    <div class="p-4 font-medium text-4xl text-center text-black flex-grow flex items-center justify-center">{{$kegiatan->count()}}</div>
                </div>

                <div class="bg-white rounded-lg shadow-lg flex flex-col items-center h-full">
                    <div class="border-b border-gray-300 p-3 text-center bg-blue-400 text-white font-semibold text-xl font-sans min-h-[60px] flex items-center justify-center">JUMLAH SATUAN TUGAS PERIODE INI</div>
                    <div class="p-4 font-medium text-4xl text-center text-black flex-grow flex items-center justify-center">{{$kegiatan->sum('target')}}</div>
                </div>

                <div class="bg-white rounded-lg shadow-lg flex flex-col items-center h-full">
                    <div class="border-b border-gray-300 p-3 text-center bg-blue-400 text-white font-semibold text-xl font-sans min-h-[60px] flex items-center justify-center">JUMLAH SATUAN TUGAS SELESAI</div>
                    <div class="p-4 font-medium text-4xl text-center text-black flex-grow flex items-center justify-center">{{$kegiatan->sum('terlaksana')}}</div>
                </div>

                <div class="bg-white rounded-lg shadow-lg flex flex-col items-center h-full">
                    <div class="border-b border-gray-300 p-3 text-center bg-blue-400 text-white font-semibold text-xl font-sans min-h-[60px] flex items-center justify-center">JUMLAH KEGIATAN BELUM SELESAI</div>
                    <div class="p-4 font-medium text-4xl text-center text-black flex-grow flex items-center justify-center">{{$kegiatan->sum('target') - $kegiatan->sum('terlaksana')}}</div>
                </div>
            </div>
        </div>
    </div>
</div>


@if(auth()->check() && auth()->user() && in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan', 'Ketua Tim']))
<div class="flex gap-4">
    <div class="border border-gray-300 rounded-lg shadow-md p-4 bg-white flex-1">
        <p class="text-2xl font-bold text-green-700 mb-4">DAFTAR KEGIATAN</p>
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left text-lg font-semibold text-black">TUGAS</th>
                    <th class="p-3 text-left text-lg font-semibold text-black">PROGRES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatan as $item)
                <tr class="border-b">
                    <td class="p-3 text-lg text-black">{{$item->nama}}</td>
                    <td class="p-3 text-lg text-black">
                        @php
                        $progress = $item->terlaksana / $item->target * 100;
                        @endphp
                        {{ $progress == floor($progress) ? number_format($progress) : number_format($progress, 2) }}%
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    @if(auth()->check() && auth()->user() && in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan']))
    <div class="border border-gray-300 rounded-lg shadow-md p-4 bg-white flex-3">
        <p class="text-2xl font-bold text-green-700 mb-4">DISTRIBUSI KEGIATAN</p>
        <canvas id="distribusiKegiatanChart"></canvas>
    </div>
    @endif
</div>
@endif

@if(auth()->check() && auth()->user() && in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan']))
<div class="border border-gray-300 rounded-lg shadow-md p-4 my-4 bg-white">
    <p class="text-2xl font-semibold text-green-700 mb-4">BEBAN KERJA ORGANIK</p>
    <canvas id="bebanKerjaChart" width="400" height="200"></canvas>
</div>
@endif


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const semuaButton = document.getElementById('semua');
        const tahunanButton = document.getElementById('tahunan');
        const bulananButton = document.getElementById('bulanan');
        const pilihButton = document.getElementById('pilih');

        const inputTahun = document.getElementById('inputTahun');
        const inputBulan = document.getElementById('inputBulan');
        const datepicker = document.getElementById('datepicker');

        const hiddenTanggalMulai = document.getElementById('hiddenTanggalMulai');
        const hiddenTanggalAkhir = document.getElementById('hiddenTanggalAkhir');

        function hideAllInputs() {
            inputTahun?.classList.add('hidden');
            inputBulan?.classList.add('hidden');
            datepicker?.classList.add('hidden');
        }

        const datepickerInputs = datepicker ? datepicker.querySelectorAll('input') : [];
        datepickerInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (pilihButton?.checked) {
                    debouncedUpdateTanggal('pilih');
                }
            });
        })

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    func.apply(this, args);
                }, wait);
            };
        }

        const debouncedUpdateTanggal = debounce(updateTanggal, 300);

        function updateTanggal(periode) {
            if (!hiddenTanggalMulai || !hiddenTanggalAkhir) {
                console.error('Hidden inputs not found!');
                return;
            }

            let tanggalMulai = '';
            let tanggalAkhir = '';

            if (periode === 'semua') {
                tanggalMulai = '';
                tanggalAkhir = '';
            } else if (periode === 'tahunan') {
                const tahun = document.getElementById('tahun')?.value;
                if (tahun) {
                    tanggalMulai = `${tahun}-01-01`;
                    tanggalAkhir = `${tahun}-12-31`;
                }
            } else if (periode === 'bulanan') {
                const bulan = document.querySelector('#inputBulan input')?.value;
                if (bulan) {
                    const [tahun, bulanNum] = bulan.split('-');
                    tanggalMulai = `${tahun}-${bulanNum}-01`;
                    tanggalAkhir = new Date(tahun, bulanNum, 0)
                        .toISOString()
                        .split('T')[0];
                }
            } else if (periode === 'pilih') {
                tanggalMulai = document.getElementById('tanggal_mulai')?.value;
                tanggalAkhir = document.getElementById('tanggal_akhir')?.value;
            }

            hiddenTanggalMulai.value = tanggalMulai;
            hiddenTanggalAkhir.value = tanggalAkhir;

            triggerFilterBebanKerja();
            triggerFilterKegiatan();
        }

        function triggerFilterBebanKerja() {
            const tanggalMulaiFilter = hiddenTanggalMulai.value;
            updateLocalStorage(tanggalMulaiFilter);
            filterDataAndUpdateChart(tanggalMulaiFilter);
        }

        function triggerFilterKegiatan() {
            const tanggalMulaiFilterKegiatan = hiddenTanggalMulai.value;
            const tanggalAkhirFilterKegiatan = hiddenTanggalAkhir.value;
            updateLocalStorageKegiatan(tanggalMulaiFilterKegiatan, tanggalAkhirFilterKegiatan)
            filterDataAndUpdateChartKegiatan(tanggalMulaiFilterKegiatan, tanggalAkhirFilterKegiatan)
        }

        semuaButton?.addEventListener('change', function() {
            hideAllInputs();
            debouncedUpdateTanggal('semua');
        });

        tahunanButton?.addEventListener('change', function() {
            hideAllInputs();
            inputTahun?.classList.remove('hidden');
            debouncedUpdateTanggal('tahunan');
        });

        bulananButton?.addEventListener('change', function() {
            hideAllInputs();
            inputBulan?.classList.remove('hidden');
            debouncedUpdateTanggal('bulanan');
        });

        pilihButton?.addEventListener('change', function() {
            hideAllInputs();
            datepicker?.classList.remove('hidden');
            debouncedUpdateTanggal('pilih');
        });

        const tahunInput = document.getElementById('tahun');
        if (tahunInput) {
            tahunInput.addEventListener('input', function() {
                if (tahunanButton?.checked) {
                    debouncedUpdateTanggal('tahunan');
                }
            });
        }

        const bulanInput = document.querySelector('#inputBulan input');
        if (bulanInput) {
            bulanInput.addEventListener('input', function() {
                if (bulananButton?.checked) {
                    debouncedUpdateTanggal('bulanan');
                }
            });
        }

        pilihButton?.addEventListener('click', function() {
            debouncedUpdateTanggal('pilih');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rawData = @json($penugasanPegawai ?? []);
        const tanggalMulaiElement = document.getElementById('hiddenTanggalMulai');
        const storedTanggalMulai = localStorage.getItem('tanggalMulai');

        const tanggalMulai = storedTanggalMulai ? new Date(storedTanggalMulai) : (tanggalMulaiElement ? new Date(tanggalMulaiElement.value) : null);
        const validTanggalMulai = (tanggalMulai && !isNaN(tanggalMulai.getTime())) ? tanggalMulai : null;

        function filterDataByDate(rawData, startDate) {
            if (!startDate) return rawData;

            return rawData.filter(item => {
                const createdAt = item.pegawai.created_at ? new Date(item.pegawai.created_at) : null;

                if (createdAt && createdAt >= startDate) {
                    return true;
                }
                return false;
            });
        }

        window.updateLocalStorage = function updateLocalStorage(tanggalMulaiUpdater) {
            if (typeof tanggalMulaiUpdater === 'string') {
                tanggalMulaiUpdater = new Date(tanggalMulaiUpdater);
            }

            if (tanggalMulai instanceof Date) {
                localStorage.setItem('tanggalMulai', tanggalMulaiUpdater);
            } else {
                console.error('Invalid Date object: ', tanggalMulaiUpdater);
            }
        };


        window.filterDataAndUpdateChart = function filterDataAndUpdateChart(tanggalMulai) {
            if (!tanggalMulai && validTanggalMulai) {
                tanggalMulai = validTanggalMulai;
            }
            const filteredData = tanggalMulai ? filterDataByDate(rawData, tanggalMulai) : rawData;

            const labels = filteredData.map(item => item.pegawai?.nama || "Unknown");
            const targets = filteredData.map(item => parseInt(item.jumlah_satuan) || 0);
            const terlaksana = filteredData.map(item => item.jumlah_kegiatan || 0);
            const belumTerlaksana = targets.map((total, index) => Math.max(0, total - terlaksana[index]));

            const ctx = document.getElementById('bebanKerjaChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Terlaksana',
                            data: terlaksana,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Belum Terlaksana',
                            data: belumTerlaksana,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const datasetLabel = context.dataset.label || '';
                                    const value = context.raw || context.parsed.y;
                                    return `${datasetLabel}: ${value}`;
                                },
                                footer: function(context) {
                                    const total = context.reduce((sum, item) => sum + (item.raw || 0), 0);
                                    return `Total: ${total}`;
                                }
                            }
                        },
                        datalabels: {
                            display: true,
                            align: 'center',
                            color: 'black',
                            font: {
                                weight: 'bold',
                                size: 20
                            },
                            formatter: function(value, context) {
                                return value;
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }

        if (validTanggalMulai) {
            localStorage.setItem('tanggalMulai', validTanggalMulai.toISOString());
            filterDataAndUpdateChart(validTanggalMulai);
        } else {
            filterDataAndUpdateChart(null);
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const distribusiKegiatan = @json($distribusiKegiatan ?? []);
        const tanggalMulaiElement = document.getElementById('hiddenTanggalMulai');
        const tanggalAkhirElement = document.getElementById('hiddenTanggalAkhir');

        const storedTanggalMulai = localStorage.getItem('tanggalMulai');
        const storedTanggalAkhir = localStorage.getItem('tanggalAkhir');

        const tanggalMulai = storedTanggalMulai ?
            new Date(storedTanggalMulai) :
            (tanggalMulaiElement ? new Date(tanggalMulaiElement.value) : null);

        const tanggalAkhir = storedTanggalAkhir ?
            new Date(storedTanggalAkhir) :
            (tanggalAkhirElement ? new Date(tanggalAkhirElement.value) : null);

        const validTanggalMulai = tanggalMulai && !isNaN(tanggalMulai.getTime()) ? tanggalMulai : null;
        const validTanggalAkhir = tanggalAkhir && !isNaN(tanggalAkhir.getTime()) ? tanggalAkhir : null;

        function getFilteredData(startDate, endDate) {
            if (!startDate && !endDate) {
                return distribusiKegiatan;
            }

            const start = startDate ? new Date(startDate) : null;
            const end = endDate ? new Date(endDate) : null;

            return distribusiKegiatan.filter(item => {
                const itemDateMulai = item.tanggal_mulai ? new Date(item.tanggal_mulai) : null;
                const itemDateAkhir = item.tanggal_akhir ? new Date(item.tanggal_akhir) : null;

                return (
                    (!start || (itemDateMulai && itemDateMulai >= start)) &&
                    (!end || (itemDateAkhir && itemDateAkhir <= end))
                );
            });
        }

        window.updateLocalStorageKegiatan = function updateLocalStorageKegiatan(startDate, endDate) {
            if (startDate) {
                localStorage.setItem('tanggalMulai', startDate.toISOString());
            } else {
                localStorage.removeItem('tanggalMulai');
            }

            if (endDate) {
                localStorage.setItem('tanggalAkhir', endDate.toISOString());
            } else {
                localStorage.removeItem('tanggalAkhir');
            }
        }

        function renderChart(filteredData) {
            const chartLabels = filteredData.map(item => item.asal_fungsi);
            const chartData = filteredData.map(item => item.persentase);

            const chartContext = document.getElementById('distribusiKegiatanChart').getContext('2d');

            window.distribusiKegiatanChart = new Chart(chartContext, {
                type: 'pie',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Distribusi Kegiatan',
                        data: chartData,
                        backgroundColor: [
                            '#2196f3',
                            '#ff9800',
                            '#4caf50',
                            '#ffeb3b',
                            '#f44336'
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw;
                                    return `${label}: ${value}%`;
                                }
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            display: true,
                            font: {
                                weight: 'bold',
                                size: 16
                            },
                            anchor: 'center',
                            align: 'center',
                            formatter: function(value) {
                                const numericValue = Number(value);
                                return isNaN(numericValue) ? value : numericValue.toFixed(2) + '%';
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }

        window.filterDataAndUpdateChartKegiatan = function filterDataAndUpdateChartKegiatan() {
            const startDate = validTanggalMulai;
            const endDate = validTanggalAkhir;

            const filteredData = getFilteredData(startDate, endDate);
            renderChart(filteredData);
        }

        if (validTanggalMulai || validTanggalAkhir) {
            updateLocalStorageKegiatan(validTanggalMulai, validTanggalAkhir);
            filterDataAndUpdateChartKegiatan();
        } else {
            renderChart(distribusiKegiatan);
        }

        window.applyDateFilterKegiatan = function(startDate, endDate) {
            const validStart = startDate ? new Date(startDate) : null;
            const validEnd = endDate ? new Date(endDate) : null;

            updateLocalStorageKegiatan(validStart, validEnd);
            filterDataAndUpdateChartKegiatan();
        };
    });
</script>



<style>
    #distribusiKegiatanChart {
        width: 300px !important;
        height: 300px !important;
    }
</style>
@endsection