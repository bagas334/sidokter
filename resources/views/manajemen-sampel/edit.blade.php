@php
    $seeder_modal_id = 'seeder-modal';
@endphp

@extends('components.layout')

@section('title', 'Edit Sampel Kegiatan')

@section('content')
    <div class="size-full flex flex-col items-center px-4 py-6">
        <div class="w-full bg-white shadow-lg rounded-lg p-6">
            <div class="w-full pb-6 flex">
                <x-judul text="Edit Sampel"/>
                <x-button.finalisasi :route="'kegiatan-finalisasi'" :id="request()->route('id')"/>
                <x-button.seeder :route="'sampel-seeder'" :modal_id="$seeder_modal_id">
                    Seeder
                </x-button.seeder>
            </div>

            <form action="{{ route('sampel-edit-save', $kegiatan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <x-input.text-field :label="'Nama Kegiatan'"
                                    :name="'nama'"
                                    :value="$kegiatan->nama"
                                    required
                                    disabled/>

                <x-input.text-field :label="'Asal Fungsi'"
                                    :name="'asal_fungsi'"
                                    :value="$kegiatan->asal_fungsi"
                                    required
                                    disabled/>

                <x-input.text-field :label="'Jumlah Sampel'"
                                    :name="'banyak_sampel'"
                                    :value="$kegiatan->banyak_sampel"
                                    required
                                    disabled/>


                <x-input.text-field :label="'Status Sampel'"
                                    :name="'status_sampel'"
                                    :value="$kegiatan->status_sampel"
                                    required
                                    disabled/>

                <div class="w-full pb-2 grid grid-cols-2 gap-3">
                    <div class="w-full pb-2">
                        <p class="text-lg text-cyan-950 font-medium">Daftar Perusahaan</p>
                        <div class="my-2 flex flex-col justify-center overflow-auto max-w-[46vw]">
                            <div class="relative max-h-96">
                                <table class="table-custom">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="w-8 text-center">No</th>
                                        <th scope="col" class="w-52">Nama</th>
                                    </tr>
                                    </thead>
                                    <tbody id="daftar-perusahaan">
                                        @foreach ($daftar_perusahaan as $item)
                                            <tr class="cursor-pointer hover:bg-gray-100 active:bg-gray-200 transition duration-150 ease-in-out" data-id="{{$item->id}}">
                                                <td class="text-center border-b border-gray-200 py-2">{{$loop->iteration}}</td>
                                                <td class="border-b border-gray-200 py-2">{{$item->nama_usaha}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="w-full pb-2">
                        <p class="text-lg text-cyan-950 font-medium flex justify-between items-center">
                            Sampel Terpilih
                            <span id="sampel-counter" class="text-sm text-gray-600">(0 Sampel)</span>
                        </p>
                        <div class="my-2 flex flex-col justify-center overflow-auto max-w-[46vw]">
                            <div class="relative max-h-96">
                                <table class="table-custom">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="w-8 text-center">No</th>
                                        <th scope="col" class="w-52">Nama</th>
                                    </tr>
                                    </thead>
                                    <tbody id="daftar-sampel">
                                        @foreach ($daftar_sampel as $index => $sampel)
                                            <tr class="cursor-pointer hover:bg-gray-100 active:bg-gray-200 transition duration-150 ease-in-out" data-id="{{$sampel->perusahaan_id}}">
                                                <td class="text-center border-b border-gray-200 py-2">{{$loop->iteration}}</td>
                                                <td class="border-b border-gray-200 py-2">{{$sampel->nama_perusahaan}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="selected-samples-container"></div>

                <div class="w-full flex justify-end pt-4">
                    <x-submit-button>
                        Simpan Perubahan
                    </x-submit-button>
                </div>
            </form>
        </div>
    </div>

    <x-modal.upload-seeder
        :id="$seeder_modal_id"
        :route_template="'template-sampel'"
        :route_seeder="'sampel-seeder'"
        :use_id="true"/>
    <script>
        const maxSampelLimit = {{ $kegiatan->banyak_sampel }};

        document.addEventListener('DOMContentLoaded', function() {
            // Get the tables and the hidden inputs container
            const daftarPerusahaanTable = document.getElementById('daftar-perusahaan');
            const daftarSampelTable = document.getElementById('daftar-sampel');
            const sampelCounter = document.getElementById('sampel-counter');
            const selectedSamplesContainer = document.getElementById('selected-samples-container');

            // Initial call to update the counter based on prepopulated rows
            updateSampelCounter();
            updateHiddenInputs();

            // Listen for clicks on the Daftar Perusahaan rows
            daftarPerusahaanTable.addEventListener('click', function(event) {
                const targetRow = event.target.closest('tr');

                if (targetRow) {
                    // Check if we've reached the maximum number of samples
                    if (daftarSampelTable.rows.length >= maxSampelLimit) {
                        alert(`You have reached the maximum limit of ${maxSampelLimit} samples.`);
                        return;
                    }

                    // Remove the row from Daftar Perusahaan
                    daftarPerusahaanTable.removeChild(targetRow);

                    // Add the row to Daftar Sampel
                    daftarSampelTable.appendChild(targetRow);

                    // Update the numbering, counter, and hidden inputs
                    updateTableNumbers(daftarPerusahaanTable);
                    updateTableNumbers(daftarSampelTable);
                    updateSampelCounter();
                    updateHiddenInputs();
                }
            });

            // Listen for clicks on the Daftar Sampel rows (to undo selection)
            daftarSampelTable.addEventListener('click', function(event) {
                const targetRow = event.target.closest('tr');

                if (targetRow) {
                    // Remove the row from Daftar Sampel
                    daftarSampelTable.removeChild(targetRow);

                    // Add the row back to Daftar Perusahaan
                    daftarPerusahaanTable.appendChild(targetRow);

                    // Update the numbering, counter, and hidden inputs
                    updateTableNumbers(daftarPerusahaanTable);
                    updateTableNumbers(daftarSampelTable);
                    updateSampelCounter();
                    updateHiddenInputs();
                }
            });

            // Function to update row numbers in the tables
            function updateTableNumbers(table) {
                Array.from(table.rows).forEach((row, index) => {
                    row.cells[0].textContent = index + 1;
                });
            }

            // Function to update the sample counter
            function updateSampelCounter() {
                const rowCount = daftarSampelTable.rows.length;
                sampelCounter.textContent = `(${rowCount} Sampel)`;
            }

            // Function to update hidden inputs for selected samples
            function updateHiddenInputs() {
                // Clear the container
                selectedSamplesContainer.innerHTML = '';

                // Iterate through the selected samples and create hidden inputs
                Array.from(daftarSampelTable.rows).forEach(row => {
                    const sampleId = row.getAttribute('data-id');

                    if (sampleId) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'sampel_baru[]';
                        input.value = sampleId;
                        selectedSamplesContainer.appendChild(input);
                    }
                });
            }
        });
    </script>
@endsection
