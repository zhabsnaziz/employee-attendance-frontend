@extends('layouts.app')

@section('content')
<h2 class="mb-4">Clock In / Clock Out</h2>

{{-- Clock In --}}
<div id="clockin-alert-box" class="mb-3"></div>

<form id="clock-in-form" class="card card-body shadow-sm mb-4">
    @csrf
    <div class="mb-3">
        <label for="clockin-employee_id" class="form-label">Employee</label>
        <select name="employee_id" class="form-select" id="clockin-employee_id">
            @foreach($employees as $e)
                <option value="{{ $e['employee_id'] }}">{{ $e['name'] }}</option>
            @endforeach
        </select>
        <div class="form-text text-danger" id="clockin-employee_id-error"></div>
    </div>

    <div class="mb-3">
        <label for="clockin-description" class="form-label">Description</label>
        <input type="text" name="description" value="Masuk kerja" class="form-control" id="clockin-description">
    </div>

    <button type="submit" class="btn btn-success">Clock In</button>
</form>

{{-- Clock Out --}}
<div id="clockout-alert-box" class="mb-3"></div>

<form id="clock-out-form" class="card card-body shadow-sm">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="mb-3">
        <label for="clockout-employee_id" class="form-label">Employee</label>
        <select name="employee_id" class="form-select" id="clockout-employee_id">
            @foreach($employees as $e)
                <option value="{{ $e['employee_id'] }}">{{ $e['name'] }}</option>
            @endforeach
        </select>
        <div class="form-text text-danger" id="clockout-employee_id-error"></div>
    </div>

    <div class="mb-3">
        <label for="clockout-description" class="form-label">Description</label>
        <input type="text" name="description" value="Pulang kerja" class="form-control" id="clockout-description">
    </div>

    <button type="submit" class="btn btn-danger">Clock Out</button>
</form>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function handleClockForm(formId, url, method) {
    $(`#${formId}`).on('submit', function(e) {
        e.preventDefault();

        const isClockIn = formId === 'clock-in-form';
        const prefix = isClockIn ? 'clockin-' : 'clockout-';
        const alertBoxId = isClockIn ? '#clockin-alert-box' : '#clockout-alert-box';

        $('.form-text.text-danger').html('');
        $(alertBoxId).html('');

        const form = $(this);
        const formData = form.serialize();
        const employeeId = form.find('[name="employee_id"]').val();

        if (!employeeId || employeeId.trim() === '') {
            $(`#${prefix}employee_id-error`).html('Employee is required.');
            $(alertBoxId).html(`
                <div class="alert alert-danger">
                    Please complete all required fields.
                </div>
            `);
            return;
        }

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                $(alertBoxId).html(`
                    <div class="alert alert-success">
                        ${response.message}
                    </div>
                `);
                setTimeout(() => window.location.reload(), 1500);
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $(`#${prefix}${field}-error`).html(errors[field][0]);
                    }
                    $(alertBoxId).html(`
                        <div class="alert alert-danger">
                            Please fix the form errors below.
                        </div>
                    `);
                } else {
                    $(alertBoxId).html(`
                        <div class="alert alert-danger">
                            An unexpected error occurred. Please try again.
                        </div>
                    `);
                }
            }
        });
    });
}

handleClockForm('clock-in-form', '{{ route('attendance.clockIn') }}', 'POST');
handleClockForm('clock-out-form', '{{ route('attendance.clockOut') }}', 'POST');
</script>
@endsection
