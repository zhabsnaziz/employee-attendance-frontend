@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>{{ isset($employee) ? 'Edit' : 'Add' }} Employee</h2>

    <div id="alert-box" class="mt-3"></div>

    <form id="employee-form" class="mt-3">
        @csrf
        @if(isset($employee))
            <input type="hidden" name="_method" value="PUT">
        @endif

        <div class="mb-3">
            <label class="form-label">Employee ID</label>
            <input type="text" class="form-control" name="employee_id" value="{{ old('employee_id', $employee['employee_id'] ?? '') }}">
            <div class="text-danger small" id="employee_id-error"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $employee['name'] ?? '') }}">
            <div class="text-danger small" id="name-error"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" name="address" value="{{ old('address', $employee['address'] ?? '') }}">
            <div class="text-danger small" id="address-error"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Department</label>
            <select name="departement_id" class="form-select">
                <option value="">-- Select Department --</option>
                @foreach($departments as $d)
                    <option value="{{ $d['id'] }}"
                        {{ old('departement_id', $employee['departement_id'] ?? '') == $d['id'] ? 'selected' : '' }}>
                        {{ $d['department_name'] }}
                    </option>
                @endforeach
            </select>
            <div class="text-danger small" id="departement_id-error"></div>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#employee-form').on('submit', function(e) {
    e.preventDefault();

    $('.text-danger').html('');
    $('#alert-box').html('');

    let form = $(this);
    let action = '{{ isset($employee) ? url('/employees/' . $employee['id']) : url('/employees') }}';
    let method = form.find('input[name="_method"]').val() || 'POST';
    let formData = form.serialize();

    let isValid = true;
    const requiredFields = ['employee_id', 'name', 'address', 'departement_id'];

    requiredFields.forEach(function(field) {
        const value = form.find(`[name="${field}"]`).val();
        if (!value || value.trim() === '') {
            $(`#${field}-error`).html('This field is required.');
            isValid = false;
        }
    });

    if (!isValid) {
        $('#alert-box').html(
            `<div class="alert alert-danger">Please complete all required fields.</div>`
        );
        return;
    }

    $.ajax({
        url: action,
        type: method,
        data: formData,
        success: function(response) {
            $('#alert-box').html(
                `<div class="alert alert-success">${response.message}</div>`
            );
            setTimeout(() => {
                window.location.href = "{{ route('employees.index') }}";
            }, 1500);
        },
        error: function(xhr) {
            if (xhr.status === 422 && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                for (let field in errors) {
                    $(`#${field}-error`).html(errors[field][0]);
                }

                $('#alert-box').html(
                    `<div class="alert alert-danger">Please fix the form errors below.</div>`
                );
            } else {
                $('#alert-box').html(
                    `<div class="alert alert-danger">An unexpected error occurred. Please try again.</div>`
                );
            }
        }
    });
});
</script>
@endsection
