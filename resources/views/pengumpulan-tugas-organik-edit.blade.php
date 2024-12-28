@extends('components.layout')

@section('title', 'Buat Penugasan Organik')

@section('content')
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Edit Pengumpulan Tugas" />
        </div>

        <form action="{{ route('pengumpulan-tugas-organik-save',['id'=>$tugas_pegawai->penugasan_pegawai_id]) }}" method="POST">
            @csrf
            @method('POST')

            <input type="text" name="penugasan_pegawai" value="{{$tugas_pegawai->penugasan_pegawai_id}}" hidden>
            <input type="text" name="kegiatan_id" value="{{$tugas_pegawai->penugasan_pegawai->kegiatan}}" hidden>
            <input type="text" name="pegawai_id" value="{{$pegawai}}" hidden>

            <x-input.text-field
                :label="'Jumlah Dikerjakan'"
                :name="'dikerjakan'"
                required></x-input.text-field>

            <x-input.text-field
                :label="'Link Bukti'"
                :name="'bukti'"
                required></x-input.text-field>

            @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan', 'Ketua Tim']))
            <input type="text" value="proses" name="status" hidden>
            <x-input.text-area
                :label="'Catatan'"
                :name="'catatan'"></x-input.text-area>
            @endif

            <div class="w-full flex justify-end pt-4">
                <x-submit-button>
                    Buat Penugasan
                </x-submit-button>
            </div>
        </form>
    </div>
</div>
@endsection