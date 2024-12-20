@php
$options = [
];

$current_golongan = old('golongan', $pegawai->golongan);
$current_status = old('status', $pegawai->status);
@endphp

@extends('components.layout')

@section('title', 'Edit Organik')

@section('content')
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Edit Organik" />
        </div>

        <form action="{{ route('master-organik-edit-save', $pegawai->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">Nama Pegawai</label>
                <input type="text" id="nama" name="nama" value="{{ $pegawai->nama }}"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">Alias</label>
                <input type="text" id="alias" name="alias" value="{{ $pegawai->alias }}"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">NIP</label>
                <input type="text" id="nip" name="nip" value="{{ $pegawai->nip }}"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">NIP BPS</label>
                <input type="text" id="nip_bps" name="nip_bps" value="{{ $pegawai->nip_bps }}"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">Jabatan</label>
                <select id="status" name="jabatan"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    <option value="">-- Pilih Opsi --</option>
                    <option value="Admin Kabupaten" {{ $current_status == 'Admin Kabupaten' ? 'selected' : '' }}>Admin Kabupaten</option>
                    <option value="Pimpinan" {{ $current_status == 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                    <option value="Organik" {{ $current_status == 'Organik' ? 'selected' : '' }}>Organik</option>
                    <option value="Ketua Tim" {{ $current_status == 'Ketua Tim' ? 'selected' : '' }}>Ketua Tim</option>
                </select>
            </div>

            <!-- <script>
                const options = @json($options);
                const currentGolongan = @json($current_golongan);
                const currentStatus = @json($current_status);

                function populateGolonganOptions(status) {
                    const golonganSelect = document.getElementById('golongan');

                    golonganSelect.innerHTML = '<option value="">-- Pilih Opsi --</option>';

                    if (options[status]) {
                        options[status].forEach(function(golongan) {
                            const optionElement = document.createElement('option');
                            optionElement.value = golongan;
                            optionElement.textContent = golongan;

                            if (golongan === currentGolongan) {
                                optionElement.selected = true;
                            }

                            golonganSelect.appendChild(optionElement);
                        });
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {
                    if (currentStatus) {
                        document.getElementById('status').value = currentStatus;
                        populateGolonganOptions(currentStatus);
                    }
                });

                document.getElementById('status').addEventListener('change', function() {
                    const selectedStatus = this.value;
                    populateGolonganOptions(selectedStatus);
                });
            </script> -->

            <div class="w-full flex justify-end pt-4">
                <x-submit-button>
                    Simpan Perubahan
                </x-submit-button>
            </div>
        </form>
    </div>
</div>
@endsection