@extends('components.layout')

@section('title', 'Tinjau Penugasan Organik')

@section('content')
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            @if($tugas_pegawai->status == 'diajukan')
            <x-judul text="Edit Pengajuan Tugas" />
            @else
            <x-judul text="Edit Pengumpulan Tugas" />
            @endif
        </div>

        <form action="{{ route('pengumpulan-tugas-organik-update') }}" method="POST">
            @csrf
            @method('PUT')

            <input type="text" name="penugasan_pegawai" value="{{$tugas_pegawai->penugasan_pegawai}}" hidden>
            <input type="text" name="id" value="{{$tugas_pegawai->id}}" hidden>
            <input type="text" name="kegiatan_id" value="{{$tugas_pegawai->penugasanPegawai->kegiatan_id}}" hidden>
            <input type="text" name="pegawai_id" value="{{$tugas_pegawai->penugasanPegawai->petugas}}" hidden>

            <x-input.text-field
                :label="'Jumlah Dikerjakan'"
                :name="'dikerjakan'"
                :value="$tugas_pegawai->dikerjakan"
                required></x-input.text-field>

            @if($tugas_pegawai->status == 'diajukan')
            <input type="text" value="diajukan" name="status" hidden>
            @else
            <x-input.text-field
                :label="'Link Bukti'"
                :name="'bukti'"
                :value="$tugas_pegawai->bukti"
                required></x-input.text-field>
            <input type="text" value="proses" name="status" hidden>
            @endif

            @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan', 'Ketua Tim']))
            <x-input.text-area
                :label="'Catatan'"
                :value="$tugas_pegawai->catatan"
                :name="'catatan'"></x-input.text-area>
            @endif

            <div class="w-full flex justify-end pt-4">
                <x-submit-button>
                    Edit Penugasan
                </x-submit-button>
            </div>
        </form>

    </div>
</div>
@endsection