@props(['id', 'route_template', 'route_seeder', 'use_id' => false])

<div id={{ $id }} tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-cyan-950">
                    Unggah file
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="{{ $id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <div>
                    <p class="text-md text-cyan-950">
                        Download template untuk file seeder <a href="{{ route($route_template) }}" class="text-blue-700 hover:underline">di sini</a>.
                    </p>
                </div>
                <form class="space-y-4"
                      action="{{ $use_id ? route($route_seeder, request()->route('id')) : route($route_seeder) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                           id="seeder_input" name="seeder_file" type="file">

                    <div class="flex justify-end mt-4">
                        <x-submit-button>
                            Unggah
                        </x-submit-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
