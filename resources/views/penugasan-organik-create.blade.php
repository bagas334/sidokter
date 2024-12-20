@extends('components.layout')

@section('title', 'Buat Penugasan Organik')

@section('content')
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Tambah Organik" />
        </div>

        <form action="{{ route('penugasan-organik-create-save',['id'=>$id]) }}" method="POST">
            @csrf
            @method('POST')

            <input type="text" name="kegiatan_id" value="{{$id}}" hidden>

            <!-- <x-input.text-field
                :label="'Nama Kegiatan'"
                :name="'kegiatan'"
                :value="$kegiatan->nama"
                disabled
                required></x-input.text-field> -->

            <x-input.dropdown
                :label="'Organik'"
                :options="$pilihan_pegawai"
                :name="'petugas'"
                required></x-input.dropdown>

            <x-input.text-field
                :label="'Jabatan Penugasan'"
                :name="'jabatan'"
                required></x-input.text-field>

            <input type="text" value="Ditugaskan" name="status" hidden>

            <x-input.double-input-layout
                :label="'Kuantitas'"
                :name="'kuantitas'">
                <x-input.number-field
                    :label="'Jumlah satuan'"
                    :name="'target'"
                    :label_size="'md'"></x-input.number-field>
                <!-- <x-input.dropdown
                    :label="'Satuan'"
                    :options="$satuan_kegiatan"
                    :name="'satuan'"
                    :label_size="'md'"></x-input.dropdown> -->
            </x-input.double-input-layout>


            <x-input.text-area
                :label="'Catatan'"
                :name="'catatan'"></x-input.text-area>

            <div class="w-full flex justify-end pt-4">
                <x-submit-button>
                    Buat Penugasan
                </x-submit-button>
            </div>
        </form>
    </div>
</div>
@endsection