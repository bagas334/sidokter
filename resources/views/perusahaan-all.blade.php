@extends('components.layout')

@section('title', 'Semua Perusahaan')

@section('content')
<div class="size-full flex flex-col w-full items-center px-4">
    {{-- Judul --}}
    <div class="w-full pb-6 text-center">
        <x-judul text="Semua Perusahaan" />
    </div>

    <div class="flex flex-col justify-center overflow-x-hidden max-w-full"> <!-- Ubah overflow-x-auto menjadi overflow-x-hidden -->
        <div class="relative text-center">
            <table class="table-custom border-collapse border border-gray-300 w-full"> <!-- Menambahkan w-full untuk memastikan lebar tabel sesuai dengan container -->
                <thead class="bg-gray-200">
                    <tr>
                        <th scope="col" rowspan="2" class="text-center border border-gray-300 px-2 py-1">No</th>
                        <th scope="col" rowspan="2" class="text-center border border-gray-300 px-2 py-1">ID SBR</th>
                        <th scope="col" rowspan="2" class="text-center border border-gray-300 px-2 py-1">Kode Wilayah</th>
                        <th scope="col" rowspan="2" class="text-center border border-gray-300 px-2 py-1">Nama Usaha</th>
                        <th scope="col" rowspan="2" class="text-center border border-gray-300 px-2 py-1">SLS</th>
                        <th scope="col" rowspan="2" class="text-center border border-gray-300 px-2 py-1">Alamat Detail</th>
                        <th scope="col" rowspan="2" class="text-center border border-gray-300 px-2 py-1">Kode KBLI</th>
                        <th scope="col" rowspan="2" class="text-center border border-gray-300 px-2 py-1">Nama CP</th>
                        <th scope="col" rowspan="2" class="text-center border border-gray-300 px-2 py-1">Nomor CP</th>
                        <th scope="col" rowspan="2" class="text-center border border-gray-300 px-2 py-1">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perusahaan as $item)
                    <tr class="even:bg-gray-100 odd:bg-white">
                        <td class="text-center border border-gray-300 px-2 py-1">{{ $loop->iteration + ($perusahaan->currentPage() - 1) * $perusahaan->perPage() }}</td>
                        <td class="text-center border border-gray-300 px-2 py-1">{{ $item->idsbr }}</td>
                        <td class="text-center border border-gray-300 px-2 py-1">{{ $item->kode_wilayah }}</td>
                        <td class="text-center border border-gray-300 px-2 py-1">{{ $item->nama_usaha }}</td>
                        <td class="text-center border border-gray-300 px-2 py-1">{{ $item->sls }}</td>
                        <td class="text-center border border-gray-300 px-2 py-1">{{ $item->alamat_detail }}</td>
                        <td class="text-center border border-gray-300 px-2 py-1">{{ $item->kode_kbli }}</td>
                        <td class="text-center border border-gray-300 px-2 py-1">{{ $item->nama_cp }}</td>
                        <td class="text-center border border-gray-300 px-2 py-1">{{ $item->nomor_cp }}</td>
                        <td class="text-center border border-gray-300 px-2 py-1">{{ $item->email }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Pagination --}}
    <x-paginator :paginator="$perusahaan" />
</div>
@endsection