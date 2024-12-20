@extends('components.layout')

@section('title', 'Beban Kerja Mitra')

@section('content')
    <div class="size-full flex flex-col w-full items-center px-4">
        {{--        Judul--}}
        <div class="w-full pb-6 ">
            <x-judul text="Beban Kerja Mitra"/>
        </div>

        <div class="w-full pb-8">
            <x-line-card :judul="'Total Penerimaan Mitra Setiap Periode'" :labels="$labels" :value="$value"/>
        </div>


        {{--        Pencarian dan Periode--}}
        <div class="w-full flex flex-row justify-between items-center pb-0.5">
            {{-- Dropdown Button --}}
            <div class="flex items-center">
                <div class="dropdown dropdown-bottom">
                    <div tabindex="0" role="button"
                         class="btn bg-teal-700 border-0 text-gray-50 justify-between self-center btn-sm w-36 hover:bg-teal-600 flex items-center">
                        <div class="self-center pr-2">
                            <p class="text-md text-gray-50">Agustus</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </div>
                    <ul tabindex="0" class="dropdown-content menu bg-gray-50 z-[1] w-52 p-2 shadow">
                        <li><a class="text-cyan-950">Item 1</a></li>
                        <li><a class="text-cyan-950">Item 2</a></li>
                        <li><a class="text-cyan-950">Item 3</a></li>
                        <li><a class="text-cyan-950">Item 4</a></li>
                    </ul>
                </div>
            </div>

            {{-- Search Input --}}
            <div class="relative flex items-center w-64 ">
                <input type="text"
                       class="input pl-10 m-2 mr-0 w-full bg-gray-50 border border-gray-300 rounded-md input-sm focus:outline-none focus:ring-1 focus:ring-teal-600 focus:border-teal-600 peer"
                       placeholder="Cari kegiatan"/>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="absolute left-4 w-5 h-5 text-gray-500 transition duration-200 ease-in-out peer-focus:text-teal-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
            </div>
        </div>


        {{--        Tabel--}}
        <div class="max-w-[78vw] flex flex-col justify-center pb-12 ">
            <div class="relative overflow-x-auto">
                <table class="table-custom">
                    <thead>
                    <tr>
                        <th scope="col" class="w-12">No</th>
                        <th scope="col" class="w-32">Tanggal</th>
                        <th scope="col" class="w-64">Kegiatan</th>
                        <th scope="col" class="w-64">Nama</th>
                        <th scope="col" class="w-24">Target</th>
                        <th scope="col" class="w-24">Realisasi</th>
                        <th scope="col" class="w-24">Satuan</th>
                        <th scope="col" class="w-32">Harga Satuan</th>
                        <th scope="col" class="w-32">Total Penerimaan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="tr-border-b">
                        <td>1</td>
                        <td class="date-cell">2024-01-15</td>
                        <td>Pembangunan Gedung</td>
                        <td>John Doe</td>
                        <td>1000</td>
                        <td>800</td>
                        <td>Unit</td>
                        <td>500000</td>
                        <td>400000000</td>
                    </tr>
                    <tr class="tr-border-b">
                        <td>2</td>
                        <td class="date-cell">2024-02-20</td>
                        <td>Pengadaan Material</td>
                        <td>Jane Smith</td>
                        <td>500</td>
                        <td>450</td>
                        <td>Box</td>
                        <td>200000</td>
                        <td>90000000</td>
                    </tr>
                    <tr class="tr-border-b">
                        <td>3</td>
                        <td class="date-cell">2024-03-10</td>
                        <td>Perawatan Rutin</td>
                        <td>Alice Johnson</td>
                        <td>200</td>
                        <td>200</td>
                        <td>Jam</td>
                        <td>100000</td>
                        <td>20000000</td>
                    </tr>
                    <tr class="tr-border-b">
                        <td>4</td>
                        <td class="date-cell">2024-04-25</td>
                        <td>Penyewaan Alat</td>
                        <td>Bob Brown</td>
                        <td>10</td>
                        <td>8</td>
                        <td>Unit</td>
                        <td>1500000</td>
                        <td>12000000</td>
                    </tr>
                    <tr class="tr-border-b">
                        <td>5</td>
                        <td class="date-cell">2024-05-30</td>
                        <td>Pengadaan Peralatan</td>
                        <td>Charlie White</td>
                        <td>50</td>
                        <td>45</td>
                        <td>Unit</td>
                        <td>1000000</td>
                        <td>45000000</td>
                    </tr>
                    <tr class="tr-border-b">
                        <td>6</td>
                        <td class="date-cell">2024-06-05</td>
                        <td>Pembangunan Jalan</td>
                        <td>David Black</td>
                        <td>2000</td>
                        <td>1800</td>
                        <td>Meter</td>
                        <td>2000000</td>
                        <td>3600000000</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td class="date-cell">2024-07-10</td>
                        <td>Pengadaan Bahan Bakar</td>
                        <td>Eve Green</td>
                        <td>100</td>
                        <td>90</td>
                        <td>Liter</td>
                        <td>10000</td>
                        <td>900000</td>
                    </tr>
                    </tbody>
                </table>
            </div>


            <div class="flex flex-row items-center justify-between">
        <span class="text-sm text-gray-400">
            Menampilkan
            <span class="font-semibold text-gray-900">1</span>
            sampai
            <span class="font-semibold text-gray-900">7</span>
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
