@extends('components.layout')

@section('title', 'Buat Penugasan Organik')

@section('content')
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Buat Penugasan" />
        </div>

        <form action="{{route('beban-kerja-save')}}" method="POST">
            @csrf
            @method('POST')

            <x-input.text-field
                :label="'Nama Kegiatan'"
                :name="'nama'"
                required></x-input.text-field>

            <x-input.dropdown-single
                :label="'Asal Fungsi'"
                :name="'asal_fungsi'"
                :options="$fungsi">


            </x-input.dropdown-single>

            <x-input.double-input-layout
                :label="'Kuantitas'"
                :name="'kuantitas'">
                <x-input.number-field
                    :label="'Jumlah satuan'"
                    :name="'target'"
                    :label_size="'md'"></x-input.number-field>
                <x-input.number-field
                    :label="'Harga satuan'"
                    :name="'harga_satuan'"
                    :label_size="'md'"></x-input.number-field>
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
            <x-input.text-field
                :label="'Satuan'"
                :value="'Unit'"
                :name="'satuan'"></x-input.text-field>


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