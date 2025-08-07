@extends('layouts.sidebar-app')
@section('title', 'All Students')

@section('content')
<div x-data="studentTable()" class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-700">📋 Registered Students</h2>
        <input
            type="text"
            placeholder="Search students..."
            x-model="search"
            class="border rounded px-3 py-2 w-64 shadow-sm focus:outline-none focus:ring focus:ring-blue-200"
        />
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
            filteredStudents() {
                if (!this.search) return this.students;
                return this.students.filter(student =>
                    Object.values(student).some(val =>
                        String(val).toLowerCase().includes(this.search.toLowerCase())
                    )
                );
            }
        }
    }
</script>
@endsection
