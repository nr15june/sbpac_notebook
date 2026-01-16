<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'ระบบยืมโน้ตบุ๊ค')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/sbpac-logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap (ใช้ร่วมกับหน้าอื่นได้) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: "Sarabun", sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        /* ===== Topbar ===== */
        .topbar {
            height: 72px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-left img {
            width: 44px;
            height: 44px;
        }

        .org-name-th {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.2;
        }

        .org-name-en {
            font-size: 12px;
            color: #6b7280;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 13px;
            color: #374151;
        }

        .logout-btn {
            padding: 6px 16px;
            border: 1px solid #d1d5db;
            border-radius: 20px;
            background: #fff;
            font-size: 12px;
            cursor: pointer;
            transition: .2s;
        }

        .logout-btn:hover {
            background: #f3f4f6;
        }

        /* ===== Layout ===== */
        .wrapper {
            display: flex;
            height: calc(100vh - 72px);
        }

        /* ===== Sidebar (User) ===== */
        .sidebar {
            width: 220px;
            background: linear-gradient(180deg, #1e293b, #0f172a);
            padding: 24px 16px;
            color: #e5e7eb;
        }

        .sidebar-title {
            font-size: 12px;
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: 20px;
            color: #9ca3af;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            margin-bottom: 10px;
            border-radius: 10px;
            color: #e5e7eb;
            text-decoration: none;
            font-size: 14px;
            transition: .2s;
        }

        .menu-item i {
            font-size: 16px;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, .08);
        }

        .menu-item.active {
            background: #ffffff;
            color: #0f172a;
            font-weight: 600;
        }

        /* ===== Content ===== */
        .content {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
        }
    </style>
</head>

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
            <span>
                <i class="bi bi-person-circle"></i>
                {{ auth()->user()->first_name ?? 'ผู้ใช้งาน' }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn">ออกจากระบบ</button>
            </form>
        </div>
    </div>

    <div class="wrapper">

        {{-- ===== Sidebar ===== --}}
        <aside class="sidebar">
            <div class="sidebar-title">เมนูผู้ใช้งาน</div>

            <a href="{{ route('user.notebook_request') }}"
                class="menu-item {{ request()->routeIs('user.notebook_request') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-down"></i>
                ยืมโน้ตบุ๊ค
            </a>

            <a href="{{ route('user.borrow_list') }}"
                class="menu-item {{ request()->routeIs('user.borrow_list') ? 'active' : '' }}">
                <i class="bi bi-clipboard-data"></i>
                รายการยืม
            </a>

            <a href="{{ route('user.borrow_history') }}"
                class="menu-item {{ request()->routeIs('user.borrow_history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                ประวัติการยืม
            </a>

            <a href="{{ route('user.profile') }}"
                class="menu-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                <i class="bi bi-person-lines-fill"></i>
                โปรไฟล์
            </a>
        </aside>

        {{-- ===== Content ===== --}}
        <main class="content">
            @yield('content')
        </main>

    </div>

</body>

</html>