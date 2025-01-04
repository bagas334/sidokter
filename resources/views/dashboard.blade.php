@extends('components.layout')

@section('title', 'Dashboard')

@section('content')
<div>
    <div>
        <p class="text-2xl font-bold">Selamat Datang {{auth()->user()->nama}}!</p>
    </div>
    <div>
        <p>Pilih periode :</p>
        <form action="" method="GET">
            <label for="semua">Semua</label>
            <input type="radio" name="periode" id="semua" value="semua" checked>

            <label for="tahunan">Tahunan</label>
            <input type="radio" name="periode" id="tahunan" value="tahunan">
            <div class="hidden" id="inputTahun">
                <label for="tahun">Pilih Tahun:</label>
                <input type="number" id="tahun" name="tahun" min="2020" max="2025" placeholder="YYYY">
            </div>

            <label for="bulanan">Bulanan</label>
            <input type="radio" name="periode" id="bulanan" value="bulanan">
            <div class="hidden" id="inputBulan">
                <label for="bulan">Pilih Bulan:</label>
                <input type="month" id="bulan" name="bulan">
            </div>

            <label for="pilih">Pilih</label>
            <input type="radio" name="periode" id="pilih" value="pilih">
            <div id="datepicker" class="hidden">
                <label for="tanggal_mulai">Tanggal Mulai:</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai">
                <label for="tanggal_akhir">Tanggal Akhir:</label>
                <input type="date" id="tanggal_akhir" name="tanggal_akhir">
            </div>

            <input type="hidden" id="hiddenTanggalMulai" name="tanggal_mulai">
            <input type="hidden" id="hiddenTanggalAkhir" name="tanggal_akhir">
            <input type="submit" value="[KIRIM]">
        </form>

    </div>
    <div class="grid grid-cols-4 gap-2 my-2">
        <div class="border border-black p-2">
            <div class="border border-black p-2">Jumlah kegiatan periode ini</div>
            <div class="border border-black p-2">{{$kegiatan->count()}}</div>
        </div>
        <div class="border border-black p-2">
            <div class="border border-black p-2">Jumlah satuan tugas periode ini</div>
            <div class="border border-black p-2">{{$kegiatan->sum('target')}}</div>
        </div>
        <div class="border border-black p-2">
            <div class="border border-black p-2">Jumlah satuan tugas selesai periode ini</div>
            <div class="border border-black p-2">{{$kegiatan->sum('terlaksana')}}</div>
        </div>
        <div class="border border-black p-2">
            <div class="border border-black p-2">Jumlah kegiatan belum selesai periode ini</div>
            <div class="border border-black p-2">{{$kegiatan->sum('target')-$kegiatan->sum('terlaksana')}}</div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-2">
        <div class="border border-black p-1">
            <p class="text-xl font-bold text-green-500">Daftar Kegiatan</p>
            <table class="border border-black">
                <tr>
                    <th>Tugas</th>
                    <th>Progres</th>
                </tr>
                @foreach($kegiatan as $item)
                <tr>
                    <td>{{$item->nama}}</td>
                    <td>{{$item->terlaksana/$item->target*100}}%</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="border border-black p-1">
            <p class="text-xl font-bold text-green-500">Distribusi kegiatan</p>
            <table class="border border-black">
                <tr>
                    <th>Asal fungsi</th>
                    <th>Persentase</th>
                </tr>
                @foreach ($distribusiKegiatan as $item)
                <tr>
                    <td>{{ $item->asal_fungsi }}</td>
                    <td>{{ number_format($item->persentase, 2) }}%</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="border border-black p-1 my-2">
        <p class="text-black font-bold text-2xl">Beban Kerja Organik</p>
        <p>GRAFIKKK</p>
        <table>
            <tr>
                <th>Nama organik</th>
                <th>Jumlah kegiatan terlibat</th>
                <th>Jumlah satuan terlibat</th>
            </tr>
            @foreach ($penugasanPegawai as $item)
            <tr>
                <td>{{$item->pegawai->nama}}</td>
                <td>{{$item->jumlah_kegiatan}}</td>
                <td>{{$item->jumlah_satuan}}</td>
            </tr>
            @endforeach
        </table>
    </div>
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