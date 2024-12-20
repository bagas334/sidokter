@extends('components.layout')

@section('title', 'Capaian Kerja Agregat')

@section('content')
    <div class="size-full flex flex-col w-full items-center px-4">
        {{--        Judul--}}
        <div class="w-full pb-2">
            <x-judul text="Capaian Kegiatan Mitra"/>
        </div>

        {{--        Nama Organik--}}
        <div class="w-full pb-6 flex flex-row justify-start space-x-3">
            <x-sub-judul text="{{$nama}}"/>
        </div>

        <div class="w-full flex flex-row justify-end items-center pb-0.5">
            <x-simpan-finalisasi-button/>
        </div>

        {{--        Tabel--}}
        <div class="w-full flex flex-col justify-center pb-12">

            <div class="relative w-full min-w-[1200px]">
                <table class="table-custom">
                    <thead>
                    <tr>
                        <th scope="col" class="w-96">No</th>
                        <th scope="col" class="w-28">Tanggal</th>
                        <th scope="col" class="w-48">Kegiatan</th>
                        <th scope="col" class="w-32">Mitra</th>
                        <th scope="col" class="w-20">Target</th>
                        <th scope="col" class="w-20">Realisasi</th>
                        <th scope="col" class="w-16">Satuan</th>
                        <th scope="col" class="w-28">Harga Satuan</th>
                        <th scope="col" class="w-28">Total</th>
                        <th scope="col" class="w-16">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td class="date-cell">2021-10-01</td>
                        <td>Survei Biaya Hidup</td>
                        <td>John Doe</td>
                        <td>100</td>
                        <td>100</td>
                        <td>Orang</td>
                        <td>Rp. 100.000</td>
                        <td>Rp. 10.000.000</td>
                        <td>
                            <x-edit-button/>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="date-cell">2021-10-01</td>
                        <td>Survei Biaya Hidup</td>
                        <td>John Doe</td>
                        <td>100</td>
                        <td>100</td>
                        <td>Orang</td>
                        <td>Rp. 100.000</td>
                        <td>Rp. 10.000.000</td>
                        <td>
                            <x-edit-button/>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="date-cell">2021-10-01</td>
                        <td>Survei Biaya Hidup</td>
                        <td>John Doe</td>
                        <td>100</td>
                        <td>100</td>
                        <td>Orang</td>
                        <td>Rp. 100.000</td>
                        <td>Rp. 10.000.000</td>
                        <td>
                            <x-edit-button/>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="date-cell">2021-10-01</td>
                        <td>Survei Biaya Hidup</td>
                        <td>John Doe</td>
                        <td>100</td>
                        <td>100</td>
                        <td>Orang</td>
                        <td>Rp. 100.000</td>
                        <td>Rp. 10.000.000</td>
                        <td>
                            <x-edit-button/>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td class="date-cell">2021-10-01</td>
                        <td>Survei Biaya Hidup</td>
                        <td>John Doe</td>
                        <td>100</td>
                        <td>100</td>
                        <td>Orang</td>
                        <td>Rp. 100.000</td>
                        <td>Rp. 10.000.000</td>
                        <td>
                            <x-edit-button/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-row items-center justify-between">
                <span class="text-sm text-gray-400">
                    Menampilkan
                    <span class="font-semibold text-gray-900">1</span>
                    sampai
                    <span class="font-semibold text-gray-900">10</span>
                    dari
                    <span class="font-semibold text-gray-900">100</span>
                    entri
                </span>
                <div class="inline-flex mt-2 xs:mt-0 space-x-0.5">
                    <button
                        class="btn bg-teal-700 border-0 text-gray-50 justify-between self-center btn-sm w-24 hover:bg-teal-600 flex items-center rounded-r-none" role="button">
                        <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 5H1m0 0 4 4M1 5l4-4"/>
                        </svg>
                        Prev
                    </button>
                    <button
                        class="btn bg-teal-700 border-0 text-gray-50 justify-between self-center btn-sm w-24 hover:bg-teal-600 flex items-center rounded-l-none" role="button">
                        Next
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection
