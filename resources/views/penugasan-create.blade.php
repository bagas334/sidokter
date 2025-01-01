@extends('components.layout')

@section('title', 'Buat Penugasan Organik')

@section('content')
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Buat Penugasan" />
        </div>

        <form id="form" action="{{route('beban-kerja-save')}}" method="POST">
            @csrf
            @method('POST')

            <x-input.text-field
                :label="'Nama Kegiatan'"
                :name="'nama'"
                required></x-input.text-field>
            <div class="hidden text-sm" id="namaKegiatanError"></div>

            @if(auth()->check() && in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan']))
            <x-input.dropdown-single
                :label="'Asal Fungsi'"
                :name="'asal_fungsi'"
                :value="''"
                :options="$fungsi">
            </x-input.dropdown-single>
            @else
            <x-input.dropdown-single
                :label="'Asal Fungsi'"
                :name="'asal_fungsi'"
                :value="auth()->user()->fungsi_ketua_tim"
                :options="$fungsi" hidden>
            </x-input.dropdown-single>
            @endif
            <p class="hidden text-sm" id="asalFungsiError"></p>

            <x-input.double-input-layout
                :label="'Kuantitas'"
                :name="'kuantitas'">
                <div>
                    <x-input.number-field
                        :label="'Jumlah satuan'"
                        :name="'target'"
                        :label_size="'md'"></x-input.number-field>
                    <div class="hidden text-sm" id="targetError"></div>
                </div>
                <div>
                    <x-input.number-field
                        :label="'Harga satuan'"
                        :name="'harga_satuan'"
                        :label_size="'md'"></x-input.number-field>
                    <div class="hidden text-sm" id="hargaSatuanError"></div>
                </div>
            </x-input.double-input-layout>

            <x-input.double-input-layout
                :label="'Tanggal'"
                :name="'kuantitas'">
                <x-input.datepicker
                    :label="'Tanggal Mulai'"
                    :name="'tanggal_mulai'"
                    :label_size="'md'">
                </x-input.datepicker>
                <x-input.datepicker
                    :label="'Deadline'"
                    :name="'tanggal_akhir'"
                    :label_size="'md'">
                </x-input.datepicker>
            </x-input.double-input-layout>
            <div class="hidden text-sm" id="tanggalError"></div>
            <x-input.text-field
                :label="'Satuan'"
                :value="'Unit'"
                :name="'satuan'"></x-input.text-field>
            <p class="hidden text-sm" id="satuanError"></p>


            <x-input.text-area
                :label="'Catatan'"
                :name="'catatan'"></x-input.text-area>
            <p class="hidden text-sm" id="catatanError"></p>

            <div class="w-full flex justify-end pt-4">
                <x-submit-button>
                    Buat Penugasan
                </x-submit-button>
            </div>
        </form>
    </div>
</div>

<script>
    let tanggalMulaiField = document.getElementById('tanggal_mulai');
    let tanggalAkhirField = document.getElementById('tanggal_akhir');
    let tanggalError = document.getElementById('tanggalError');

    let tanggalMulai = new Date(tanggalMulaiField.value.trim());
    let tanggalAkhir = new Date(tanggalAkhirField.value.trim());

    document.getElementById('form').addEventListener('submit', (e) => {
        let errors = [];
        let validNamaRegex = /^[a-zA-Z0-9 ]+$/;
        let validNumberRegex = /^[0-9]+$/;

        // Validasi Kegiatan
        let kegiatanField = document.getElementById('nama');
        let namaKegiatanError = document.getElementById('namaKegiatanError');

        if (!kegiatanField.value.trim()) {
            errors.push('Nama kegiatan harus diisi.');
            namaKegiatanError.textContent = 'Nama kegiatan harus diisi.';
            namaKegiatanError.classList.remove('hidden');
            namaKegiatanError.classList.add('text-red-500');
        } else if (!validNamaRegex.test(kegiatanField.value.trim())) {
            errors.push('Nama kegiatan mengandung karakter tidak valid.');
            namaKegiatanError.textContent = 'Nama kegiatan mengandung karakter tidak valid.';
            namaKegiatanError.classList.remove('hidden');
            namaKegiatanError.classList.add('text-red-500');
        } else {
            namaKegiatanError.classList.add('hidden');
            namaKegiatanError.textContent = '';
        }

        // Validasi catatan
        let catatanField = document.getElementById('catatan');
        let catatanError = document.getElementById('catatanError');

        if (catatanField.value.trim()) {
            if (!validNamaRegex.test(catatanField.value.trim())) {
                errors.push('Catatan mengandung karakter tidak valid');
                catatanError.textContent = 'Field catatan mengandung karakter tidak valid.';
                catatanError.classList.remove('hidden');
                catatanError.classList.add('text-red-500');
            } else {
                catatanError.classList.add('hidden');
                catatanError.textContent = '';
            }
        }

        // Validasi Satuan
        let satuanField = document.getElementById('satuan');
        let satuanError = document.getElementById('satuanError');
        if (!satuanField.value.trim()) {
            errors.push('Nama kegiatan harus diisi.');
            satuanError.textContent = 'Field satuan harus diisi.';
            satuanError.classList.remove('hidden');
            satuanError.classList.add('text-red-500');
        } else if (!validNamaRegex.test(satuanField.value.trim())) {
            errors.push('Nama kegiatan mengandung karakter tidak valid.');
            satuanError.textContent = 'Field satuan mengandung karakter tidak valid.';
            satuanError.classList.remove('hidden');
            satuanError.classList.add('text-red-500');
        } else {
            satuanError.classList.add('hidden');
            satuanError.textContent = '';
        }

        // Validasi asal fungsi Field
        let asalFungsiField = document.getElementById('asal_fungsi');
        let asalFungsiError = document.getElementById('asalFungsiError');

        if (!asalFungsiField.value.trim()) {
            errors.push('Asal fungsi harus diisi.');
            asalFungsiError.textContent = 'Asal fungsi harus diisi.';
            asalFungsiError.classList.remove('hidden');
            asalFungsiError.classList.add('text-red-500');
        } else {
            namaKegiatanError.classList.add('hidden');
            namaKegiatanError.textContent = '';
        }


        // Validasi Target Field
        let targetField = document.getElementById('target');
        let targetError = document.getElementById('targetError');

        if (!targetField.value.trim()) {
            errors.push('Jumlah satuan harus diisi.');
            targetError.textContent = 'Jumlah satuan harus diisi.';
            targetError.classList.remove('hidden');
            targetError.classList.add('text-red-500');
        } else if (!validNumberRegex.test(targetField.value.trim())) {
            errors.push('Jumlah satuan harus berupa angka.');
            targetError.textContent = 'Jumlah satuan harus berupa angka.';
            targetError.classList.remove('hidden');
            targetError.classList.add('text-red-500');
        } else {
            targetError.classList.add('hidden');
            targetError.textContent = '';
        }

        // Validasi Harga Satuan Field
        let hargaSatuanField = document.getElementById('harga_satuan');
        let hargaSatuanError = document.getElementById('hargaSatuanError');

        if (!hargaSatuanField.value.trim()) {
            errors.push('Harga satuan harus diisi.');
            hargaSatuanError.textContent = 'Harga satuan harus diisi.';
            hargaSatuanError.classList.remove('hidden');
            hargaSatuanError.classList.add('text-red-500');
        } else if (!validNumberRegex.test(hargaSatuanField.value.trim())) {
            errors.push('Harga satuan harus berupa angka.');
            hargaSatuanError.textContent = 'Harga satuan harus berupa angka.';
            hargaSatuanError.classList.remove('hidden');
            hargaSatuanError.classList.add('text-red-500');
        } else {
            hargaSatuanError.classList.add('hidden');
            hargaSatuanError.textContent = '';
        }

        // Validasi Tanggal
        let tanggalMulaiField = document.getElementById('tanggal_mulai');
        let tanggalAkhirField = document.getElementById('tanggal_akhir');
        let tanggalError = document.getElementById('tanggalError');

        let tanggalMulai, tanggalAkhir;

        try {
            tanggalMulai = parseDate(tanggalMulaiField.value.trim());
            tanggalAkhir = parseDate(tanggalAkhirField.value.trim());
        } catch {
            errors.push('Format tanggal tidak valid. Gunakan format DD-MM-YYYY.');
            tanggalError.textContent = 'Format tanggal tidak valid. Gunakan format DD-MM-YYYY.';
            tanggalError.classList.remove('hidden');
            tanggalError.classList.add('text-red-500');
        }

        if (!tanggalMulaiField.value.trim() || !tanggalAkhirField.value.trim()) {
            errors.push('Kedua tanggal harus diisi.');
            tanggalError.textContent = 'Kedua tanggal harus diisi.';
            tanggalError.classList.remove('hidden');
            tanggalError.classList.add('text-red-500');
        } else if (tanggalMulai && tanggalAkhir && tanggalMulai > tanggalAkhir) {
            errors.push('Deadline lebih awal dari tanggal mulai.');
            tanggalError.textContent = 'Deadline lebih awal dari tanggal mulai.';
            tanggalError.classList.remove('hidden');
            tanggalError.classList.add('text-red-500');
        } else {
            tanggalError.classList.add('hidden');
            tanggalError.textContent = '';
        }

        // Fungsi untuk parsing tanggal DD-MM-YYYY
        function parseDate(ddmmyyyy) {
            const [day, month, year] = ddmmyyyy.split('-').map(Number);
            if (
                isNaN(day) || isNaN(month) || isNaN(year) ||
                day < 1 || day > 31 ||
                month < 1 || month > 12
            ) {
                throw new Error('Invalid date');
            }
            return new Date(year, month - 1, day); // Bulan di JavaScript dimulai dari 0
        }

        // Jika ada error, hentikan pengiriman form
        if (errors.length > 0) {
            e.preventDefault();
        }
    });
</script>
@endsection