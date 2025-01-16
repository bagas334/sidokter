@extends('components.layout')

@section('title', 'Buat Organik')

@section('content')
<style>
    #fungsi {
        display: none;
    }
</style>

<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Buat User Baru (Organik)" />
        </div>

        <form action="{{ route('manajemen-user-save') }}" method="POST">
            @csrf
            @method('POST')
            <label for="nama" class="text-lg text-cyan-950 font-medium">Pegawai</label>
            <x-input.dropdown id="nama" :options="$options" :name="'pegawai_id'">

            </x-input.dropdown>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium" style="">Email</label>
                <input type="text" id="email" name="email"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                @error('email')
                <div class="text-sm text-red-500" id="namaKegiatanError">{{$message}}</div>
                @enderror
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">Password</label>
                <input type="password" id="nip_bps" name="password"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                @error('password')
                <div class="text-sm text-red-500" id="namaKegiatanError">{{$message}}</div>
                @enderror
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