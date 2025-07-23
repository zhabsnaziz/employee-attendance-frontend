@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>{{ isset($department) ? 'Edit Department' : 'Add Department' }}</h2>

    <div id="alert-box" class="mt-3"></div>

    <form id="department-form" class="mt-3">
        @csrf
        @if(isset($department))
            <input type="hidden" name="_method" value="PUT">
        @endif

        <div class="mb-3">
            <label for="department_name" class="form-label">Department Name</label>
            <input type="text" class="form-control" name="department_name" id="department_name"
                   value="{{ old('department_name', $department['department_name'] ?? '') }}">
            <div class="form-text text-danger" id="department_name-error"></div>
        </div>

        <div class="mb-3">
            <label for="max_clock_in_time" class="form-label">Max Clock In Time</label>
            <input type="time" class="form-control" name="max_clock_in_time" id="max_clock_in_time"
                   value="{{ old('max_clock_in_time', $department['max_clock_in_time'] ?? '') }}">
            <div class="form-text text-danger" id="max_clock_in_time-error"></div>
        </div>

        <div class="mb-3">
            <label for="max_clock_out_time" class="form-label">Max Clock Out Time</label>
            <input type="time" class="form-control" name="max_clock_out_time" id="max_clock_out_time"
                   value="{{ old('max_clock_out_time', $department['max_clock_out_time'] ?? '') }}">
            <div class="form-text text-danger" id="max_clock_out_time-error"></div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#department-form').on('submit', function(e) {
    e.preventDefault();

    $('.form-text.text-danger').html('');
    $('#alert-box').html('');

    const form = $(this);
    const action = '{{ isset($department) ? url('/departments/' . $department['id']) : url('/departments') }}';
    const method = form.find('input[name="_method"]').val() || 'POST';
    const formData = form.serialize();

    let isValid = true;
    const requiredFields = ['department_name', 'max_clock_in_time', 'max_clock_out_time'];

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
                window.location.href = "{{ route('departments.index') }}";
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
