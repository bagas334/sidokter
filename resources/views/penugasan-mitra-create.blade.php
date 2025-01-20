@extends('components.layout')

@section('title', 'Buat Penugasan Mitra')

@section('content')

<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Buat Penugasan Mitra" />
        </div>

        <form id="form" action="{{ route('penugasan-mitra-create-save', ['id' => $id]) }}" method="POST">
            @csrf
            @method('POST')


            <input type="text" name="kegiatan_id" value="{{$id}}" hidden>


            <x-input.dropdown-mitra :label="'Mitra'"
                :options="$mitra"
                :name="'petugas'"
                required></x-input.dropdown-mitra>
            @error('petugas')
            <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

            <x-input.double-input-layout
                :label="'Kuantitas'"
                :name="'kuantitas'">
                <x-input.number-field
                    :label="'Target'"
                    :name="'target'"
                    id="target"
                    :label_size="'md'"></x-input.number-field>
            </x-input.double-input-layout>

            <x-input.text-area
                :label="'Catatan'"
                :name="'catatan'"></x-input.text-area>

            <div class="w-full flex justify-end pt-4" id="submitButton" style="display: block;">
                <x-submit-button>
                    Buat Penugasan
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
        </script>

    </div>
</div>

@endsection