@extends('components.layout')

@section('title', 'Edit Organik')

@section('content')
<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Edit Organik" />
        </div>

        <form action="{{ route('master-organik-edit-save', $pegawai->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">Nama Pegawai</label>
                <input type="text" id="nama" name="nama" value="{{ $pegawai->nama }}"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                @error('nama')
                <div class="text-sm text-red-500" id="namaKegiatanError">{{$message}}</div>
                @enderror
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">Alias</label>
                <input type="text" id="alias" name="alias" value="{{ $pegawai->alias }}"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                @error('alias')
                <div class="text-sm text-red-500" id="namaKegiatanError">{{$message}}</div>
                @enderror
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">NIP</label>
                <input type="text" id="nip" name="nip" value="{{ $pegawai->nip }}"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                @error('nip')
                <div class="text-sm text-red-500" id="namaKegiatanError">{{$message}}</div>
                @enderror
            </div>

            <div class="w-full pb-2">
                <label class="text-lg text-cyan-950 font-medium">NIP BPS</label>
                <input type="text" id="nip_bps" name="nip_bps" value="{{ $pegawai->nip_bps }}"
                    class="text-gray-600 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                @error('nip_bps')
                <div class="text-sm text-red-500" id="namaKegiatanError">{{$message}}</div>
                @enderror
            </div>

            <label for="jabatan" class="text-lg text-cyan-950 font-medium">Jabatan</label>
            <x-input.dropdown-single id="jabatan" :options="$options" :name="'jabatan'">
            </x-input.dropdown-single>
            @error('jabatan')
            <div class="text-sm text-red-500" id="namaKegiatanError">{{$message}}</div>
            @enderror

            <div id="fungsi">
                <label for="fungsi" class="text-lg text-cyan-950 font-medium">Fungsi (Ketua Tim)</label>
                <x-input.dropdown-single :options="$fungsi_ketua_tim" name="fungsi_ketua_tim" id="">
                </x-input.dropdown-single>
            </div>

            <div class="w-full flex justify-end pt-4">
                <x-submit-button>
                    Simpan Perubahan
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