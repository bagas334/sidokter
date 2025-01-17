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
            <x-judul text="Edit User" />
        </div>

        <form action="{{ route('manajemen-user-edit-save', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium" style="">Nama</label>
                <input type="text" id="nama" name="nama"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" value="{{$user->pegawai->nama}}" disabled>
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium" style="">Email</label>
                <input type="text" id="email" name="email"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" value="{{$user->email}}">
                @error('email')
                <div class="text-sm text-red-500" id="namaKegiatanError">{{$message}}</div>
                @enderror
            </div>

            <label for="jabatan" class="text-lg text-cyan-950 font-medium">Jabatan</label>
            <x-input.dropdown-single id="jabatan" :options="$opsi" :name="'jabatan'" value="{{$user->jabatan}}">

            </x-input.dropdown-single>


            <div id="fungsi">
                <label for="fungsi" class="text-lg text-cyan-950 font-medium">Fungsi (Ketua Tim)</label>
                <x-input.dropdown-single :options="$fungsi_ketua_tim" name="fungsi_ketua_tim" value="{{$user->fungsi_ketua_tim}}">
                </x-input.dropdown-single>
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">Password (Biarkan kosong bila tidak diubah)</label>
                <input type="password" id="nip_bps" name="password"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                @error('password')
                <div class="text-sm text-red-500" id="namaKegiatanError">{{$message}}</div>
                @enderror
            </div>

            <div class="w-full flex justify-end pt-4">
                <x-submit-button>
                    Edit Pegawai
                </x-submit-button>
            </div>
        </form>
    </div>
</div>

<script>
    const jabatan = document.getElementById('jabatan');
    const fungsi = document.getElementById('fungsi');

    jabatan.addEventListener('change', function() {
        if (jabatan.value == 'Ketua Tim') {
            fungsi.style.display = 'block';
        } else {
            fungsi.style.display = 'none';
            fungsi.value = '';
        }
    });
</script>

@endsection