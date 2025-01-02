@extends('components.layout')

@section('title', 'Buat Penugasan Organik')

@section('content')
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Tambah Organik" />
        </div>

        <form id="form" action="{{ route('penugasan-organik-create-save',['id'=>$id]) }}" method="POST">
            @csrf
            @method('POST')

            <input type="text" name="kegiatan_id" value="{{$id}}" hidden>

            <x-input.dropdown
                :label="'Organik'"
                :options="$pilihan_pegawai"
                :name="'petugas'"
                required></x-input.dropdown>
            <p class="hidden text-sm" id="petugasError"></p>


            <x-input.text-field
                :label="'Jabatan Penugasan'"
                :name="'jabatan'"
                required></x-input.text-field>
            <p class="hidden text-sm" id="jabatanError"></p>

            <input type="text" value="Ditugaskan" name="status" hidden>

            <x-input.double-input-layout
                :label="'Kuantitas'"
                :name="'kuantitas'">
                <x-input.number-field
                    :label="'Jumlah satuan'"
                    :name="'target'"
                    :label_size="'md'"></x-input.number-field>
            </x-input.double-input-layout>
            <p class="hidden text-sm" id="targetError"></p>


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
    let form = document.getElementById('form');
    form.addEventListener('submit', (e) => {
        let errors = [];
        let validNamaRegex = /^[a-zA-Z0-9 ]+$/;
        let validNumberRegex = /^[0-9]+$/;

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

        let jabatanField = document.getElementById('jabatan');
        let jabatanError = document.getElementById('jabatanError');
        if (!jabatanField.value.trim()) {
            errors.push('Jabatan harus diisi.');
            jabatanError.textContent = 'Jabatan harus diisi.';
            jabatanError.classList.remove('hidden');
            jabatanError.classList.add('text-red-500');
        } else if (!validNamaRegex.test(jabatanField.value.trim())) {
            errors.push('Jabatan mengandung karakter tidak valid.');
            jabatanError.textContent = 'Jabatan mengandung karakter tidak valid.';
            jabatanError.classList.remove('hidden');
            jabatanError.classList.add('text-red-500');
        } else {
            jabatanError.classList.add('hidden');
            jabatanError.textContent = '';
        }

        let petugasField = document.getElementById('petugas');
        let petugasError = document.getElementById('petugasError');
        if (!petugasField.value.trim()) {
            errors.push('petugas harus diisi.');
            petugasError.textContent = 'petugas harus diisi.';
            petugasError.classList.remove('hidden');
            petugasError.classList.add('text-red-500');
        } else if (!validNamaRegex.test(petugasField.value.trim())) {
            errors.push('petugas mengandung karakter tidak valid.');
            petugasError.textContent = 'petugas mengandung karakter tidak valid.';
            petugasError.classList.remove('hidden');
            petugasError.classList.add('text-red-500');
        } else {
            petugasError.classList.add('hidden');
            petugasError.textContent = '';
        }

        if (errors.length > 0) {
            e.preventDefault();
        }
    });
</script>
@endsection