@extends('layouts.sidebar-app')

@section('title', 'All Schools')

@section('content')
<div x-data="schoolList()" class="bg-white rounded shadow p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-700">🏫 Schools</h2>
        <div class="flex gap-3 items-center">
            <input
                type="text"
                x-model="search"
                placeholder="Search school..."
                class="border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-blue-200"
            />
            <a href="{{ route('admin.schools.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                ➕ Add School
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
                <tr>
                    <th class="border px-4 py-2 text-left">#</th>
                    <th class="border px-4 py-2 text-left">School Name</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(school, index) in filteredSchools()" :key="school.id">
                    <tr class="text-gray-800 text-sm">
                        <td class="border px-4 py-2" x-text="index + 1"></td>
                        <td class="border px-4 py-2" x-text="school.name"></td>
                    </tr>
                </template>
                <template x-if="filteredSchools().length === 0">
                    <tr>
                        <td colspan="2" class="text-center text-gray-500 py-4">No schools match your search.</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

<script>
    function schoolList() {
        return {
            search: '',
            schools: @json($schools),
            filteredSchools() {
                if (!this.search) return this.schools;
                return this.schools.filter(school =>
                    school.name.toLowerCase().includes(this.search.toLowerCase())
                );
            }
        }
    }
</script>
@endsection
