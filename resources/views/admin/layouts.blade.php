<!DOCTYPE html>
<html lang="th">

<meta charset="UTF-8">
<title>@yield('title', 'ระบบจองโน้ตบุ๊ค')</title>
<link rel="icon" type="image/png" href="{{ asset('images/sbpac-logo.png') }}">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: "Sarabun", sans-serif;
        background: #f4f6f9;
        overflow: hidden;
    }

    /* ===== Topbar ===== */
    .topbar {
        height: 82px;
        background: #ffffff;
        border-bottom: 1px solid #dcdde1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 28px;
    }

    .topbar-left {
        display: flex;
        align-items: center;
    }

    .topbar-left img {
        width: 48px;
        height: 48px;
        margin-right: 14px;
    }

    .org-name-th {
        font-size: 16px;
        font-weight: 700;
    }

    .org-name-en {
        font-size: 12px;
        color: #666;
        margin-top: 2px;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 14px;
    }

    .logout-btn {
        padding: 6px 14px;
        border: 1px solid #ccc;
        border-radius: 20px;
        text-decoration: none;
        color: #333;
        font-size: 13px;
    }

    .logout-btn:hover {
        background: #f1f2f6;
    }

    /* ===== Layout ===== */
    .wrapper {
        display: flex;
        height: calc(100vh - 82px);
    }

    /* ===== Sidebar ===== */
    .sidebar {
        width: 200px;
        background: #2f3542;
        padding: 20px 14px;
        color: #fff;
        overflow: hidden;
    }

    .sidebar-title {
        font-size: 14px;
        margin-bottom: 16px;
        color: #ced6e0;
    }

    .menu-item {
        display: block;
        padding: 12px 14px;
        margin-bottom: 10px;
        border: 1px solid #57606f;
        border-radius: 6px;
        color: #dcdde1;
        text-decoration: none;
        font-size: 14px;
        background: #2f3542;
    }

    .menu-item:hover {
        background: #57606f;
        color: #ffffff;
    }

    .menu-item.active {
        background: #747d8c;
        color: #ffffff;
        border-color: #747d8c;
    }

    /* ===== Content ===== */
    .content {
        flex: 1;
        padding: 28px;
        overflow-y: auto;
    }
</style>

<body>

    {{-- ===== Topbar ===== --}}
    <div class="topbar">
        <div class="topbar-left">
            <img src="{{ asset('images/sbpac-logo.png') }}" alt="logo">
            <div>
                <div class="org-name-th">ศูนย์อำนวยการบริหารจังหวัดชายแดนภาคใต้</div>
                <div class="org-name-en">Southern Border Provinces Administrative Centre</div>
            </div>
        </div>

        <div class="topbar-right">
            <span>👤 ผู้ดูแลระบบ</span>
            <a href="#" class="logout-btn">ออกจากระบบ</a>
        </div>
    </div>

    <div class="wrapper">

        {{-- ===== Sidebar ===== --}}
        <div class="sidebar">
            <div class="sidebar-title">เมนูผู้ดูแลระบบ</div>

            <a href="{{ route('admin.booking_management') }}"
                class="menu-item {{ request()->routeIs('admin.booking_management') ? 'active' : '' }}">
                จัดการการจอง
            </a>

            <a href="{{ route('admin.notebook_management') }}"
                class="menu-item {{ request()->routeIs('admin.notebook_management') ? 'active' : '' }}">
                จัดการโน้ตบุ๊ค
            </a>

            <a href="{{ route('admin.user_management') }}"
                class="menu-item {{ request()->routeIs('admin.user_management') ? 'active' : '' }}">
                จัดการผู้ใช้งาน
            </a>
        </div>

        {{-- ===== Content ===== --}}
        <div class="content">
            @yield('content')
        </div>

    </div>

</body>

</html>