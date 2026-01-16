@extends('admin.layouts')

@section('title','จัดการผู้ใช้งาน')

@section('content')

<style>
    /* ===== Header ===== */
    .page-header {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 28px;
    }

    .page-header h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
    }

    .page-header p {
        margin: 4px 0 0;
        font-size: 13px;
        opacity: .75;
    }

    /* ===== Main Card ===== */
    .user-card {
        background: #fff;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .06);
    }

    /* ===== Header Row ===== */
    .user-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        margin-bottom: 32px;
    }

    .user-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .user-header span {
        font-size: 13px;
        color: #64748b;
    }

    /* ===== Actions ===== */
    .user-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .user-search {
        display: flex;
        gap: 6px;
    }

    .user-search input {
        width: 220px;
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        font-size: 14px;
    }

    .user-search button {
        padding: 8px 14px;
        border-radius: 10px;
        background: #334155;
        color: #fff;
        border: none;
        font-size: 14px;
    }

    .btn-add {
        padding: 8px 16px;
        border-radius: 10px;
        background: #2563eb;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
    }

    /* ===== Department ===== */
    .user-group {
        margin-bottom: 40px;
    }

    .user-group h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 14px;
        color: #1e293b;
    }

    /* ===== Workgroup ===== */
    .workgroup-title {
        margin: 14px 0 8px;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
    }

    /* ===== Table ===== */
    .user-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 16px rgba(0, 0, 0, .05);
        margin-bottom: 14px;
    }

    .user-table th {
        background: #f8fafc;
        padding: 12px;
        font-size: 13px;
        text-align: left;
    }

    .user-table td {
        padding: 12px;
        font-size: 14px;
        border-top: 1px solid #eef2f7;
    }

    .user-table th:last-child,
    .user-table td:last-child {
        text-align: center;
    }

    /* ===== Buttons ===== */
    .btn-edit {
        padding: 5px 12px;
        border-radius: 8px;
        border: 1px solid #c7d2fe;
        background: #fff;
        color: #2563eb;
        font-size: 13px;
        text-decoration: none;
    }

    .btn-delete {
        padding: 5px 12px;
        border-radius: 8px;
        border: 1px solid #fecaca;
        background: #fff;
        color: #dc2626;
        font-size: 13px;
        margin-left: 6px;
    }

    /* ===== Empty ===== */
    .empty {
        text-align: center;
        padding: 16px;
        color: #94a3b8;
        font-size: 13px;
    }
</style>

<div class="page-header">
    <h2><i class="bi bi-people me-1"></i> การจัดการผู้ใช้งาน</h2>
    <p>แสดงรายชื่อพนักงานภายในหน่วยงานทั้งหมด {{ $totalDepartments }} หน่วยงาน</p>
</div>

<div class="user-card">

    {{-- ===== Top Row ===== --}}
    <div class="user-header">
        <div>
            <h3>รายชื่อพนักงาน</h3>
            <span>เรียงตามหน่วยงานและกลุ่มงาน</span>
        </div>

        <div class="user-actions">
            <form method="GET" action="{{ route('admin.user_management') }}" class="user-search">
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="ค้นหาชื่อ / เลขบัตรประชาชน">
                <button type="submit">ค้นหา</button>
            </form>

            <a href="{{ route('admin.user.create') }}" class="btn-add">
                + เพิ่มพนักงาน
            </a>
        </div>
    </div>

    {{-- ===== Departments ===== --}}
    @forelse ($usersByDepartment as $department => $workgroups)

    <div class="user-group">
        <h4>🏢 {{ $department }}</h4>

        @forelse ($workgroups as $workgroup => $users)

        <div class="workgroup-title">▸ {{ $workgroup }}</div>

        <table class="user-table">
            <colgroup>
                <col style="width:15%">
                <col style="width:18%">
                <col style="width:13%">
                <col style="width:30%">
                <col style="width:12%">
            </colgroup>
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
                        <a href="{{ route('admin.user.edit',$user->id) }}" class="btn-edit">แก้ไข</a>
                        <form method="POST"
                            action="{{ route('admin.user.delete', $user->id) }}"
                            class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-delete btn-delete-confirm">
                                ลบ
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty">
                        ยังไม่มีพนักงานในกลุ่มงานนี้
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @empty
        <div class="empty">ยังไม่มีกลุ่มงาน</div>
        @endforelse
    </div>

    @empty
    <div class="empty">
        ยังไม่มีข้อมูลพนักงานในระบบ
    </div>
    @endforelse

</div>
<script>
    document.querySelectorAll('.btn-delete-confirm').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');

            Swal.fire({
                title: 'ยืนยันการลบพนักงาน',
                text: 'ข้อมูลนี้จะไม่สามารถกู้คืนได้',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ลบ',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#9ca3af'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection