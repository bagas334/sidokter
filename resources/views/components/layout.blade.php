<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>@yield('title')</title>
    @livewireStyles
</head>
<body>
<div class="size-full flex flex-col">
    <div class="w-full border-b-[1px] border-b-gray-300">
        @include('components.navigation.navbar')
    </div>

    <div class="flex flex-row flex-1 bg-main-base size-full">
        <x-sidebar/>

        <main class="flex-1 pt-12 px-6 size-full pb-10">
            @yield('content')
        </main>
    </div>
</div>
@livewireScripts
</body>
</html>
