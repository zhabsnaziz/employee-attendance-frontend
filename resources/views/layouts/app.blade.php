<!DOCTYPE html>
<html>
<head>
    <title>Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="{{ route('home') }}">Attendance</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('departments.index') }}">Departments</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('employees.index') }}">Employees</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('attendance.create') }}">Attendance</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('attendance.logs') }}">Attendance Logs</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
