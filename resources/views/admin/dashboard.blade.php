@extends('layouts.sidebar-app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto p-6"
     x-data="{
        csrf: '{{ csrf_token() }}',
        async del(id, name){
          if(!confirm(`Delete \"${name}\"? This cannot be undone.`)) return;
          try{
            const res = await fetch(`{{ url('/admin/events') }}/${id}`, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': this.csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
              },
              credentials: 'same-origin'
            });
            if(!res.ok){
              const t = await res.text();
              alert(`Failed to delete (HTTP ${res.status}).\n\n${t}`);
              return;
            }
            // remove the card from the DOM
            document.getElementById(`event-card-${id}`)?.remove();
          }catch(e){
            alert('Network error while deleting.');
          }
        }
     }">

  <h2 class="text-2xl font-bold text-gray-800 mb-6">All Events</h2>

  @if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
      {{ session('error') }}
    </div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($events as $event)
      <div id="event-card-{{ $event->id }}" class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-start justify-between gap-3 mb-2">
          <h3 class="text-lg font-semibold text-gray-800">{{ $event->name }}</h3>
          <div class="flex items-center gap-2">
            <a href="{{ route('admin.events.edit', $event) }}"
               class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600">
              ✏️ Edit
            </a>
            <button @click="del('{{ $event->id }}','{{ addslashes($event->name) }}')"
                    class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
              🗑️ Delete
            </button>
          </div>
        </div>

        <p class="text-sm text-gray-500 mb-4">{{ $event->days->count() }} Day(s)</p>
        <ul class="text-sm text-gray-700 list-disc pl-5">
          @foreach($event->days as $day)
            <li class="mb-1">
              <strong>{{ $day->name }}:</strong>
              {{ $day->industries->pluck('name')->join(', ') ?: '—' }}
            </li>
          @endforeach
        </ul>
      </div>
    @empty
      <p class="text-gray-500">No events yet.</p>
    @endforelse
  </div>
</div>
@endsection
