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

            @if (session('pendapatanError'))
            <div id="pendapatanErrorModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-lg shadow-lg text-center w-11/12 max-w-sm">
                    <h2 class="text-lg font-semibold text-red-600 mb-4">Error</h2>
                    <p class="text-gray-700 mb-6">{{ session('pendapatanError') }}</p>
                    <button id="closeModal" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">OK</button>
                </div>
            </div>
            @endif

            @if (session('terlaksanaError'))
            <div id="terlaksanaErrorModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-lg shadow-lg text-center w-11/12 max-w-sm">
                    <h2 class="text-lg font-semibold text-red-600 mb-4">Error</h2>
                    <p class="text-gray-700 mb-6">{{ session('terlaksanaError') }}</p>
                    <button id="closeModal" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">OK</button>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('pendapatanErrorModal');
        const closeModalButton = document.getElementById('closeModal');

        if (modal && closeModalButton) {
            closeModalButton.addEventListener('click', function() {
                modal.classList.add('hidden'); // Menyembunyikan modal
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('terlaksanaErrorModal');
        const closeModalButton = document.getElementById('closeModal');

        if (modal && closeModalButton) {
            closeModalButton.addEventListener('click', function() {
                modal.classList.add('hidden'); // Menyembunyikan modal
            });
        }
    });
</script>

@endsection