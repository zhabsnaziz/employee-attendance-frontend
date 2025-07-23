@extends('layouts.app')

@section('content')
<h2 class="mb-4">Attendance Logs</h2>

<form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" value="{{ $params['start_date'] ?? '' }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label">End Date</label>
        <input type="date" name="end_date" value="{{ $params['end_date'] ?? '' }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label">Department</label>
        <select name="department_id" class="form-select">
            <option value="">All</option>
            @foreach($departments as $d)
                <option value="{{ $d['id'] }}" {{ (isset($params['department_id']) && $params['department_id'] == $d['id']) ? 'selected' : '' }}>
                    {{ $d['department_name'] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
</form>

@php
    $logData = $logs['data'] ?? $logs;
@endphp

@if(empty($logData))
    <div class="alert alert-warning">No logs found.</div>
@else
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Employee</th>
                <th>Department</th>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>On Time In</th>
                <th>On Time Out</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logData as $log)
                <tr>
                    <td>{{ $log['date'] }}</td>
                    <td>{{ $log['name'] }}</td>
                    <td>{{ $log['department'] }}</td>
                    <td>{{ $log['clock_in'] ?? '-' }}</td>
                    <td>{{ $log['clock_out'] ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $log['on_time_in'] ? 'success' : 'danger' }}">
                            {{ $log['on_time_in'] ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $log['on_time_out'] ? 'success' : 'danger' }}">
                            {{ $log['on_time_out'] ? 'Yes' : 'No' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
