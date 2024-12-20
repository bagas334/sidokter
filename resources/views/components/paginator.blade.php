@props(['paginator'])

<div class="flex flex-row items-center justify-between w-full">
    <span class="text-sm text-gray-400">
        Menampilkan
        <span class="font-semibold text-gray-900">{{ $paginator->firstItem() }}</span>
        sampai
        <span class="font-semibold text-gray-900">{{ $paginator->lastItem() }}</span>
        dari
        <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span>
        entri
    </span>

    <div class="inline-flex mt-2 xs:mt-0 space-x-0.5">
        {{ $paginator->links() }}
    </div>

    <div class="inline-flex mt-2 xs:mt-0 space-x-0.5">

        @if($paginator->onFirstPage())
            <button disabled
                    class="btn bg-gray-300 border-0 text-gray-50 justify-between self-center btn-sm w-24 flex items-center rounded-r-none"
                    role="button">
                <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 5H1m0 0 4 4M1 5l4-4"/>
                </svg>
                Prev
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="btn bg-teal-700 border-0 text-gray-50 justify-between self-center btn-sm w-24 hover:bg-teal-600 flex items-center rounded-r-none"
               role="button">
                <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 5H1m0 0 4 4M1 5l4-4"/>
                </svg>
                Prev
            </a>
        @endif


        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="btn bg-teal-700 border-0 text-gray-50 justify-between self-center btn-sm w-24 hover:bg-teal-600 flex items-center rounded-l-none"
               role="button">
                Next
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
        @else
            <button disabled
                    class="btn bg-gray-300 border-0 text-gray-50 justify-between self-center btn-sm w-24 flex items-center rounded-l-none"
                    role="button">
                Next
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </button>
        @endif
    </div>
</div>
