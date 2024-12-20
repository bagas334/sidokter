@php
    $current_fungsi = old('fungsi', $kegiatan->asal_fungsi);
    $options = [
        'bulanan' => 'Bulanan',
        'triwulanan' => 'Triwulanan',
        'semesteran' => 'Semesteran',
        'tahunan' => 'Tahunan',
    ];

    $current_periode = old('periode', $kegiatan->periode);
@endphp

@extends('components.layout')

@section('title', 'Edit Kegiatan')

@section('content')
    <div class="size-full flex flex-col items-center px-4 py-6">
        <div class="w-full bg-white shadow-lg rounded-lg p-6">
            <div class="w-full pb-6 flex">
                <x-judul text="Edit Kegiatan"/>
            </div>

            <form action="{{ route('master-kegiatan-edit-save', $kegiatan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Nama Kegiatan:</label>
                    <input type="text" id="nama" name="nama" value="{{ $kegiatan->nama }}"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Asal Fungsi:</label>
                    <select id="asal_fungsi" name="asal_fungsi"
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

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Periode:</label>
                    <div class="mt-2 space-y-2 ml-2 flex flex-col">
                        @foreach ($options as $value => $label)
                            <div class="flex items-center ml-1">
                                <input type="checkbox" id="periode_{{ $value }}" name="periode[]"
                                       value="{{ $value }}"
                                       {{ in_array($value, $current_periode) ? 'checked' : '' }}
                                       class="h-4 w-4 text-teal-600 border-gray-300 rounded bg-gray-100 focus:ring-teal-500 focus:border-teal-500">
                                <label for="periode_{{ $value }}" class="ml-2 block text-sm text-gray-600">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Tanggal Kegiatan:</label>
                    <div id="tanggal_kegiatan"
                         date-rangepicker
                         datepicker-format="dd-mm-yyyy"
                         class="flex items-center w-full pt-1">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="tanggal_mulai_kegiatan" name="tanggal_mulai" type="text"
                                   value = "{{ $kegiatan->tanggal_mulai->format('d-m-Y') }}"
                                   class="text-gray-600 border border-gray-300 text-sm rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 block w-full ps-10 p-2.5"
                                   placeholder="Pilih Tanggal Mulai">
                        </div>
                        <span class="mx-4 text-gray-500">sampai</span>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="tanggal_akhir_kegiatan" name="tanggal_akhir" type="text"
                                   value= "{{ $kegiatan->tanggal_akhir->format('d-m-Y') }}"
                                   class="text-gray-600 border border-gray-300 text-sm rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 block w-full ps-10 p-2.5"
                                   placeholder="Pilih Tanggal Akhir">
                        </div>
                    </div>
                </div>

                <style>
                    input[type="number"]::-webkit-inner-spin-button,
                    input[type="number"]::-webkit-outer-spin-button {
                        -webkit-appearance: none;
                        appearance: none;
                    }

                    input[type="number"] {
                        -moz-appearance: textfield;
                    }
                </style>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Target:</label>
                    <div class="w-full flex space-x-3">
                        <input type="number" id="target" name="target" value="{{ $kegiatan->target }}"
                               class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        <input type="text" id="satuan" name="satuan" value="{{ $kegiatan->satuan }}"
                               class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    </div>
                </div>

                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Harga Satuan:</label>
                    <input type="number" id="harga_satuan" name="harga_satuan" value="{{ $kegiatan->harga_satuan }}"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
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
