@extends('components.layout')

@section('title', 'Manajemen Sampel')


@section('content')
<style>
    th,
    td {
        border: solid gray;
        border-collapse: collapse;
    }
</style>

<div class="text-black">
    <p>Manajemen sampel</p>

    Daftar sampel
    <a href="{{route('sampel-create')}}">[Tambah Sampel]</a>
    <table class="">
        <tr class="">
            <th>No</th>
            <th>Nama sampel</th>
            <th>Tanggal dibuat</th>
            <th>Pembuat</th>
            <th>Kegiatan</th>
            <th>Aksi</th>
            <th>Catatan</th>
        </tr>
        @foreach($sampel as $item)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$item->nama}}</td>
            <td>{{$item->created_at}}</td>
            <td>{{$item->pegawai->nama}}</td>
            <td>
                @if($item->kegiatan)
                {{$item->kegiatan->nama}}
                @else
                Tidak ada
                @endif
            </td>
            <td>
                <a href="{{ route('sampel-detail', ['id' => $item->id]) }}">[Detail]</a>
            </td>
            <td>{{$item->catatan}}</td>
        </tr>
        @endforeach
    </table>
</div>

@endsection