@props(['id', 'route'])

<a href="{{ route($route, $id) }}" class="w-16 inline-flex items-center justify-center py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
    View
</a>
