@extends('layouts.sidebar-app')

@section('title', 'Create Event')

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create New Event</h2>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.events.store') }}">
        @csrf

        <div class="mb-4">
            <label for="event_name" class="block text-sm font-medium text-gray-700">Event Name</label>
            <input type="text" name="event_name" id="event_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
        </div>

        <div class="mb-4">
            <label for="day_count" class="block text-sm font-medium text-gray-700">Number of Days</label>
            <input type="number" name="day_count" id="day_count" min="1" max="10" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
        </div>

        <div id="industryFields" class="space-y-6"></div>

        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Create Event
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('day_count').addEventListener('input', function () {
        const count = parseInt(this.value);
        const container = document.getElementById('industryFields');
        container.innerHTML = '';

        for (let i = 0; i < count; i++) {
            const group = document.createElement('div');
            group.classList.add('p-4', 'bg-gray-50', 'rounded-md', 'border');

            group.innerHTML = `
                <label class="block text-sm font-medium text-gray-700 mb-2">Industries for Day ${i + 1}</label>
                <input type="text" name="industries[${i}][]" class="w-full rounded-md border-gray-300 shadow-sm mb-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Industry Name" />
                <button type="button" onclick="addIndustryInput(this, ${i})" class="text-blue-600 text-sm font-medium">+ Add another</button>
            `;
            container.appendChild(group);
        }
    });

    function addIndustryInput(button, dayIndex) {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = `industries[${dayIndex}][]`;
        input.placeholder = 'Industry Name';
        input.className = 'w-full rounded-md border-gray-300 shadow-sm mb-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50';
        button.parentNode.insertBefore(input, button);
    }
</script>
@endsection
