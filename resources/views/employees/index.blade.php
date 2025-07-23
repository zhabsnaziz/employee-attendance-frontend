@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Employees</h2>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">+ Add Employee</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Department</th>
                <th style="width: 150px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $emp)
            <tr>
                <td>{{ $emp['employee_id'] }}</td>
                <td>{{ $emp['name'] }}</td>
                <td>{{ $emp['address'] }}</td>
                <td>{{ $emp['department']['department_name'] ?? '-' }}</td>
                <td>
                    <a href="{{ route('employees.edit', $emp['id']) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" class="d-inline delete-form" data-id="{{ $emp['id'] }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No employees found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to delete this employee?')) return;

            const id = form.dataset.id;
            const token = form.querySelector('input[name="_token"]').value;

            try {
                const response = await fetch(`/employees/${id}/delete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                });

                const contentType = response.headers.get('content-type');
                let data;

                if (contentType && contentType.includes('application/json')) {
                    data = await response.json();
                } else {
                    const raw = await response.text();
                    console.error('Non-JSON response:', raw);
                    throw new Error('Invalid response type');
                }

                if (response.ok) {
                    alert(data.message || 'Employee deleted successfully');
                    form.closest('tr').remove();
                } else {
                    alert(data.message || 'Failed to delete employee');
                }
            } catch (error) {
                console.error('Fetch error:', error);
                alert('Something went wrong. Please try again later.');
            }
        });
    });
});
</script>
@endsection
