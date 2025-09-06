@extends('layouts.sidebar-app')
@section('title', 'Edit Student')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4">Edit Student</h2>

  <form method="POST" action="{{ route('admin.students.update', $student) }}">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $student->name) }}" class="w-full border rounded px-3 py-2" required>
        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Surname</label>
        <input type="text" name="surname" value="{{ old('surname', $student->surname) }}" class="w-full border rounded px-3 py-2" required>
        @error('surname') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $student->email) }}" class="w-full border rounded px-3 py-2">
        @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" class="w-full border rounded px-3 py-2">
        @error('phone') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">ID Number</label>
        <input type="text" name="id_number" value="{{ old('id_number', $student->id_number) }}" class="w-full border rounded px-3 py-2">
        @error('id_number') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Student #</label>
        <input type="text" name="studentnum" value="{{ old('studentnum', $student->studentnum) }}" class="w-full border rounded px-3 py-2">
        @error('studentnum') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Grade</label>
        <input type="text" name="grade" value="{{ old('grade', $student->grade) }}" class="w-full border rounded px-3 py-2">
        @error('grade') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">School</label>
        <select name="school_id" class="w-full border rounded px-3 py-2">
          <option value="">— None —</option>
          @foreach($schools as $school)
            <option value="{{ $school->id }}" @selected(old('school_id', $student->school_id) == $school->id)>
              {{ $school->name }}
            </option>
          @endforeach
        </select>
        @error('school_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>
    </div>

    <div class="mt-4 flex gap-2">
      <a href="{{ route('admin.students.index') }}" class="px-4 py-2 rounded border">Cancel</a>
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Save changes</button>
    </div>
  </form>
</div>
@endsection
