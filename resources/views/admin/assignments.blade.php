<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Assign Industries to Days</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="mb-6 bg-white p-4 rounded shadow">
            <h3 class="font-semibold mb-2">Add New Industry</h3>
            <form method="POST" action="{{ route('industries.store') }}" class="flex gap-2">
                @csrf
                <input type="text" name="name" placeholder="Industry name" class="border p-2 flex-1" required>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Add</button>
            </form>
        </div>


        <form method="POST" action="{{ route('assignments.store') }}" class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label class="font-semibold block">Select Day</label>
                <select name="day_id" class="w-full border p-2" required>
                    <option value="">-- Choose a Day --</option>
                    @foreach($days as $day)
                        <option value="{{ $day->id }}">{{ $day->name }} ({{ $day->event_date }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-semibold block">Select Industries</label>
                <select name="industry_ids[]" class="w-full border p-2" multiple required>
                    @foreach($industries as $industry)
                        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                    @endforeach
                </select>
                <small class="text-sm text-gray-500">Hold Ctrl (or Cmd) to select multiple</small>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Assign</button>
        </form>

        <hr class="my-6">

        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Current Assignments</h3>
            @foreach($assignments as $assignment)
                <div class="mb-2">
                    <strong>{{ $assignment->industry->name }}</strong>
                    → {{ $assignment->day->name }} ({{ $assignment->day->event_date }})
                </div>
            @endforeach
            {{-- add delete button --}}
            <div class="flex items-center justify-between mb-2">
                <span>
                    <strong>{{ $assignment->industry->name }}</strong>
                    → {{ $assignment->day->name }} ({{ $assignment->day->event_date }})
                </span>

                <form method="POST" action="{{ route('assignments.destroy', $assignment->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Remove this assignment?')">
                        Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
