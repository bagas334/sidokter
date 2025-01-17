@extends('components.layout')

@section('title', 'Tambah File Mitra')

@section('content')
<div class="container mx-auto px-6 py-8 bg-white rounded-lg shadow-lg">
    <h1 class="text-4xl font-semibold mb-6 text-center text-teal-700">Upload File Mitra</h1>

    <!-- Form untuk upload file excel -->
    <form action="{{ route('import-mitra') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Input File -->
        <div>
            <label for="file" class="block text-lg font-medium text-gray-700">Pilih file Excel (.xls atau .xlsx)</label>
            <input type="file" name="file" id="file" class="mt-2 p-3 border border-gray-300 rounded-md w-full shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200" required>
        </div>

        <!-- Button Submit -->
        <div>
            <button type="submit" class="w-full px-6 py-3 text-lg bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200">
                Upload
            </button>
        </div>
    </form>

    <!-- Pesan Sukses atau Error -->
    @if(session('success'))
    <div class="mt-6 p-4 bg-teal-100 text-teal-700 border border-teal-300 rounded-lg">
        <span class="font-semibold text-lg">{{ session('success') }}</span>
    </div>
    @elseif(session('error'))
    <div class="mt-6 p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg">
        <span class="font-semibold text-lg">{{ session('error') }}</span>
    </div>
    @endif
</div>
@endsection