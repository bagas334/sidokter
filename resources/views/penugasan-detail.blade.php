@extends('components.layout')
@section('title', 'Penugasan')
@section('content')

<div class="size-full flex flex-col w-full items-center px-4">
    <div class="w-full pb-6 ">
        <p class="text-sm"><?php echo $kegiatan->nama ?> / Penugasan</p>
        <p class="text-3xl font-bold"><?php echo $kegiatan->nama ?></p>
    </div>

    {{-- Grid--}}
    <div class="grid grid-cols-[7fr_2.5fr] grid-rows-auto size-full pt-6 gap-4">
        <div>
            <div class="row-span-1 max-h-[75vh]">
                <div class="size-full bg-gray-50 border border-gray-100 rounded-md p-4">
                    <div class="w-full pl-2 pb-6 flex justify-between">
                        <span class="text-2xl text-teal-600 font-medium">Daftar Organik</span>
                        <x-tambah-button :route="route('penugasan-organik-create', ['id' => $id])" />
                    </div>

                    <div class="flex flex-col justify-center overflow-x-auto max-w-[70vw]">
                        <div class="relative">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-span-1 flex flex-col justify-between max-w-[75vw]">
            <div class="size-full bg-gray-50 border border-gray-100 rounded-md rounded-md p-4">
                <div class="w-full pl-2 pb-6">
                    <span class="text-2xl text-teal-600 font-medium">Informasi Tim</span>
                </div>
                <div class="w-full pl-2 pb-2">
                    <p class="text-md text-cyan-950 font-medium">Status</p>
                    <div class="w-full pl-2 pb-2">
                        <!-- Progres Bar -->
                        <div class="relative w-full h-5 bg-gray-200 rounded-full dark:bg-gray-700 overflow-hidden">
                            <!-- Selesai -->
                            <div class="absolute top-0 left-0 h-full bg-green-500" 
                                style="width: {{ $progresSelesai }}%;">
                            </div>
                            <!-- Ditugaskan -->
                            <div class="absolute top-0 left-0 h-full bg-yellow-400" 
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
                                <span class="text-xs text-gray-700">Others ({{ number_format(100 - $progresSelesai - $progresDitugaskan, 2) }}%)</span>
                            </div>
                        </div>    
                    </div>  
                </div>
                <div class="w-full pl-2 pb-2">
                    <p class="text-md text-cyan-950 font-medium">Pengajuan</p>
                    <p class="text-sm text-gray-600 font-normal">100% (buat grafik frontend)</p>
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
                <div class="w-full pl-2 pb-6 flex flex-row justify-between">
                    <span class="text-2xl text-teal-600 font-medium">Daftar Tugas Mitra</span>
                </div>

                <div class="w-full flex flex-row justify-between items-center pb-1">
                    {{-- Pencarian--}}
                    <div class="relative flex items-center w-64 ">
                        <input type="text"
                            class="input pl-10 m-2 ml-0 w-full bg-gray-50 border border-gray-300 rounded-md input-sm focus:outline-none focus:ring-1 focus:ring-teal-600 focus:border-teal-600 peer"
                            placeholder="Cari kegiatan" />

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="absolute left-4 w-5 h-5 text-gray-500 transition duration-200 ease-in-out peer-focus:text-teal-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <x-tambah-button :route="route('penugasan-mitra-create', ['id' => $id])" />

                </div>

                <div class="flex flex-col justify-center overflow-x-auto max-w-[78vw]">
                    <div class="relative">
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
                                            <x-view-button :id="$item->id" :route="'penugasan-mitra-detail'" />
                                            <form action="{{ route('penugasan-mitra-delete', ['id'=>$item->id, 'penugasan'=>$id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <x-remove-button />
                                            </form>
                                        </div>
                                    </td>
                                    <td class="text-center">Tidak ada</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data mitra yang ditemukan.</td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection