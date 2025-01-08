<div class="navbar bg-gray-50 px-12">
    <div class="flex-1">
        <a class="text-3xl font-bold text-teal-600">SiDokter <span class="text-sm py-1 px-2 bg-green-200 rounded-xl">0.8.11</span><span class="text-sm py-1 px-2 bg-green-200 rounded-xl mx-2">WIJAYAKUSUMA!</span></a>
    </div>
    <div class="flex-none">
        <div class="dropdown dropdown-bottom relative flex items-center">
            <div class="pr-3 text-right">
                <p class="text-sm text-teal-900 font-bold">{{ auth()->user()->nama }}</p>
                <p class="text-sm text-teal-900">
                    {{ auth()->user()->jabatan }}
                    @if(auth()->user()->jabatan == 'Ketua Tim')
                    <span>{{ auth()->user()->fungsi_ketua_tim }}</span>
                    @endif
                </p>
            </div>
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <div class="rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.0" stroke="currentColor" class="size-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
            </div>
            <ul
                tabindex="0"
                class="menu menu-sm dropdown-content bg-white rounded-lg z-[1] mt-2 w-28 p-2 shadow-md text-gray-700 absolute right-0">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="flex items-center w-full px-2 py-1 text-sm font-semibold text-red-500 hover:text-white hover:bg-red-500 rounded-md transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25a2.25 2.25 0 1 0-4.5 0V9m4.5 6v3.75a2.25 2.25 0 1 1-4.5 0V15M19.5 12h-15" />
                        </svg>
                        Logout
                    </button>
                </form>
            </ul>
        </div>
    </div>
</div>