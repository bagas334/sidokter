@extends('components.layout')

@section('title', 'Buat Kegiatan')

@section('content')
<div class="text-black">
    <p>Buat sampel</p>
    <form action="{{route('sampel-generate')}}" class="block" method="POST">
        @method('POST')
        @csrf
        <input class="" type="text" name="dibuat_oleh" value="{{auth()->user()->id}}" hidden>
        <label class="block" for="nama">Nama sampel</label>
        <input class="block" type="text" name="nama" id="nama">
        <label class="block" for="jumlah">Jumlah sampel</label>
        <input class="block" type="number" name="jumlah" id="jumlah">
        <x-input.dropdown
            :label="'Kegiatan'"
            :options="$kegiatan"
            :name="'kegiatan'"
            required></x-input.dropdown>
        <label for="catatan">Catatan</label>
        <input class="block" type="text" name="catatan" id="catatan">
        <x-submit-button>
            Generate Sampel
        </x-submit-button>
    </form>
</div>

@endsection