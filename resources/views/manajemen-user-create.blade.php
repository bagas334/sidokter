@extends('components.layout')

@section('title', 'Buat Organik')

@section('content')
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Buat Organik" />
        </div>

        <form action="{{ route('manajemen-user-save') }}" method="POST">
            @csrf
            @method('POST')

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">Nama Pegawai</label>
                <input type="text" id="nama" name="nama"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">Alias</label>
                <input type="text" id="alias" name="alias"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">NIP</label>
                <input type="text" id="nip" name="nip"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">NIP BPS</label>
                <input type="text" id="nip_bps" name="nip_bps"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <label for="jabatan" class="text-lg text-cyan-950 font-medium">Jabatan</label>
            <x-input.dropdown-single :options="$options" :name="'jabatan'">

            </x-input.dropdown-single>

            <label for="fungsi" class="text-lg text-cyan-950 font-medium">Fungsi (Ketua Tim)</label>
            <x-input.dropdown-single :options="$fungsi_ketua_tim" :name="'fungsi_ketua_tim'">

            </x-input.dropdown-single>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">Password</label>
                <input type="text" id="nip_bps" name="password"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <div class="w-full flex justify-end pt-4">
                <x-submit-button>
                    Buat Pegawai
                </x-submit-button>
            </div>
        </form>
    </div>
</div>
@endsection