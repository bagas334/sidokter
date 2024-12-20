@php
    $posisi_options = [
        'pendataan' => 'Pendataan',
        'pengolahan' => 'Pengolahan'
    ];
@endphp

@extends('components.layout')

@section('title', 'Buat Mitra')

@section('content')
    <div class="size-full flex flex-col items-center px-4 py-6">
        <div class="w-full bg-white shadow-lg rounded-lg p-6">
            <div class="w-full pb-6 flex">
                <x-judul text="Buat Mitra"/>
            </div>

            <form action="{{ route('master-mitra-create-save') }}" method="POST">
                @csrf
                @method('POST')

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Nama Mitra</label>
                    <input type="text" id="nama" name="nama"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Sobat ID</label>
                    <input type="text" id="sobat_id" name="sobat_id"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin"
                            class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        <option value="">-- Pilih Opsi --</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Email</label>
                    <input type="text" id="email" name="email"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>

                <div class="w-full pb-2 flex space-x-3">
                    <div class="w-full pb-2">
                        <label class="text-lg text-cyan-950 font-medium">Kecamatan</label>
                        <select id="kecamatan" name="kecamatan"
                                class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                            <option value="">-- Pilih Opsi --</option>
                        </select>
                    </div>

                    <div class="w-full pb-2">
                        <label class="text-lg text-cyan-950 font-medium">Kelurahan</label>
                        <select id="kelurahan" name="kelurahan"
                                class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                            <option value="">-- Pilih Opsi --</option>
                        </select>
                    </div>
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Alamat Detail</label>
                    <textarea id="alamat_detail" rows="4" name="alamat_detail"
                              class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm resize-none overflow-auto"></textarea>
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

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Posisi:</label>
                    <div class="mt-2 space-y-2 ml-2 flex flex-col">
                        @foreach ($posisi_options as $value => $label)
                            <div class="flex items-center ml-1">
                                <input type="checkbox" id="posisi_{{ $value }}" name="posisi[]"
                                       value="{{ $value }}"
                                       class="h-4 w-4 text-teal-600 border-gray-300 rounded bg-gray-100 focus:ring-teal-500 focus:border-teal-500">
                                <label for="posisi_{{ $value }}" class="ml-2 block text-sm text-gray-600">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Asal Fungsi:</label>
                    <select id="fungsi" name="fungsi"
                            class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        <option value="">-- Pilih Opsi --</option>
                        <option value="Subbag Umum">Subbag Umum</option>
                        <option value="Statistik Produksi">Statistik Produksi</option>
                        <option value="Statistik Distribusi">Statistik Distribusi</option>
                        <option value="Nerwilis">Nerwilis</option>
                        <option value="IPDS">IPDS</option>
                        <option value="Statistik Sosial">Statistik Sosial</option>
                    </select>
                </div>

                <div class="w-full flex justify-end pt-4">
                    <x-submit-button>
                        Buat Mitra
                    </x-submit-button>
                </div>
            </form>
        </div>
    </div>
@endsection
