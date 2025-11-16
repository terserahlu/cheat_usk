<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Restoran</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #FAF9EE;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid #EEEEEE;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: #A2AF9B;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon i {
            font-size: 24px;
            color: white;
            width: 24px;
            height: 24px;
        }

        .logo-text {
            color: #2c3e50;
        }

        .logo-text h1 {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .logo-text p {
            font-size: 0.75rem;
            color: #7f8c8d;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-section {
            margin-bottom: 25px;
        }

        .menu-section-title {
            padding: 0 20px 10px 20px;
            font-size: 0.75rem;
            color: #95a5a6;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #5f6368;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .menu-item:hover {
            background: #FAF9EE;
            color: #A2AF9B;
        }

        .menu-item.active {
            background: linear-gradient(90deg, rgba(162, 175, 155, 0.15) 0%, transparent 100%);
            color: #A2AF9B;
            font-weight: 600;
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #A2AF9B;
            border-radius: 0 4px 4px 0;
        }

        .menu-item i {
            font-size: 20px;
            margin-right: 12px;
            color: inherit;
        }

        .menu-item span {
            font-size: 0.95rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Header */
        .header {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }

        .menu-toggle i {
            font-size: 24px;
            color: #5f6368;
        }

        .search-bar {
            position: relative;
        }

        .search-bar input {
            padding: 10px 15px 10px 40px;
            border: 1.5px solid #DCCFC0;
            border-radius: 10px;
            background: #FAF9EE;
            width: 300px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #A2AF9B;
            width: 350px;
        }

        .search-bar i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #95a5a6;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-icon {
            position: relative;
            background: #FAF9EE;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .header-icon:hover {
            background: #A2AF9B;
        }

        .header-icon:hover i {
            color: white;
        }

        .header-icon i {
            font-size: 20px;
            color: #5f6368;
            transition: color 0.3s ease;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #e74c3c;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .user-profile:hover {
            background: #FAF9EE;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #A2AF9B;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-info h4 {
            font-size: 0.9rem;
            color: #2c3e50;
        }

        .user-info p {
            font-size: 0.75rem;
            color: #7f8c8d;
        }

        /* Content Area */
        .content {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h2 {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #7f8c8d;
            font-size: 0.95rem;
        }
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .search-bar input {
                width: 200px;
            }

            .search-bar input:focus {
                width: 250px;
            }

            .user-info {
                display: none;
            }

            .content {
                padding: 20px;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Logout button in sidebar */
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid #EEEEEE;
        }

        .logout-btn {
            width: 100%;
            padding: 12px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #c0392b;
            transform: translateY(-1px);
        }

        .logout-btn i {
            font-size: 18px;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">
                <i class="fa-solid fa-utensils"></i>
            </div>
            <div class="logo-text">
                <h1>Restoran App</h1>
                <p>{{ ucfirst(auth()->user()->role) }} Panel</p>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Main Menu</div>
                <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="menu-section">
                @if(Auth::check())
                <div class="menu-section-title">System</div>
                @if(Auth::user()->role == 'admin')
                <a href="{{ route('meja.index') }}" class="menu-item {{ request()->routeIs('meja.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-table"></i>
                    <span>Meja</span>
                </a>
                @endif
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'waiter')
                <a href="{{ route('menu.index') }}" class="menu-item {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-utensils"></i>
                    <span>Menu</span>
                </a>
                @endif
                @if(Auth::user()->role == 'waiter')
                <a href="{{ route('orderan.index') }}" class="menu-item {{ request()->routeIs('orderan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-list"></i>
                    <span>Orderan</span>
                </a>
                @endif
                @if(Auth::user()->role == 'kasir')
                <a href="{{ route('transaksi.index') }}" class="menu-item {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-cash-register"></i>
                    <span>Transaksi</span>
                </a>
                @endif
                @if(Auth::user()->role == 'waiter' || Auth::user()->role == 'kasir' || Auth::user()->role == 'owner')
                <a href="{{ route('laporan.index') }}" class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <span>Laporan</span>
                </a>
                @endif
            </div>
            @endif
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
            <h2 class="logo-text">@yield('title', 'Dashboard')</h2>
        </header>

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
    </script>
</body>
</html>