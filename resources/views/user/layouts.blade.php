<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'ระบบยืมโน้ตบุ๊ค')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/sbpac-logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: "Sarabun", sans-serif;
            background: #f4f6f9;
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
            width: 42px;
            height: 42px;
            margin-right: 12px;
        }

        .org-name-th {
            font-size: 15px;
            font-weight: 700;
        }

        .org-name-en {
            font-size: 11px;
            color: #666;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 14px;
        }

        .logout-btn {
            padding: 6px 14px;
            border: 1px solid #ccc;
            border-radius: 20px;
            background: none;
            cursor: pointer;
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
            width: 220px;
            background: #ffffff;
            border-right: 1px solid #dcdde1;
            padding: 20px 16px;
        }

        .sidebar-title {
            font-size: 13px;
            margin-bottom: 18px;
            color: #888;
        }

        .menu-item {
            display: block;
            padding: 12px 14px;
            margin-bottom: 10px;
            border-radius: 8px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
        }

        .menu-item:hover {
            background: #f1f2f6;
        }

        .menu-item.active {
            background: #1e90ff;
            color: #fff;
        }

        /* ===== Content ===== */
        .content {
            flex: 1;
            padding: 28px;
            overflow-y: auto;
        }
    </style>
</head>

<body>

    {{-- ===== Topbar ===== --}}
    <div class="topbar">
        <div class="topbar-left">
            <img src="{{ asset('images/sbpac-logo.png') }}">
            <div>
                <div class="org-name-th">ศูนย์อำนวยการบริหารจังหวัดชายแดนภาคใต้</div>
                <div class="org-name-en">Southern Border Provinces Administrative Centre</div>
            </div>
        </div>

        <div class="topbar-right">
            <span>👤 {{ auth()->user()->first_name ?? 'ผู้ใช้งาน' }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn">ออกจากระบบ</button>
            </form>
        </div>
    </div>

    <div class="wrapper">

        {{-- ===== Sidebar ===== --}}
        <div class="sidebar">
            <div class="sidebar-title">เมนูผู้ใช้งาน</div>

            <a href="{{ route('user.notebook_request') }}"
               class="menu-item {{ request()->routeIs('user.notebook_request') ? 'active' : '' }}">
                📥 ยืมโน้ตบุ๊ค
            </a>

            <a href="{{ route('user.borrow_list') }}"
               class="menu-item {{ request()->routeIs('user.borrow_list') ? 'active' : '' }}">
                📋 รายการยืม
            </a>

            <a href="{{ route('user.borrow_history') }}"
               class="menu-item {{ request()->routeIs('user.borrow_history') ? 'active' : '' }}">
                🕘 ประวัติการยืม
            </a>

            <a href="{{ route('user.report_problem') }}"
               class="menu-item {{ request()->routeIs('user.report_problem') ? 'active' : '' }}">
                🛠 แจ้งปัญหาเครื่อง
            </a>

            <a href="{{ route('user.profile') }}"
               class="menu-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                👤 โปรไฟล์
            </a>
        </div>

        {{-- ===== Content ===== --}}
        <div class="content">
            @yield('content')
        </div>

    </div>

</body>
</html>
