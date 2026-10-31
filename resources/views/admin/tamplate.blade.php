<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <!-- jQuery -->
    <script src="{{ asset('DataTables/jquery-3.6.1.js') }}"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">

    <!-- DataTables JS -->
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .admin-sidebar {
            width: 250px;
            background-color: #343a40;
            color: #fff;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .admin-sidebar .nav-link {
            color: #fff;
            padding: 10px 20px;
        }

        .admin-sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }

        .admin-content {
            margin-left: 250px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }

            .admin-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="admin-sidebar shadow">
        <h4 class="text-center fw-bold text-white pb-3 border-bottom">
            Admin Panel
        </h4>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="{{ route('admin.home') }}">
                    Home
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white"
                    href="{{ route('admin.project.index') }}">
                    Projects
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="admin-content">

        <div class="d-flex justify-content-between align-items-center p-3 mb-4 border-bottom bg-white rounded shadow-sm">
            <h3>Admin Dashboard</h3>
            <span class="text-muted">Halo, Admin!</span>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
                </button>
            </div>
        @endif

        <!-- Content -->
        @yield('content')

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    @stack('scripts')

</body>
</html>
