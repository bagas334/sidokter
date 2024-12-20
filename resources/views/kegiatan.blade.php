@extends('components.layout')

@section('title', 'Kegiatan')

@section('content')
    <div class="size-full bg-gray-50 flex flex-col w-full items-center">
        {{--        Judul--}}
        <div class="w-full">
            <h1 class="text-4xl font-bold text-teal-600 mb-8 pl-6">Daftar Kegiatan</h1>
        </div>

        {{--        Pencarian dan Periode--}}
        <div class="w-full flex flex-row justify-between items-center pr-4">
            {{-- Dropdown Button --}}
            <div class="flex items-center">
                <div class="dropdown dropdown-bottom pl-6">
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
            <div class="relative flex items-center w-64">
                <input type="text"
                       class="input pl-10 m-2 w-full bg-gray-50 border border-gray-300 rounded-md input-sm focus:outline-none focus:ring-1 focus:ring-teal-600 focus:border-teal-600 peer"
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
        <div class="w-full flex flex-col justify-center px-6 pb-12">
            <table class="table w-full table-sm">
                <thead class="bg-teal-600 text-gray-50 text-sm">
                <tr>
                    <th></th>
                    <th>Tanggal</th>
                    <th>Kegiatan</th>
                    <th>Volume</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah Biaya</th>
                </tr>
                </thead>
                <tbody class="bg-gray-50 text-cyan-950">
                <tr>
                    <th class="text-teal-800">1</th>
                    <td>2021-10-01</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">2</th>
                    <td>2021-10-02</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">3</th>
                    <td>2021-10-03</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">4</th>
                    <td>2021-10-04</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">5</th>
                    <td>2021-10-05</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">1</th>
                    <td>2021-10-01</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">2</th>
                    <td>2021-10-02</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">3</th>
                    <td>2021-10-03</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">4</th>
                    <td>2021-10-04</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">5</th>
                    <td>2021-10-05</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">1</th>
                    <td>2021-10-01</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">2</th>
                    <td>2021-10-02</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">3</th>
                    <td>2021-10-03</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">4</th>
                    <td>2021-10-04</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                <tr>
                    <th class="text-teal-800">5</th>
                    <td>2021-10-05</td>
                    <td>Meeting</td>
                    <td>1</td>
                    <td>jam</td>
                    <td>100000</td>
                    <td>100000</td>
                </tr>
                </tbody>
            </table>

            <div class="flex flex-row items-center justify-between">
                <span class="text-sm text-gray-700 dark:text-gray-400">
                    Showing
                    <span class="font-semibold text-gray-900">1</span>
                    to
                    <span class="font-semibold text-gray-900">10</span>
                    of
                    <span
                        class="font-semibold text-gray-900">100</span> Entries</span>
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
