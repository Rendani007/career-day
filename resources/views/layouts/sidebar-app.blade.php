<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Admin') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white shadow-md border-r">
        <div class="p-6 text-xl font-bold border-b">
            Admin Panel
        </div>
        <nav class="px-4 py-6 space-y-2 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 font-semibold' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('admin.events.create') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.events.create') ? 'bg-gray-200 font-semibold' : '' }}">📅 Create Event</a>
           <a href="{{ route('admin.students.index') }}"
            class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.students.index') ? 'bg-gray-200 font-semibold' : '' }}">
            👥 All Students
            </a>
            <a href="{{ route('admin.schools.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.schools.index') ? 'bg-gray-200 font-semibold' : '' }}">🏫 All Schools</a>
            <a href="{{ route('admin.schools.create') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.schools.create') ? 'bg-gray-200 font-semibold' : '' }}">➕ Add School</a>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('profile.edit') ? 'bg-gray-200 font-semibold' : '' }}">
                👤 Profile
            </a>

        </nav>

    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-6">
        <header class="mb-6">
            <h1 class="text-2xl font-bold">@yield('title', 'Admin')</h1>
        </header>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>
