@extends('components.layout')

@section('title', 'Tambah File Mitra')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Upload File Mitra</h1>

    <!-- Form untuk upload file excel -->
    <form action="{{ route('import-mitra') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Input File -->
        <div class="mb-4">
            <label for="file" class="block text-sm font-medium text-gray-700">Pilih file Excel (.xls atau .xlsx)</label>
            <input type="file" name="file" id="file" class="mt-2 p-2 border border-gray-300 rounded-md w-full" required>
        </div>

        <!-- Button Submit -->
        <div>
            <button type="submit" class="px-6 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-200">Upload</button>
        </div>
    </form>

    <!-- Pesan Sukses atau Error -->
    @if(session('success'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded-md">
            {{ session('error') }}
        </div>
    @endif
</div>
@endsection
