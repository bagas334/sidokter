@extends('components.layout')

@section('title', 'Edit Penugasan Mitra')

@section('content')
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <x-judul text="Edit Penugasan Mitra" />
        <p class="text-xl font-medium">Mitra : {{$awal->mitra->nama}}</p>
        <div class="my-2">
            <form id="form" action="{{ route('penugasan-mitra-edit-save', ['id' => $id, 'pegawai'=>$petugas]) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="text" name="kegiatan_id" value="{{$id}}" hidden>
                <input type="text" name="petugas" value="{{ $awal->petugas }}" hidden>

                <x-input.double-input-layout
                    :label="'Kuantitas'"
                    :name="'kuantitas'">
                    <x-input.number-field
                        :label="'Target'"
                        :name="'target'"
                        id="target"
                        value="{{$awal->target}}"
                        :label_size="'md'"></x-input.number-field>
                    <x-input.number-field
                        :label="'Terlaksana'"
                        :name="'terlaksana'"
                        id="terlaksana"
                        value="0"
                        :label_size="'md'"></x-input.number-field>
                </x-input.double-input-layout>

                <div class="mb-1 text-gray-500">Potensi pendapatan mitra : <span id="pendapatan"></span></div>

                <x-input.text-area
                    :label="'Catatan'"
                    :name="'catatan'"
                    value="{{$awal->catatan}}"></x-input.text-area>

                <div class="w-full flex justify-end pt-4" id="submitButton" style="display: block;">
                    <x-submit-button>
                        Edit Penugasan
                    </x-submit-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection