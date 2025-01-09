@extends('components.layout')

@section('title', 'Dashboard')

@section('content')

<head>
    <!-- Add this in the <head> section of your HTML to use the Inter font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<div>
    <div class="bg-green-50 text-green-900 p-6 rounded-lg shadow-md border border-green-200">
        <p class="text-3xl font-semibold font-sans">Selamat Datang, {{auth()->user()->nama}}!</p>
    </div>
    <div class="bg-gray-50 p-4 rounded-lg shadow-md border border-gray-200">
        <form action="" method="GET" class="space-y-3">
            <p class="text-2xl font-semibold text-gray-800 hover:text-teal-600 transition-colors duration-300 font-sans">Pilih Periode:</p>
            <div class="flex gap-4 justify-between">
                <label class="w-full">
                    <input type="radio" name="periode" id="semua" value="semua" checked class="hidden" onchange="this.form.submit();">
                    <div class="w-full py-5 text-center bg-gray-200 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-300 focus:outline-none text-xl font-medium tracking-wide">
                        SEMUA
                    </div>
                </label>

                <label class="w-full">
                    <input type="radio" name="periode" id="tahunan" value="tahunan" class="hidden">
                    <div class="w-full py-5 text-center bg-gray-200 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-300 focus:outline-none text-xl font-medium tracking-wide">
                        TAHUNAN
                    </div>
                </label>

                <label class="w-full">
                    <input type="radio" name="periode" id="bulanan" value="bulanan" class="hidden">
                    <div class="w-full py-5 text-center bg-gray-200 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-300 focus:outline-none text-xl font-medium tracking-wide">
                        BULANAN
                    </div>
                </label>

                <label class="w-full">
                    <input type="radio" name="periode" id="pilih" value="pilih" class="hidden">
                    <div class="w-full py-5 text-center bg-gray-200 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-300 focus:outline-none text-xl font-medium tracking-wide">
                        PILIH
                    </div>
                </label>
            </div>

            <div class="space-y-3">
                <div id="inputTahun" class="hidden text-center mx-auto w-1/2">
                    <label for="tahun" class="text-gray-600 text-sm font-medium">Pilih Tahun:</label>
                    <input type="number" id="tahun" name="tahun" min="2020" max="2025" placeholder="YYYY"
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
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 my-4">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="border-b border-gray-300 p-3 text-center bg-blue-400 text-white font-semibold text-lg font-sans">JUMLAH KEGIATAN</div>
            <div class="p-4 font-medium text-4xl text-center text-black">{{$kegiatan->count()}}</div>
        </div>

        <div class="bg-white rounded-lg shadow-lg">
            <div class="border-b border-gray-300 p-3 text-center bg-blue-400 text-white font-semibold text-lg font-sans">JUMLAH SATUAN TUGAS</div>
            <div class="p-4 font-medium text-4xl text-center text-black">{{$kegiatan->sum('target')}}</div>
        </div>

        <div class="bg-white rounded-lg shadow-lg">
            <div class="border-b border-gray-300 p-3 text-center bg-blue-400 text-white font-semibold text-lg font-sans">JUMLAH SATUAN TUGAS SELESAI</div>
            <div class="p-4 font-medium text-4xl text-center text-black">{{$kegiatan->sum('terlaksana')}}</div>
        </div>

        <div class="bg-white rounded-lg shadow-lg">
            <div class="border-b border-gray-300 p-3 text-center bg-blue-400 text-white font-semibold text-lg font-sans">JUMLAH KEGIATAN BELUM SELESAI</div>
            <div class="p-4 font-medium text-4xl text-center text-black">{{$kegiatan->sum('target') - $kegiatan->sum('terlaksana')}}</div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="border border-gray-300 rounded-lg shadow-md p-4 bg-white">
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

        <div class="border border-gray-300 rounded-lg shadow-md p-4 bg-white">
            <p class="text-2xl font-bold text-green-700 mb-4">DISTRIBUSI KEGIATAN</p>
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-3 text-left text-lg font-semibold text-black">ASAL FUNGSI</th>
                        <th class="p-3 text-left text-lg font-semibold text-black">PERSENTASE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($distribusiKegiatan as $item)
                    <tr class="border-b">
                        <td class="p-3 text-lg text-black">{{ $item->asal_fungsi }}</td>
                        <td class="p-3 text-lg text-black">
                            @php
                            $percentage = $item->persentase;
                            @endphp
                            {{ $percentage == floor($percentage) ? number_format($percentage) : number_format($percentage, 2) }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="border border-gray-300 rounded-lg shadow-md p-4 my-4 bg-white">
        <p class="text-2xl font-semibold text-green-700 mb-4">BEBAN KERJA ORGANIK</p>
        <p class="text-lg font-medium text-gray-800 mb-4">GRAFIK</p>
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-green-100">
                    <th class="p-4 text-left text-lg font-semibold text-gray-700">NAMA ORGANIK</th>
                    <th class="p-4 text-left text-lg font-semibold text-gray-700">JUMLAH KEGIATAN TERLIBAT</th>
                    <th class="p-4 text-left text-lg font-semibold text-gray-700">JUMLAH SATUAN TERLIBAT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penugasanPegawai as $item)
                <tr class="border-b even:bg-gray-50">
                    <td class="p-4 text-lg text-black">{{$item->pegawai->nama}}</td>
                    <td class="p-4 text-lg text-black">{{$item->jumlah_kegiatan}}</td>
                    <td class="p-4 text-lg text-black">{{$item->jumlah_satuan}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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
                inputTahun.classList.add('hidden');
                inputBulan.classList.add('hidden');
                datepicker.classList.add('hidden');
            }

            function updateTanggal(periode) {
                const today = new Date();
                let tanggalMulai = '';
                let tanggalAkhir = '';

                if (periode === 'semua') {
                    // Set tanggal mulai dan akhir untuk semua (kosongkan, kirim tanpa nilai)
                    tanggalMulai = '';
                    tanggalAkhir = '';
                } else if (periode === 'tahunan') {
                    const tahun = document.querySelector('#inputTahun input').value;
                    if (tahun) {
                        tanggalMulai = `${tahun}-01-01`;
                        tanggalAkhir = `${tahun}-12-31`;
                    }
                } else if (periode === 'bulanan') {
                    const bulan = document.querySelector('#inputBulan input').value;
                    if (bulan) {
                        const [tahun, bulanNum] = bulan.split('-');
                        tanggalMulai = `${tahun}-${bulanNum}-01`;
                        tanggalAkhir = new Date(tahun, bulanNum, 0) // Hari terakhir di bulan
                            .toISOString()
                            .split('T')[0];
                    }
                } else if (periode === 'pilih') {
                    tanggalMulai = document.getElementById('tanggal_mulai').value;
                    tanggalAkhir = document.getElementById('tanggal_akhir').value;
                }

                // Update hidden inputs
                hiddenTanggalMulai.value = tanggalMulai;
                hiddenTanggalAkhir.value = tanggalAkhir;
            }

            semuaButton.addEventListener('change', function() {
                hideAllInputs();
                updateTanggal('semua');
            });

            tahunanButton.addEventListener('change', function() {
                hideAllInputs();
                inputTahun.classList.remove('hidden');
                updateTanggal('tahunan');
            });

            bulananButton.addEventListener('change', function() {
                hideAllInputs();
                inputBulan.classList.remove('hidden');
                updateTanggal('bulanan');
            });

            pilihButton.addEventListener('change', function() {
                hideAllInputs();
                datepicker.classList.remove('hidden');
                updateTanggal('pilih');
            });

            // Update tanggal secara otomatis jika input tahun/bulan berubah
            document.querySelector('#inputTahun input').addEventListener('input', function() {
                updateTanggal('tahunan');
            });

            document.querySelector('#inputBulan input').addEventListener('input', function() {
                updateTanggal('bulanan');
            });
        });
    </script>
    @endsection