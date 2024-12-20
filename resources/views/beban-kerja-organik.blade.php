@extends('components.layout')

@section('title', 'Beban Kerja Organik')

@section('content')
    <div class="size-full flex flex-col w-full items-center px-4">
        {{--        Judul--}}
        <div class="w-full pb-6 ">
            <x-judul text="Beban Kerja Organik"/>
        </div>

        <div class="w-full pb-8">
            <x-line-card :judul="'Jumlah Kegiatan Setiap Periode'" :labels="$labels" :value="$value"/>
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
        <div class="w-full flex flex-col justify-center pb-12">

            <div class="relative overflow-x-auto">
                <table class="table-custom">
                    <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Kegiatan</th>
                        <th scope="col">Nama Organik</th>
                        <th scope="col">Jumlah Sampel</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td class="date-cell">2021-10-01</td>
                        <td>Survei Biaya Hidup</td>
                        <td>Muhammad Julian Firdaus</td>
                        <td>232</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="date-cell">2021-10-01</td>
                        <td>Survei Biaya Hidup</td>
                        <td>Muhammad Julian Firdaus</td>
                        <td>232</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="date-cell">2021-10-01</td>
                        <td>Survei Biaya Hidup</td>
                        <td>Muhammad Julian Firdaus</td>
                        <td>232</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="date-cell">2021-10-01</td>
                        <td>Survei Biaya Hidup</td>
                        <td>Muhammad Julian Firdaus</td>
                        <td>232</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td class="date-cell">2021-10-01</td>
                        <td>Survei Biaya Hidup</td>
                        <td>Muhammad Julian Firdaus</td>
                        <td>232</td>
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
