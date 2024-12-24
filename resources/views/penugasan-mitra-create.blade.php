@extends('components.layout')

@section('title', 'Buat Penugasan Mitra')

@section('content')

<div class="size-full flex flex-col items-center px-4 py-6">
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="w-full pb-6 flex">
            <x-judul text="Buat Penugasan Mitra" />
        </div>

        <form action="{{ route('penugasan-mitra-create-save', ['id' => $id]) }}" method="POST">
            @csrf
            @method('POST')


            <input type="text" name="kegiatan_id" value="{{$id}}" hidden>

            <x-input.dropdown-mitra :label="'Mitra'"
                :options="$mitra"
                :name="'petugas'"
                required></x-input.dropdown-mitra>



            <x-input.double-input-layout
                :label="'Kuantitas'"
                :name="'kuantitas'">
                <x-input.number-field
                    :label="'Target'"
                    :name="'target'"
                    id="target"
                    :label_size="'md'"></x-input.number-field>
            </x-input.double-input-layout>

            <div class="mb-1 text-gray-500">Potensi pendapatan mitra : <span id="pendapatan"></span></div>


            <x-input.text-area
                :label="'Catatan'"
                :name="'catatan'"></x-input.text-area>

            <div class="w-full flex justify-end pt-4" id="submitButton" style="display: block;">
                <x-submit-button>
                    Buat Penugasan
                </x-submit-button>
            </div>
        </form>
    </div>
</div>

<script>
    // Get the PHP variable and ensure it's passed as a number

    const pendapatan = <?php echo json_encode((float) $kegiatan->harga_satuan); ?>;
    const pendapatan_awal = <?php echo json_encode((float) $kegiatan->harga_satuan); ?>;
    const submitButton = document.getElementById('submitButton');

    // Get the DOM elements
    const pendapatanTextField = document.getElementById('pendapatan');
    const target = document.getElementById('target');

    // Add an event listener to detect changes in the target input field
    target.addEventListener('input', function() {
        const targetValue = parseFloat(target.value) || 0; // Get the value as a number or default to 0
        pendapatanTextField.innerText = pendapatan * targetValue; // Update the text field

        if (pendapatan * targetValue > 4000000) {
            submitButton.style.display = 'none';
        } else {
            submitButton.style.display = 'block';
        }
    });
</script>

@endsection