@extends('components.layout')

@section('title', 'Buat Kegiatan')

@section('content')
<?php
?>
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul--}}
    <div class="w-full pb-6 ">
        <div class="flex  justify-beetween">
            <div>
                <p class="text-sm">Detail Sampel / {{$sampel->nama}}</p>
                <p class="text-3xl font-bold">Daftar Perusahaan</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col justify-center overflow-x-auto max-w-[78vw]">
        <div class="relative min-w-[100vw]">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2" class="w-8 text-center">No</th>
                        <th scope="col" rowspan="2" class="w-56">ID SBR</th>
                        <th scope="col" rowspan="2" class="w-24">Kode Wilayah</th>
                        <th scope="col" rowspan="2" class="w-24">Nama Usaha</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">SLS</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Alamat Detail</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Kode KBLI</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Nama CP</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Nomor CP</th>
                        <th scope="col" rowspan="2" class="w-28 text-center">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sampel->perusahaan as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->idsbr }}</td>
                        <td>{{ $item->kode_wilayah }}</td>
                        <td>{{ $item->nama_usaha }}</td>
                        <td class="text-end">{{ $item->sls }}</td>
                        <td class="text-end">{{ $item->alamat_detail }}</td>
                        <td class="text-center">{{$item->kode_kbli }}</td>
                        <td class="text-end">{{ $item->nama_cp }}</td>
                        <td class="text-end">{{ $item->nomor_cp }}</td>
                        <td class="text-end">{{ $item->email }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection