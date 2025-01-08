@php
    $posisi_options = [
        'pendataan' => 'Pendataan',
        'pengolahan' => 'Pengolahan',
    ];
@endphp

@extends('components.layout')

@section('title', 'Edit Perusahaan')

@section('content')
    <div class="size-full flex flex-col items-center px-4 py-6">
        <div class="w-full bg-white shadow-lg rounded-lg p-6">
            <div class="w-full pb-6 flex">
                <x-judul text="Edit Perusahaan"/>
            </div>

            <form action="{{ route('perusahaan.update', $perusahaan->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Input Nama Usaha --}}
                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Nama Usaha</label>
                    <input type="text" id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha', $perusahaan->nama_usaha) }}"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    @error('nama_usaha')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input ID SBR --}}
                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">ID SBR</label>
                    <input type="text" id="idsbr" name="idsbr" value="{{ old('idsbr', $perusahaan->idsbr) }}"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    @error('idsbr')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Kode Wilayah --}}
                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Kode Wilayah</label>
                    <input type="text" id="kode_wilayah" name="kode_wilayah" value="{{ old('kode_wilayah', $perusahaan->kode_wilayah) }}"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    @error('kode_wilayah')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input SLS --}}
                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">SLS</label>
                    <input type="text" id="sls" name="sls" value="{{ old('sls', $perusahaan->sls) }}"
                           class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    @error('sls')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Alamat Detail --}}
                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Alamat Detail</label>
                    <textarea id="alamat_detail" name="alamat_detail" rows="4"
                              class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm resize-none">{{ old('alamat_detail', $perusahaan->alamat_detail) }}</textarea>
                    @error('alamat_detail')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Posisi --}}
                <div class="w-full pb-2">
                    <label class="text-lg text-cyan-950 font-medium">Posisi</label>
                    <div class="mt-2 space-y-2 ml-2 flex flex-col">
                        @foreach ($posisi_options as $value => $label)
                            <div class="flex items-center ml-1">
                                <input type="checkbox" id="posisi_{{ $value }}" name="posisi[]"
                                       value="{{ $value }}"
                                       {{ in_array($value, old('posisi', $perusahaan->posisi ?? [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-teal-600 border-gray-300 rounded bg-gray-100 focus:ring-teal-500 focus:border-teal-500">
                                <label for="posisi_{{ $value }}" class="ml-2 block text-sm text-gray-600">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('posisi')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="w-full flex justify-end pt-4">
                    <x-submit-button>
                        Simpan Perubahan
                    </x-submit-button>
                </div>
            </form>
        </div>
    </div>
@endsection
