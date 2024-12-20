@extends('components.layout')

@section('title', 'Penugasan')

@section('content')
<?php
?>
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul--}}
    <div class="w-full pb-6 ">
        <div class="flex  justify-beetween">
            <div>
                <p class="text-sm"><?php echo $nama_kegiatan ?> / Penugasan</p>
                <p class="text-3xl font-bold"><?php echo $nama_pegawai ?></p>
            </div>
            <a href="/" class="button button-gray-500 bg-gray-500 py-2 px-1 text-white m-auto">Tandai selesai</a>
        </div>
    </div>

    {{-- Grid--}}
    <div class="grid grid-cols-[5fr_3fr] grid-rows-auto size-full pt-6 gap-4">
        <div>
            <div class="row-span-1 max-h-[75vh]">
                <div class="size-full bg-gray-50 border border-gray-100 rounded-md p-4">
                    <div class="w-full pl-2 pb-6 flex justify-between">
                        <span class="text-2xl text-teal-600 font-medium">Tinjau Beban Kerja</span>
                        <x-tambah-button :route="route('pengumpulan-tugas-organik-create', ['id' => $id, 'petugas' => $pegawai])">

                        </x-tambah-button>
                    </div>

                    <div class="flex flex-col justify-center overflow-x-auto max-w-[70vw]">
                        <div class="relative">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th scope="col" class="w-8 text-center">No</th>
                                        <th scope="col" class="w-8">Dikerjakan (satuan)</th>
                                        <th scope="col" class="w-8 text-center">Tanggal Pengajuan</th>
                                        <th scope="col" class="w-8 text-center">Status</th>
                                        <th scope="col" class="w-8 text-center">Bukti</th>
                                        <th scope="col" class="w-8 text-center">Aksi</th>
                                        <th scope="col" class="w-8 text-center">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tugas_pegawai as $item)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{$item->dikerjakan}}</td>
                                        <td class="text-center">{{$item->created_at}}</td>
                                        <td class="text-center">{{$item->status}}</td>
                                        <td class="text-center">
                                            <a href="/" class="button px-2 py-1 rounded-md bg-blue-600 text-white">Lihat</a>
                                        </td>
                                        <td class="text-center flex justify-between">
                                            <form action="{{ route('penugasan-organik-approve', ['id' => $id, 'petugas' => $pegawai, 'tugasId' => $item->id]) }}" method="POST" style="display:inline;">

                                                @csrf
                                                <x-acc-button />
                                            </form>
                                            <a href="/" class="button px-2 py-1 rounded-md bg-blue-600 text-white">Lihat</a>
                                        </td>
                                        <td class="text-center">{{$item->catatan}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-span-1 flex flex-col justify-between max-w-[75vw]">
            <div class="size-full bg-gray-50 border border-gray-100 rounded-md rounded-md p-4">
                <div class="w-full pl-2 pb-6">
                    <span class="text-2xl text-teal-600 font-medium">Informasi Penugasan</span>
                </div>
                <div class="w-full pl-2 pb-2">
                    <p class="text-md text-cyan-950 font-medium">Ditugaskan</p>
                    <p class="text-sm text-gray-600 font-normal">100% (buat grafik frontend)</p>
                </div>
                <div class="w-full pl-2 pb-2">
                    <p class="text-md text-cyan-950 font-medium">Fungsi: </p>
                    <p class="text-sm text-gray-600 font-normal">null</p>
                </div>
                <div class="w-full pl-2 pb-2">
                    <p class="text-md text-cyan-950 font-medium">Harga Satuan: </p>
                    <p class="text-sm text-gray-600 font-normal">Rp10.000</p>
                </div>
                <div class="w-full pl-2 pb-2">
                    <p class="text-md text-cyan-950 font-medium">Catatan: </p>
                    <p class="text-sm text-gray-600 font-normal">null</p>
                </div>
            </div>
        </div>
        <div class="size-full pt-6">
            <div class="size-full bg-gray-50 border border-gray-100 rounded-md rounded-md p-4">
                <div class="w-full pl-2 pb-6 flex flex-row justify-between">
                    <span class="text-2xl text-teal-600 font-medium">Pengajuan Penambahan Beban Kerja</span>
                    <x-tambah-button :route="route('pengajuan-tugas-organik-create', ['id' => $id, 'petugas' => $pegawai])">

                    </x-tambah-button>
                </div>

                <div class="w-full flex flex-row justify-between items-center pb-1">
                    <div class="relative flex items-center w-64 ">
                    </div>
                </div>

                <div class="flex flex-col justify-center overflow-x-auto max-w-[78vw]">
                    <div class="relative">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th scope="col" class="w-8 text-center">No</th>
                                    <th scope="col" class="w-8">Jumlah (Satuan)</th>
                                    <th scope="col" class="w-8 text-center">Potensi Sisa (Satuan)</th>
                                    <th scope="col" class="w-8 text-center">Tanggal Pengajuan</th>
                                    <th scope="col" class="w-8 text-center">Status</th>
                                    <th scope="col" class="w-8 text-center">Aksi</th>
                                    <th scope="col" class="w-8 text-center">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuan_pegawai as $item)

                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{$item->dikerjakan}}</td>
                                    <td class="text-center">0</td>
                                    <td class="text-center">{{$item->created_at}}</td>
                                    <td class="text-center">{{$item->status}}</td>
                                    <td class="text-center">
                                        <form action="{{ route('pengajuan-organik-approve', ['id' => $id, 'petugas' => $pegawai, 'tugasId' => $item->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('POST')
                                            <x-acc-button />
                                        </form>
                                    </td>
                                    <td class="text-center">{{$item->catatan}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection