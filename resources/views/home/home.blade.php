@extends('layouts.app')

@section('content')
<div class="p-5 mb-4 bg-white rounded-3 shadow-sm">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Welcome to Attendance System</h1>
        <p class="col-md-8 fs-5">
            Manage your employee attendance efficiently. Use the navigation bar above to access:
        </p>
        <ul class="fs-5">
            <li><strong>Departments</strong> – Manage working departments.</li>
            <li><strong>Employees</strong> – Add and edit employee records.</li>
            <li><strong>Attendance</strong> – Clock-in and Clock-out employee shifts.</li>
            <li><strong>Attendance Logs</strong> – View and filter attendance records.</li>
        </ul>
    </div>
</div>
@endsection
