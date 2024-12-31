@extends('components.layout')

@section('title', 'Buat Kegiatan')

@section('content')
<style>
    #fungsi {
        display: none;
    }
</style>
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Buat Sampel" />
        </div>

        <form action="{{route('sampel-generate')}}" class="block" method="POST">
            @method('POST')
            @csrf
            <input class="" type="text" name="dibuat_oleh" value="{{auth()->user()->id}}" hidden>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium" for="nama" style="">Nama Sampel</label>
                <input type="text" id="nama" name="nama"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium" for="jumlah" style="">Jumlah Sampel</label>
                <input type="number" id="jumlah" name="jumlah"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <div>
                <x-input.dropdown
                    :label="'Kegiatan'"
                    :options="$kegiatan"
                    :name="'kegiatan'"
                    required></x-input.dropdown>
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium" for="jumlah" style="">Catatan</label>
                <input type="text" id="catatan" name="catatan"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <x-submit-button>
                Buat Sampel
            </x-submit-button>
        </form>
    </div>

    @endsection