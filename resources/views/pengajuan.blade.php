@php use Carbon\Carbon; @endphp
@extends('components.layout')

@section('title', 'Semua Pengajuan Beban Kerja')

@section('content')

<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul--}}
    <div class="w-full pb-6 ">
        <x-judul text="Semua Pengajuan Beban Kerja" />
    </div>


    {{-- Tabel--}}
    <div class="flex flex-col justify-center overflow-x-auto w-full">
        <div class="relative w-full shadow-md rounded-lg border border-gray-300 bg-white">
            <table class="table-auto w-full border-collapse text-sm text-gray-700 rounded-lg">
                <thead class="bg-[rgb(4,116,129)] text-white">
                    <tr>
                        <th scope="col" rowspan="2" class="w-8 text-center py-3 border-b-[rgb(229,231,235)] border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)] rounded-tl-lg">
                            No
                        </th>
                        <th scope="col" rowspan="2" class="text-center py-3 border-b-[rgb(229,231,235)] border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)]">
                            Nama Pegawai
                        </th>
                        <th scope="col" rowspan="2" class="text-center py-3 border-b-[rgb(229,231,235)] border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)]">
                            Nama Kegiatan
                        </th>
                        <th scope="col" rowspan="2" class="text-center py-3 border-b-[rgb(229,231,235)] border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)]">
                            Tanggal Pengajuan
                        </th>
                        <th scope="col" rowspan="2" class="text-center py-3 border-b-[rgb(229,231,235)] border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)]">
                            Jumlah Pengajuan
                        </th>
                        <th scope="col" rowspan="2" class="text-center py-3 border-b-[rgb(229,231,235)] border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)]">
                            Satuan
                        </th>
                        <th scope="col" rowspan="2" class="text-center py-3 border-b-[rgb(229,231,235)] border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)] rounded-tr-lg">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tugas_pegawai as $item)
                    <tr class="border-b-[rgb(229,231,235)] hover:bg-gray-50 transition duration-150">
                        <td class="text-center py-3 px-2 border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)] rounded-tl-lg">
                            {{ $loop->iteration + ($tugas_pegawai->currentPage() - 1) * $tugas_pegawai->perPage() }}
                        </td>
                        <td class="text-center py-3 px-4 border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)]">
                            {{ $item->penugasanPegawai->pegawai->nama }}
                        </td>
                        <td class="text-center py-3 px-4 border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)]">
                            {{ $item->penugasanPegawai->kegiatan->nama }}
                        </td>
                        <td class="text-center py-3 px-4 border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)]">
                            @if($item->created_at)
                            {{ Carbon::parse($item->created_at)->format('d-m-Y') }}
                            @else
                            -
                            @endif
                        </td>
                        <td class="text-center py-3 px-4 border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)]">
                            {{ $item->dikerjakan }}
                        </td>
                        <td class="text-center py-3 px-4 border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)]">
                            {{ $item->penugasanPegawai->kegiatan->satuan }}
                        </td>
                        <td class="text-center py-3 px-4 border-l-[rgb(249,250,251)] border-r-[rgb(249,250,251)] rounded-tr-lg">
                            <div class="flex justify-center">
                                <form action="{{ route('pengajuan-organik-approve-tabel', ['tugasId' => $item->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('POST')
                                    <x-acc-button />
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Pagination --}}
    <x-paginator :paginator="$tugas_pegawai" :url="request()->fullUrlWithQuery([])" />
</div>
@endsection