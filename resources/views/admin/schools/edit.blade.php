@extends('layouts.sidebar-app')
@section('title', 'Edit School')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4">Edit School</h2>

  @if(session('success'))
    <div class="mb-4 text-green-700 bg-green-100 border border-green-200 px-3 py-2 rounded">
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="mb-4 text-red-700 bg-red-100 border border-red-200 px-3 py-2 rounded">
      {{ session('error') }}
    </div>
  @endif

  <form method="POST" action="{{ route('admin.schools.update', $school) }}">
    @csrf
    @method('PUT')

    <label class="block text-sm font-medium text-gray-700 mb-1">School Name</label>
    <input
      type="text"
      name="name"
      value="{{ old('name', $school->name) }}"
      class="w-full border rounded px-3 py-2 mb-2"
      required
    >
    @error('name')
      <p class="text-red-600 text-sm mb-3">{{ $message }}</p>
    @enderror

    <div class="flex gap-2 mt-3">
      <a href="{{ route('admin.schools.index') }}" class="px-4 py-2 rounded border">Cancel</a>
      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save changes</button>
    </div>
  </form>
</div>
@endsection
