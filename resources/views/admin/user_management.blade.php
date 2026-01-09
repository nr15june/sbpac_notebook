@extends('admin.layouts')

@section('title', 'จัดการผู้ใช้งาน')

@section('content')

<style>
    .user-card {
        background: #ffffff;
        border-radius: 10px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .user-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .user-header p {
        margin: 4px 0 0;
        color: #555;
        font-size: 14px;
    }

    .user-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .user-search {
        display: flex;
        gap: 8px;
    }

    .user-search input {
        padding: 8px 12px;
        width: 220px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .user-search button {
        padding: 8px 14px;
        background: #2f3542;
        color: #fff;
        border: none;
        border-radius: 4px;
    }

    .btn-add {
        padding: 8px 14px;
        background: #1e90ff;
        color: #fff;
        border-radius: 4px;
        text-decoration: none;
    }

    .user-group {
        margin-bottom: 40px;
    }

    .user-group h3 {
        margin-bottom: 12px;
        color: #2f3542;
    }

    .workgroup-title {
        margin: 14px 0 6px 4px;
        font-weight: 600;
        color: #57606f;
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ddd;
        background: #fff;
    }

    .user-table th {
        background: #f1f2f6;
        padding: 10px;
        font-size: 14px;
        text-align: left;
    }

    .user-table td {
        padding: 10px;
        font-size: 14px;
        border-top: 1px solid #eee;
    }

    .user-table th:last-child,
    .user-table td:last-child {
        text-align: center;
    }

    .btn-edit {
        padding: 4px 10px;
        border: 1px solid #aaa;
        background: #fff;
        border-radius: 4px;
    }

    .btn-delete {
        padding: 4px 10px;
        border: 1px solid #e74c3c;
        color: #e74c3c;
        background: #fff;
        border-radius: 4px;
        margin-left: 6px;
    }
</style>

<div class="user-card">

    {{-- Header --}}
    <div class="user-header">
        <div>
            <h2>การจัดการผู้ใช้งาน</h2>
            <p>แสดงรายชื่อพนักงานภายในหน่วยงาน<br>รวมทั้งหมด {{ $totalDepartments }} หน่วยงาน</p>
        </div>

        <div class="user-actions">
            <div class="user-search">
                <form method="GET" action="{{ route('admin.user_management') }}" style="display:flex; gap:8px;">
                    <input type="text" name="search"
                        value="{{ request('search') }}"
                        placeholder="ค้นหาชื่อ / เลขบัตรประชาชน">
                    <button type="submit">ค้นหา</button>
                </form>
            </div>

            <a href="{{ route('admin.user.create') }}" class="btn-add">
                + เพิ่มพนักงาน
            </a>
        </div>
    </div>

    {{-- Departments --}}
    @forelse ($usersByDepartment as $department => $workgroups)

    <div class="user-group">
        <h3>{{ $department }}</h3>

        {{-- Workgroups --}}
        @forelse ($workgroups as $workgroup => $users)

        <div class="workgroup-title">▸ {{ $workgroup }}</div>

        <table class="user-table">
            <thead>
                <tr>
                    <th>เลขบัตรประชาชน</th>
                    <th>ชื่อ – สกุล</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>กลุ่มงาน</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id_card }}</td>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->workgroup }}</td>
                    <td>
                        <button class="btn-edit">แก้ไข</button>
                        <button class="btn-delete">ลบ</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#999;">
                        ยังไม่มีพนักงานในกลุ่มงานนี้
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @empty
        <p style="color:#999; margin-left:10px;">ยังไม่มีพนักงานในหน่วยงานนี้</p>
        @endforelse

    </div>

    @empty
    <p style="text-align:center;color:#999;">ยังไม่มีข้อมูลพนักงานในระบบ</p>
    @endforelse

</div>

@endsection