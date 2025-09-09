@extends('layouts.sidebar-app')
@section('title', 'Edit Event')

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-4xl mx-auto"
     x-data="editEvent()">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Event</h2>

    @if($errors->any())
      <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.events.update', $event) }}">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Event Name</label>
        <input type="text" name="event_name" required
               x-model="eventName"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Number of Days</label>
        <input type="number" name="day_count" min="1" max="10" required
               x-model.number="dayCount"
               @input="resizeDays()"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
      </div>

      <div class="space-y-6">
        <template x-for="(inds, i) in days" :key="i">
          <div class="p-4 bg-gray-50 rounded-md border">
            <label class="block text-sm font-medium text-gray-700 mb-2"
                   x-text="`Industries for Day ${i + 1}`"></label>

            <template x-for="(val, j) in inds" :key="j">
              <input type="text"
                     class="w-full rounded-md border-gray-300 shadow-sm mb-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                     :name="`industries[${i}][]`"
                     x-model="days[i][j]" />
            </template>

            <button type="button"
                    @click="days[i].push('')"
                    class="text-blue-600 text-sm font-medium">+ Add another</button>
          </div>
        </template>
      </div>

      <!-- Hidden mirrors for name/day_count so backend receives them -->
      <input type="hidden" name="event_name" :value="eventName">
      <input type="hidden" name="day_count" :value="dayCount">

      <div class="mt-6 flex gap-2">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded border">Cancel</a>
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-md font-semibold text-white hover:bg-blue-700">
          Save Changes
        </button>
      </div>
    </form>
</div>

<script>
function editEvent() {
  return {
    eventName: @json(old('event_name', $event->name)),
    dayCount:  Number(@json(old('day_count', $event->days->count()))),
    // Preload industry names per day (array of arrays)
    days: @json(
      $event->days->sortBy('id')->values()->map(fn($d) =>
        $d->industries->pluck('name')->values()
      )
    ),

    resizeDays() {
      // Ensure days.length matches dayCount
      if (this.days.length < this.dayCount) {
        while (this.days.length < this.dayCount) this.days.push(['']);
      } else if (this.days.length > this.dayCount) {
        this.days.splice(this.dayCount);
      }
    },

    init() { this.resizeDays(); }
  }
}
</script>
@endsection
