@props(['id', 'route', 'parameters'])

<a href="{{ route($route, $parameters) }}" class="w-20 inline-flex items-center justify-center py-1 border border-transparent text-xs font-medium rounded-md text-white bg-yellow-400 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
    Edit
</a>