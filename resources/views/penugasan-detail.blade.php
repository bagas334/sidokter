@extends('components.layout')
@section('title', 'Penugasan')
@section('content')

<div class="size-full flex flex-col w-full items-center px-4">
    <div class="w-full pb-6 flex justify-between">
        <div>
            <a class="text-blue py-1 px-2 bg-blue-200 text-blue-500 font-bold hover:bg-blue-400 hover:text-blue-700 rounded-xl" href="{{route('beban-kerja-all')}}">Kembali</a>
            <p class="mt-2 text-3xl text-teal-600 font-bold"><?php echo $kegiatan->nama ?></p>
        </div>
        @if(auth()->user()->jabatan == 'Organik')
        <a href="/beban-kerja/{{$kegiatan->id}}/tugas-organik/{{auth()->user()->id}}" class="self-center mx-1 button bg-blue-500 py-1.5 px-2 text-white font-medium rounded-lg hover:bg-blue-600 transition">Lihat tugas anda</a>
        @endif
    </div>

    <div class="grid grid-cols-[7fr_2.5fr] grid-rows-auto size-full pt-6 gap-4">
        <div class="flex flex-col space-y-4">
            <div class="size-full bg-gray-50 border border-gray-100 rounded-md p-4">
                <div class="w-full pl-2 pb-6 flex justify-between">
                    <span class="text-2xl text-teal-600 font-medium">Daftar Organik</span>
                    @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan', 'Ketua Tim']))
                    <x-tambah-button :route="route('penugasan-organik-create', ['id' => $id])" />
                    @endif
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
                                    @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan', 'Ketua Tim']))
                                    <th scope="col" class="w-8 text-center">Aksi</th>
                                    @endif
                                    <th scope="col" class="w-8 text-center">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($pegawai && $pegawai->isNotEmpty())
                                @foreach ($penugasanPegawai as $item)
                                <tr>
                                    <td class="text-center">{{$loop->iteration + ($penugasanPegawai->currentPage() - 1) * $penugasanPegawai->perPage() }}</td>
                                    <td>{{ $item->pegawai->nama }}</td>
                                    <td class="text-center">{{ $item->jabatan }}</td>
                                    <td class="text-center">{{ $item->target }}</td>
                                    <td class="text-center">{{ $item->terlaksana }}</td>
                                    @if(in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan', 'Ketua Tim']))
                                    <td class="text-center flex">
                                        <a href="/beban-kerja/{{$id}}/tugas-organik/{{$item->pegawai->id}}" class="mx-1 button bg-blue-500 py-1 px-2 text-white font-md rounded-md">Detail</a>
                                        <form action="{{ route('penugasan-organik-delete', ['id'=>$item->id, 'penugasan'=>$id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <x-remove-button />
                                        </form>
                                        <a href="{{route('penugasan-organik-edit',['id'=>$id,'petugas'=>$item->petugas])}}" class="mx-1 button bg-blue-500 py-1 px-2 text-white font-md rounded-md">Edit</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Trigger Modal -->
                                        <span class="text-blue-500 cursor-pointer" data-modal-target="catatanModal{{ $item->id }}" data-modal-toggle="catatanModal{{ $item->id }}">
                                            Lihat Catatan
                                        </span>

                                        <!-- Modal -->
                                        <div id="catatanModal{{ $item->id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full max-h-full">
                                            <div class="relative w-full max-w-xl max-h-full">
                                                <!-- Modal Content -->
                                                <div class="bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <!-- Modal Header -->
                                                    <div class="flex justify-between items-center p-4 border-b dark:border-gray-600">
                                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Catatan</h3>
                                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="catatanModal{{ $item->id }}">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <!-- Modal Body -->
                                                    <div class="p-4">
                                                        <p>{{ $item->catatan ?: 'Tidak ada catatan.' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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
                        <x-paginator :paginator="$penugasanPegawai" :url="request()->fullUrlWithQuery([])" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row-span-1 flex flex-col justify-between max-w-[75vw]">
            <div class="size-full bg-gray-50 border border-gray-100 rounded-md p-4 h-auto">
                <div class="w-full pl-2 pb-6">
                    <span class="text-xl text-teal-600 font-bold">Informasi Penugasan</span>
                </div>
                <div class="w-full pl-2 pb-2">
                    <p class="text-md text-cyan-950 font-medium">Jumlah Satuan: </p>
                    <p class="text-sm text-gray-600 font-normal">{{$kegiatan->target}}</p>
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
                    <p class="text-sm text-gray-600 font-normal"></p>
                </div>
            </div>
        </div>

        <div class="size-full pt-6">
            <div class="size-full bg-gray-50 border border-gray-100 rounded-md p-4">

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
                                    <td class="text-center">{{$loop->iteration + ($penugasanMitra->currentPage() - 1) * $penugasanMitra->perPage() }}</td>
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
                                        <!-- Trigger Modal -->
                                        <span class="text-blue-500 cursor-pointer" data-modal-target="catatanModalMitra{{ $item->id }}" data-modal-toggle="catatanModalMitra{{ $item->id }}">
                                            Lihat Catatan
                                        </span>

                                        <!-- Modal -->
                                        <div id="catatanModalMitra{{ $item->id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full max-h-full">
                                            <div class="relative w-full max-w-xl max-h-full">
                                                <!-- Modal Content -->
                                                <div class="bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <!-- Modal Header -->
                                                    <div class="flex justify-between items-center p-4 border-b dark:border-gray-600">
                                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Catatan</h3>
                                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="catatanModalMitra{{ $item->id }}">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <!-- Modal Body -->
                                                    <div class="p-4">
                                                        <p>{{ $item->catatan ?: 'Tidak ada catatan.' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                        <x-paginator :paginator="$penugasanMitra" :url="request()->fullUrlWithQuery([])" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(id) {
        document.getElementById(id).style.display = 'block';
    }

    function hideModal(id) {
        document.getElementById(id).style.display = 'none';
    }
</script>

@endsection