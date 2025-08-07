@extends('layouts.sidebar-app')

@section('title', 'Add School')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-xl mx-auto">
    <form method="POST" action="{{ route('admin.schools.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">School Name</label>
            <input type="text" name="name" required class="w-full border rounded p-2" />
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save School
        </button>
    </form>
</div>
@endsection
