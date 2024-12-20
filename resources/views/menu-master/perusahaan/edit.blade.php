@php
    $current_kecamatan = old('kecamatan', $perusahaan->kecamatan);
    $current_kelurahan = old('kelurahan', $perusahaan->kelurahan);

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

@section('title', 'Edit Perusahaan')

@section('content')
    <div class="size-full flex flex-col items-center px-4 py-6">
        <div class="w-full bg-white shadow-lg rounded-lg p-6">
            <div class="w-full pb-6 flex">
                <x-judul text="Edit Perusahaan"/>
            </div>

            <form action="{{ route('master-perusahaan-edit-save', $perusahaan->id) }}" method="POST">
                @csrf
                @method('PUT')


                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Nama Perusahaan</label>
                    <input type="text" id="nama_usaha" name="nama_usaha" value="{{ $perusahaan->nama_usaha }}"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Kode KBLI</label>
                    <select id="kode_kbli" name="kode_kbli"
                            class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        <option value="">-- Pilih Opsi --</option>
                        @foreach ($kbli_options as $option)
                            <option value="{{ substr($option, 0, 1) }}" {{ substr($option, 0, 1) == $perusahaan->kode_kbli ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Satuan Lingkungan Setempat (SLS)</label>
                    <input type="text" id="sls" name="sls" value="{{ $perusahaan->sls }}"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Email</label>
                    <input type="text" id="email" name="email" value="{{ $perusahaan->email }}"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>

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
                    <div class="w-full pb-2">
                        <label class="text-md text-cyan-950 font-medium">Detail</label>
                        <textarea id="alamat_detail" rows="4" name="alamat_detail"
                                  class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm resize-none overflow-auto">{{$perusahaan->alamat_detail}}</textarea>
                    </div>
                </div>

                <script>
                    const wilayah = @json($wilayah);
                    const currentKecamatan = @json($current_kecamatan);
                    const currentKelurahan = @json($current_kelurahan);

                    function populateKecamatanOptions() {
                        const kecamatanSelect = document.getElementById('kecamatan');
                        kecamatanSelect.innerHTML = '<option value="">-- Pilih Opsi --</option>';

                        for (const kecamatan in wilayah) {
                            const optionElement = document.createElement('option');
                            optionElement.value = kecamatan;
                            optionElement.textContent = kecamatan;

                            if (kecamatan === currentKecamatan) {
                                optionElement.selected = true;
                            }

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

                                if (kelurahan === currentKelurahan) {
                                    optionElement.selected = true;
                                }

                                kelurahanSelect.appendChild(optionElement);
                            });
                        }
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        populateKecamatanOptions();

                        if (currentKecamatan) {
                            populateKelurahanOptions(currentKecamatan);
                        }

                        document.getElementById('kecamatan').addEventListener('change', function() {
                            const selectedKecamatan = this.value;
                            populateKelurahanOptions(selectedKecamatan);
                        });
                    });
                </script>

                <div class="w-full pb-2 flex flex-col">
                    <label class="text-lg text-cyan-950 font-medium">Contact Person</label>
                    <div class="w-full flex space-x-3">
                        <div class="w-full pb-2">
                            <label class="text-md text-cyan-950 font-medium">Nama</label>
                            <input type="text" id="nama_cp" name="nama_cp" value="{{ $perusahaan->nama_cp }}"
                                   class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        </div>

                        <div class="w-full pb-2">
                            <label class="text-md text-cyan-950 font-medium">Telepon</label>
                            <input type="text" id="nomor_cp" name="nomor_cp" value="{{ $perusahaan->nomor_cp }}"
                                   class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <div class="w-full flex justify-end pt-4">
                    <x-submit-button>
                        Simpan Perubahan
                    </x-submit-button>
                </div>
            </form>
        </div>
    </div>
@endsection
