@extends('components.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="size-full flex flex-col items-center">
{{--        <x-navigation.bread-crumbs :breadcrumbs="$breadcrumbs"/>--}}
        <livewire:dashboard-stats/>
    </div>
@endsection
