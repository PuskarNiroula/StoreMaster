<?php
use App\Http\Controllers\AdminChecker;
$checker=new AdminChecker();
$admin=$checker->checkAdmin();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StoreMaster</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/layout.css">

    @yield('css')
</head>
<body class="bg-gray-100 text-gray-900">

<header class="topbar">

    <h3>

        <i class="bi bi-shop"></i>

        StoreMaster ERP

    </h3>

</header>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="sidebar">

            <div class="sidebar-header">

                <i class="bi bi-shop-window"></i>

                <span>StoreMaster</span>

            </div>

            <nav>

                @if($admin)

                    <a href="{{ route('sell') }}"
                       class="sidebar-link {{ request()->routeIs('sell') ? 'active' : '' }}">

                        <i class="bi bi-speedometer2"></i>

                        Dashboard

                    </a>

                @endif

                <a href="{{ route('products.index') }}"
                   class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }}">

                    <i class="bi bi-box-seam"></i>

                    Products

                </a>

                <a href="{{ route('category.index') }}"
                   class="sidebar-link {{ request()->routeIs('category.*') ? 'active' : '' }}">

                    <i class="bi bi-tags"></i>

                    Categories

                </a>

                <a href="{{ route('bills.create') }}"
                   class="sidebar-link {{ request()->routeIs('bills.*') ? 'active' : '' }}">

                    <i class="bi bi-receipt"></i>

                    Billing

                </a>

                @if($admin)

                    <a href="{{ route('analytics') }}"
                       class="sidebar-link {{ request()->routeIs('analytics') ? 'active' : '' }}">

                        <i class="bi bi-bar-chart"></i>

                        Analytics

                    </a>

                    <a href="{{ route('user.dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">

                        <i class="bi bi-people"></i>

                        Users

                    </a>

                @endif

            </nav>

            <div class="logout-area">

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button class="btn btn-danger w-100">

                        <i class="bi bi-box-arrow-right me-2"></i>

                        Logout

                    </button>

                </form>

            </div>

        </aside>

        <!-- Main Content -->
        <main class="mainContent p-4 w-full">
            @yield('content')
        </main>
    </div>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Page-specific JS -->
    @yield('scripts')
</body>
</html>
