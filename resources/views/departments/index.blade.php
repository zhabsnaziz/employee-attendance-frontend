@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Departments</h2>
    <a href="{{ route('departments.create') }}" class="btn btn-primary">+ Add Department</a>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Name</th>
            <th>Max Clock In</th>
            <th>Max Clock Out</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($departments as $dept)
            <tr>
                <td>{{ $dept['department_name'] }}</td>
                <td>{{ $dept['max_clock_in_time'] }}</td>
                <td>{{ $dept['max_clock_out_time'] }}</td>
                <td>
                    <a href="{{ route('departments.edit', $dept['id']) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                    <form method="POST" class="d-inline delete-form" data-id="{{ $dept['id'] }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No departments found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Script --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to delete this department?')) {
                return;
            }

            const id = form.dataset.id;
            const token = form.querySelector('input[name="_token"]').value;

            try {
                const response = await fetch(`/departments/${id}/delete`, {
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
                    alert(data.message || 'Department deleted successfully');
                    form.closest('tr').remove();
                } else {
                    alert(data.message || 'Failed to delete department');
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
