@extends('layouts.sidebar-app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">All Events</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $event->name }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $event->days->count() }} Day(s)</p>
                <ul class="text-sm text-gray-700 list-disc pl-5">
                    @foreach($event->days as $day)
                        <li class="mb-1">
                            <strong>{{ $day->name }}:</strong>
                            {{ $day->industries->pluck('name')->join(', ') }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>
@endsection
