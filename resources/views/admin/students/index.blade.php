@extends('layouts.sidebar-app')
@section('title', 'All Students')

@section('content')
<div x-data="studentTable()" class="bg-white p-6 rounded shadow">
    <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-700">📋 Registered Students</h2>

        <div class="flex gap-2">
            <input
                type="text"
                placeholder="Search students..."
                x-model="search"
                class="border rounded px-3 py-2 w-64 shadow-sm focus:outline-none focus:ring focus:ring-blue-200"
            />
            <a :href="exportUrl()" class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700">⬇ Export CSV</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
                <tr>
                    <th class="border px-3 py-2">Name</th>
                    <th class="border px-3 py-2">Surname</th>
                    <th class="border px-3 py-2">Email</th>
                    <th class="border px-3 py-2">Phone</th>
                    <th class="border px-3 py-2">ID</th>
                    <th class="border px-3 py-2">Student #</th>
                    <th class="border px-3 py-2">Grade</th>
                    <th class="border px-3 py-2">School</th>
                    <th class="border px-3 py-2">Event Day</th>
                    <th class="border px-3 py-2">Industry</th>
                    <th class="border px-3 py-2">Attended</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="student in filteredStudents()" :key="student.id">
                    <tr class="text-sm text-gray-800">
                        <td class="border px-3 py-2" x-text="student.name"></td>
                        <td class="border px-3 py-2" x-text="student.surname"></td>
                        <td class="border px-3 py-2" x-text="student.email || '-'"></td>
                        <td class="border px-3 py-2" x-text="student.phone || '-'"></td>
                        <td class="border px-3 py-2" x-text="student.id_number || '-'"></td>
                        <td class="border px-3 py-2" x-text="student.studentnum"></td>
                        <td class="border px-3 py-2" x-text="student.grade"></td>
                        <td class="border px-3 py-2" x-text="student.school"></td>
                        <td class="border px-3 py-2" x-text="student.day"></td>
                        <td class="border px-3 py-2" x-text="student.industry"></td>
                        <td class="border px-3 py-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox"
                                       :checked="student.attended"
                                       @change="toggleAttendance(student, $event.target.checked)"
                                       class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-xs text-gray-500" x-text="student.checked_in_at ? ('(' + student.checked_in_at + ')') : ''"></span>
                            </label>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

<script>
function studentTable() {
    return {
        search: '',
        students: @json($students),
        csrf: '{{ csrf_token() }}',
        filteredStudents() {
            if (!this.search) return this.students;
            const needle = this.search.toLowerCase();
            return this.students.filter(s =>
                Object.values(s).some(v => String(v ?? '').toLowerCase().includes(needle))
            );
        },
        exportUrl() {
            const params = new URLSearchParams();
            if (this.search) params.set('search', this.search);
            return `{{ route('admin.students.export') }}?` + params.toString();
        },

        async toggleAttendance(student, attended) {
            try {
                const res = await fetch(`{{ url('/admin/students') }}/${student.id}/attendance`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': this.csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin', // ensure session cookie is sent
                    body: JSON.stringify({ attended: attended ? 1 : 0 })
                });

                if (!res.ok) {
                    const text = await res.text();
                    alert(`Failed to update attendance (HTTP ${res.status}).\n\n${text}`);
                    return;
                }

                const data = await res.json();
                if (!data.ok) {
                    alert(data.message || 'Failed to update attendance.');
                    return;
                }

                student.attended = data.attended;
                student.checked_in_at = data.checked_in_at;
            } catch (e) {
                alert('Network error updating attendance.');
            }
        }

    }
}
</script>
@endsection
