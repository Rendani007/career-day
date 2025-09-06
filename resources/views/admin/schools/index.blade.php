@extends('layouts.sidebar-app')

@section('title', 'All Schools')

@section('content')

<div
  class="bg-white rounded shadow p-6 max-w-4xl mx-auto"
  x-data='{
    search: "",
    csrf: "{{ csrf_token() }}",
    schools: @json($schools),

    filteredSchools() {
      if (!this.search) return this.schools;
      const needle = this.search.toLowerCase();
      return this.schools.filter(s => String(s.name ?? "").toLowerCase().includes(needle));
    },

    async deleteSchool(school) {
      if (!confirm(`Delete "${school.name}"? This cannot be undone.`)) return;

      try {
        const res = await fetch(`{{ url("/admin/schools") }}/${school.id}`, {
          method: "DELETE",
          headers: {
            "X-CSRF-TOKEN": this.csrf,
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
          },
          credentials: "same-origin"
        });

        if (!res.ok) {
          const text = await res.text();
          alert(`Failed to delete (HTTP ${res.status}).\n\n${text}`);
          return;
        }

        this.schools = this.schools.filter(s => s.id !== school.id);
      } catch (e) {
        alert("Network error while deleting.");
      }
    }
  }'
>

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
          <th class="border px-4 py-2 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <template x-for="(school, index) in filteredSchools()" :key="school.id">
          <tr class="text-gray-800 text-sm">
            <td class="border px-4 py-2" x-text="index + 1"></td>
            <td class="border px-4 py-2" x-text="school.name"></td>
            <td class="border px-4 py-2 text-center">
              <div class="flex justify-center gap-2">
                <a :href="`{{ url('/admin/schools') }}/${school.id}/edit`"
                   class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition-colors">
                  ✏️ Edit
                </a>
                <button @click="deleteSchool(school)"
                        class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition-colors">
                  🗑️ Delete
                </button>
              </div>
            </td>
          </tr>
        </template>

        <template x-if="filteredSchools().length === 0">
          <tr>
            <td colspan="3" class="text-center text-gray-500 py-4">No schools match your search.</td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</div>
@endsection
