<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'LuxHome')
    </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        /* ===== LAYOUT (sidebar + navbar) ===== */
        .app {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px;
            background: #ffffff;
            border-right: 1px solid #edf0f5;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            flex-shrink: 0;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 24px 24px 24px;
            font-weight: 700;
            font-size: 18px;
            color: #1f2937;
        }

        .sidebar-logo .logo-icon {
            width: 34px;
            height: 34px;
            background: #4353ff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 16px;
        }

        .sidebar-nav {
            list-style: none;
            flex: 1;
        }

        .sidebar-nav li {
            margin: 2px 12px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            border-radius: 10px;
            text-decoration: none;
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
            transition: background .15s, color .15s;
        }

        .sidebar-nav a i {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar-nav a:hover {
            background: #f4f6fb;
            color: #1f2937;
        }

        .sidebar-nav a.active {
            background: #eef0ff;
            color: #4353ff;
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .navbar {
            height: 72px;
            background: #ffffff;
            border-bottom: 1px solid #edf0f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
        }

        .navbar h1 {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f4f6fb;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            color: #4b5563;
            font-size: 15px;
        }

        .icon-btn .dot {
            position: absolute;
            top: 8px;
            right: 9px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-user .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: #4353ff;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .navbar-user .user-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .navbar-user .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
        }

        .navbar-user .user-role {
            font-size: 11px;
            color: #9ca3af;
            text-transform: capitalize;
        }

        .content {
            padding: 28px;
            flex: 1;
        }

       
        @yield('styles')
    </style>
</head>

<body>

<div class="app">

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <span class="logo-icon"><i class="fa-solid fa-house"></i></span>
            <span>LuxHome</span>
        </div>

        <ul class="sidebar-nav">
            <li>
                 <a
                        href="{{ route('owner.dashboard') }}"
                        class="{{ request()->routeIs('owner.dashboard') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-table-cells-large"></i>
                        Dashboard
                    </a>
                </li>
            <li>
                <a
                    href="{{ route('owner.kosts.index') }}"
                    class="{{ request()->routeIs('owner.kosts.*') ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-building"></i>
                    Kost Saya
                </a>
            </li>
            <li>
                <a href="#" class="{{ ($active ?? '') === 'customers' ? 'active' : '' }}">
                    <i class="fa-solid fa-user-group"></i> Customers
                </a>
            </li>
            <li>
                <a href="#" class="{{ ($active ?? '') === 'properties' ? 'active' : '' }}">
                    <i class="fa-solid fa-building"></i> Properties
                </a>
            </li>
            <li>
                <a href="#" class="{{ ($active ?? '') === 'invoice' ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice"></i> Invoice
                </a>
            </li>
            <li>
                <a href="#" class="{{ ($active ?? '') === 'settings' ? 'active' : '' }}">
                    <i class="fa-solid fa-gear"></i> Settings
                </a>
            </li>
        </ul>
    </aside>

    <!-- ===== MAIN ===== -->
    <div class="main">

        <!-- ===== NAVBAR ===== -->
        <header class="navbar">
            <h1>@yield('page-title', 'Dashboard')</h1>

            <div class="navbar-actions">
                <button class="icon-btn">
                    <i class="fa-regular fa-bell"></i>
                    <span class="dot"></span>
                </button>
                <button class="icon-btn">
                    <i class="fa-regular fa-comment-dots"></i>
                </button>

                <div class="navbar-user">
                    <div class="avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ auth()->user()->role }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- ===== CONTENT (beda-beda tiap halaman) ===== -->
        <main class="content">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>