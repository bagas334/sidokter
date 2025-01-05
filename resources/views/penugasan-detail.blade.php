@extends('components.layout')
@section('title', 'Penugasan')
@section('content')

<div class="size-full flex flex-col w-full items-center px-4">
    <div class="w-full pb-6">
        <a class="text-blue py-1 px-2 bg-blue-200 text-blue-500 font-bold hover:bg-blue-400 hover:text-blue-700 rounded-xl" href="{{route('beban-kerja-all')}}">Kembali</a>
        <p class="text-sm"><?php echo $kegiatan->nama ?> / Penugasan</p>
        <p class="text-3xl text-teal-600 font-bold"><?php echo $kegiatan->nama ?></p>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-[7fr_2.5fr] grid-rows-auto size-full pt-6 gap-4">
        <div class="flex flex-col space-y-4">
            <div class="size-full bg-gray-50 border border-gray-100 rounded-md p-4">
                <div class="w-full pl-2 pb-6 flex justify-between">
                    <span class="text-2xl text-teal-600 font-medium">Daftar Organik</span>
                    <x-tambah-button :route="route('penugasan-organik-create', ['id' => $id])" />
                </div>

                <div class="flex flex-col justify-center overflow-x-auto max-w-[70vw]">
                    <div class="relative overflow-auto">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th scope="col" class="w-8 text-center">No</th>
                                    <th scope="col" class="w-13">Nama</th>
                                    <th scope="col" class="w-8">Jabatan</th>
                                    <th scope="col" class="w-8 text-center">Target (Satuan)</th>
                                    <th scope="col" class="w-8 text-center">Terlaksana (Satuan)</th>
                                    <th scope="col" class="w-8 text-center">Aksi</th>
                                    <th scope="col" class="w-8 text-center">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($pegawai && $pegawai->isNotEmpty())
                                @foreach ($penugasanPegawai as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->pegawai->nama }}</td>
                                    <td class="text-center">{{ $item->jabatan }}</td>
                                    <td class="text-center">{{ $item->target }}</td>
                                    <td class="text-center">{{ $item->terlaksana }}</td>
                                    <td class="text-center flex">
                                        <a href="/beban-kerja/{{$id}}/tugas-organik/{{$item->pegawai->id}}" class="mx-1 button bg-blue-500 py-1 px-2 text-white font-md rounded-md">Detail</a>
                                        <form action="{{ route('penugasan-organik-delete', ['id'=>$item->id, 'penugasan'=>$id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <x-remove-button />
                                        </form>
                                        <a href="{{route('penugasan-organik-edit',['id'=>$id,'petugas'=>$item->petugas])}}" class="mx-1 button bg-blue-500 py-1 px-2 text-white font-md rounded-md">Edit</a>
                                    </td>
                                    <td class="text-center">{{$item->catatan}}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data pegawai yang ditemukan.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        <x-paginator :paginator="$penugasanPegawai" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row-span-1 flex flex-col justify-between max-w-[75vw]">
            <div class="size-full bg-gray-50 border border-gray-100 rounded-md rounded-md p-4 h-auto">
                <div class="w-full pl-2 pb-6">
                    <span class="text-xl text-teal-600 font-bold">Informasi Penugasan</span>
                </div>
                <div class="w-full pl-2 pb-2">
                    <p class="text-md text-cyan-950 font-medium" style="margin-bottom: 5px;">Status</p>
                    <div class="w-full pl-2 pb-2">
                        <!-- Progres Bar -->
                        <div class="relative w-full h-3 bg-gray-200 rounded-full dark:bg-gray-700 overflow-hidden">
                            <!-- Selesai -->
                            <div class="absolute top-0 left-0 h-full bg-green-500"
                                style="width: {{ $progresSelesai }}%;">
                            </div>
                            <!-- Ditugaskan -->
                            <div class="absolute top-0 left-0 h-full bg-yellow-300"
                                style="width: {{ $progresDitugaskan }}%; margin-left: {{ $progresSelesai }}%;">
                            </div>
                        </div>
                        <!-- Keterangan -->
                        <div class="flex items-center gap-4 mt-4">
                            <!-- Selesai -->
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <span class="text-xs text-gray-700">Selesai ({{ number_format($progresSelesai, 2) }}%)</span>
                            </div>
                            <!-- Ditugaskan -->
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                                <span class="text-xs text-gray-700">Ditugaskan ({{ number_format($progresDitugaskan, 2) }}%)</span>
                            </div>
                            <!-- Sisanya -->
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                <span class="text-xs text-gray-700">Belum dialokasikan ({{ number_format(100 - $progresSelesai - $progresDitugaskan, 2) }}%)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full pl-2 pb-2">
                    <p class="text-md text-cyan-950 font-medium">Fungsi: </p>
                    <p class="text-sm text-gray-600 font-normal"><?php echo $kegiatan->asal_fungsi ?></p>
                </div>
                <div class="w-full pl-2 pb-2">
                    <p class="text-md text-cyan-950 font-medium">Harga Satuan: </p>
                    <p class="text-sm text-gray-600 font-normal"><?php echo $kegiatan->harga_satuan ?></p>
                </div>
                <div class="w-full pl-2 pb-2">
                    <p class="text-md text-cyan-950 font-medium">Ketua Tim: </p>
                    <p class="text-sm text-gray-600 font-normal">nnn</p>
                </div>
            </div>
        </div>

        <div class="size-full pt-6">
            <div class="size-full bg-gray-50 border border-gray-100 rounded-md rounded-md p-4">

                <div class="w-full flex flex-row justify-between items-center pb-1">
                    <div class="w-full pl-2 pb-6 flex flex-row justify-between">
                        <span class="text-2xl text-teal-600 font-medium">Daftar Tugas Mitra</span>
                    </div>
                    <x-tambah-button :route="route('penugasan-mitra-create', ['id' => $id])" />
                </div>

                <div class="flex flex-col justify-center overflow-x-auto max-w-[78vw]">
                    <div class="relative overflow-auto">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th scope="col" class="w-8 text-center">No</th>
                                    <th scope="col" class="w-13">Nama</th>
                                    <th scope="col" class="w-8 text-end">Pendapatan</th>
                                    <th scope="col" class="w-8 text-center">Target (Satuan)</th>
                                    <th scope="col" class="w-8 text-center">Terlaksana (Satuan)</th>
                                    <th scope="col" class="w-8 text-center">Aksi</th>
                                    <th scope="col" class="w-8 text-center">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($mitra && $mitra->count() > 0)
                                @foreach ($penugasanMitra as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->mitra->nama }}</td>
                                    <td class="text-end">{{ $item->mitra->pendapatan }}</td>
                                    <td class="text-end">{{ $item->target }}</td>
                                    <td class="text-end">{{ $item->terlaksana}}</td>
                                    <td class="text-center w-8">
                                        <div class="justify-center space-x-2 px-2 flex">
                                            <x-edit
                                                :route="'penugasan-mitra-edit'"
                                                :parameters="['id' => $id, 'petugas' => $item->petugas]" />

                                            <form action="{{ route('penugasan-mitra-delete', ['id'=>$item->id, 'penugasan'=>$id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <x-remove-button />
                                            </form>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($item->catatan)
                                        {{$item->catatan}}
                                        @else
                                        Tidak ada
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data mitra yang ditemukan.</td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        <x-paginator :paginator="$penugasanMitra" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection