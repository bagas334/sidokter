@php
    $current_jk = old('jenis_kelamin', $mitra->jenis_kelamin);
    $current_kecamatan = old('kecamatan', $mitra->kecamatan);
    $current_kelurahan = old('kelurahan', $mitra->kelurahan);

    $posisi_options = [
        'pendataan' => 'Pendataan',
        'pengolahan' => 'Pengolahan'
    ];
    $current_posisi = old('posisi', $mitra->posisi);
    $current_fungsi = old('fungsi', $mitra->fungsi);
@endphp

@extends('components.layout')

@section('title', 'Edit Mitra')

@section('content')
    <div class="size-full flex flex-col items-center px-4 py-6">
        <div class="w-full bg-white shadow-lg rounded-lg p-6">
            <div class="w-full pb-6 flex">
                <x-judul text="Edit Mitra"/>
            </div>

            <form action="{{ route('master-mitra-edit-save', $mitra->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Nama Mitra</label>
                    <input type="text" id="nama" name="nama" value="{{ $mitra->nama }}"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Sobat ID</label>
                    <input type="text" id="sobat_id" name="sobat_id" value="{{ $mitra->sobat_id }}"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin"
                            class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        <option value="">-- Pilih Opsi --</option>
                        <option value="laki-laki" {{ $mitra->jenis_kelamin === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ $mitra->jenis_kelamin === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Email</label>
                    <input type="text" id="email" name="email" value="{{ $mitra->email }}"
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
                              class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm resize-none overflow-auto">{{$mitra->alamat_detail}}</textarea>
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

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Posisi:</label>
                    <div class="mt-2 space-y-2 ml-2 flex flex-col">
                        @foreach ($posisi_options as $value => $label)
                            <div class="flex items-center ml-1">
                                <input type="checkbox" id="posisi_{{ $value }}" name="posisi[]"
                                       value="{{ $value }}"
                                       {{ in_array($value, $current_posisi) ? 'checked' : '' }}
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
                        <option value="Subbag Umum" {{ $current_fungsi == 'Subbag Umum' ? 'selected' : '' }}>Subbag Umum</option>
                        <option value="Statistik Produksi" {{ $current_fungsi == 'Statistik Produksi' ? 'selected' : '' }}>Statistik Produksi</option>
                        <option value="Statistik Distribusi" {{ $current_fungsi == 'Statistik Distribusi' ? 'selected' : '' }}>Statistik Distribusi</option>
                        <option value="Nerwilis" {{ $current_fungsi == 'Nerwilis' ? 'selected' : '' }}>Nerwilis</option>
                        <option value="IPDS" {{ $current_fungsi == 'IPDS' ? 'selected' : '' }}>IPDS</option>
                        <option value="Statistik Sosial" {{ $current_fungsi == 'Statistik Sosial' ? 'selected' : '' }}>Statistik Sosial</option>
                    </select>
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
