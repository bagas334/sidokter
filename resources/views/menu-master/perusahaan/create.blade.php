@php
    $kbli_options = [
    'A. Pertanian, Kehutanan dan Perikanan',
    'B. Pertambangan dan Penggalian',
    'C. Industri Pengolahan',
    'D. Pengadaan Listrik, Gas, Uap/Air Panas Dan Udara Dingin',
    'E. Treatment Air, Treatment Air Limbah, Treatment dan Pemulihan Material Sampah, dan Aktivitas Remediasi',
    'F. Konstruksi',
    'G. Perdagangan Besar Dan Eceran; Reparasi Dan Perawatan Mobil Dan Sepeda Motor',
    'H. Pengangkutan dan Pergudangan',
    'I. Penyediaan Akomodasi Dan Penyediaan Makan Minum',
    'J. Informasi Dan Komunikasi',
    'K. Aktivitas Keuangan dan Asuransi',
    'L. Real Estat',
    'M. Aktivitas Profesional, Ilmiah Dan Teknis',
    'N. Aktivitas Penyewaan dan Sewa Guna Usaha Tanpa Hak Opsi, Ketenagakerjaan, Agen Perjalanan dan Penunjang Usaha Lainnya',
    'O. Administrasi Pemerintahan, Pertahanan Dan Jaminan Sosial Wajib',
    'P. Pendidikan',
    'Q. Aktivitas Kesehatan Manusia Dan Aktivitas Sosial',
    'R. Kesenian, Hiburan Dan Rekreasi',
    'S. Aktivitas Jasa Lainnya',
    'T. Aktivitas Rumah Tangga Sebagai Pemberi Kerja; Aktivitas Yang Menghasilkan Barang Dan Jasa Oleh Rumah Tangga yang Digunakan untuk Memenuhi Kebutuhan Sendiri',
    'U. Aktivitas Badan Internasional Dan Badan Ekstra Internasional Lainnya'
    ];
@endphp

@extends('components.layout')

@section('title', 'Buat Perusahaan')

@section('content')
    <div class="size-full flex flex-col items-center px-4 py-6">
        <div class="w-full bg-white shadow-lg rounded-lg p-6">
            <div class="w-full pb-6 flex">
                <x-judul text="Buat Perusahaan"/>
            </div>

            <form action="{{ route('perusahaan-create-save') }}" method="POST">
                @csrf
                @method('POST')

                <x-input.text-field
                    :label="'ID SBR'"
                    :name="'idsbr'"
                    required/>

                <x-input.text-field
                    :label="'Nama Perusahaan'"
                    :name="'nama_usaha'"
                    required/>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium flex items-center">
                        Kode KBLI
                        <p class="text-red-600 ml-1">*</p>
                    </label>
                    <select id="kode_kbli" name="kode_kbli"
                            class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        <option value="">-- Pilih Opsi --</option>
                        @foreach ($kbli_options as $option)
                            <option value="{{ substr($option, 0, 1) }}">
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <x-input.text-field
                    :label="'Satuan Lingkungan Setempat (SLS)'"
                    :name="'sls'"/>

                <x-input.text-field
                    :label="'Email'"
                    :name="'email'"/>

                <div class="w-full pb-2 flex flex-col">
                    <label class="text-lg text-cyan-950 font-medium">Alamat</label>
                    <div class="w-full flex space-x-3">
                        <div class="w-full pb-2">
                            <label class="text-md text-cyan-950 font-medium">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan"
                                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                <option value="">-- Pilih Opsi --</option>
                            </select>
                        </div>

                        <div class="w-full pb-2">
                            <label class="text-md text-cyan-950 font-medium">Kelurahan</label>
                            <select id="kelurahan" name="kelurahan"
                                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                <option value="">-- Pilih Opsi --</option>
                            </select>
                        </div>
                    </div>
                    <x-input.text-area
                        :label="'Detail'"
                        :name="'alamat_detail'"
                        required
                    />
                </div>

                <x-input.double-input-layout
                    :label="'Contact Person'"
                    :name="'contact_person'">
                    <x-input.text-field
                        :label="'Nama'"
                        :name="'nama_cp'"
                        :label_size="'md'"/>
                    <x-input.text-field
                        :label="'Telepon'"
                        :name="'nomor_cp'"
                        :label_size="'md'"/>
                </x-input.double-input-layout>

                <div class="w-full flex justify-end pt-4">
                    <x-submit-button>
                        Buat Perusahaan
                    </x-submit-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const wilayah = @json($wilayah);

        function populateKecamatanOptions() {
            const kecamatanSelect = document.getElementById('kecamatan');
            kecamatanSelect.innerHTML = '<option value="">-- Pilih Opsi --</option>';

            for (const kecamatan in wilayah) {
                const optionElement = document.createElement('option');
                optionElement.value = kecamatan;
                optionElement.textContent = kecamatan;


                kecamatanSelect.appendChild(optionElement);
            }
        }

        function populateKelurahanOptions(kecamatan) {
            const kelurahanSelect = document.getElementById('kelurahan');
            kelurahanSelect.innerHTML = '<option value="">-- Pilih Opsi --</option>';

            if (wilayah[kecamatan]) {
                wilayah[kecamatan].forEach(function(kelurahan) {
                    const optionElement = document.createElement('option');
                    optionElement.value = kelurahan;
                    optionElement.textContent = kelurahan;

                    kelurahanSelect.appendChild(optionElement);
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            populateKecamatanOptions();

            document.getElementById('kecamatan').addEventListener('change', function() {
                const selectedKecamatan = this.value;
                populateKelurahanOptions(selectedKecamatan);
            });
        });
    </script>
@endsection
