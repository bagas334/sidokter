@extends('components.layout')

@section('title', 'Edit Tugas Organik')

@section('content')
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Edit Tugas Organik" />
        </div>

        <form action="{{ route('penugasan-organik-update', ['id' => $id,'pegawai'=>$tugas_pegawai->petugas]) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="text" name="kegiatan_id" value="{{ $id }}" hidden>
            <input type="text" name="petugas" value="{{ $tugas_pegawai->petugas }}" hidden>

            <x-input.text-field
                :label="'Jabatan Penugasan'"
                :name="'jabatan'"
                :value="$tugas_pegawai->jabatan"
                required></x-input.text-field>

            <input type="text" value="Ditugaskan" name="status" hidden>

            <x-input.double-input-layout
                :label="'Kuantitas'"
                :name="'kuantitas'">
                <x-input.number-field
                    :label="'Jumlah satuan'"
                    :name="'target'"
                    :value="$tugas_pegawai->target"
                    :label_size="'md'"></x-input.number-field>
            </x-input.double-input-layout>

            <x-input.text-area
                :label="'Catatan'"
                :name="'catatan'"
                :value="$tugas_pegawai->catatan"></x-input.text-area>

            <div class="w-full flex justify-end pt-4">
                <x-submit-button>
                    Simpan Penugasan
                </x-submit-button>
            </div>
        </form>
    </div>
</div>
@endsection