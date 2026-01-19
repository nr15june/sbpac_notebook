@extends('user.layouts')

@section('title','โปรไฟล์')

@section('content')

<style>
    body {
        background: #f3f4f6;
    }

    /* ===== Profile Card ===== */
    .profile-card {
        max-width: 760px;
        background: #ffffff;
        border-radius: 16px;
        padding: 28px 32px;
        box-shadow: 0 10px 26px rgba(0,0,0,.06);
    }

    /* ===== Title ===== */
    .profile-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1f2937;
    }

    /* ===== Info Row ===== */
    .profile-row {
        display: grid;
        grid-template-columns: 200px 1fr;
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
    }

    .profile-row:last-child {
        border-bottom: none;
    }

    .profile-label {
        color: #6b7280;
        font-weight: 500;
    }

    .profile-value {
        color: #111827;
        font-weight: 600;
        word-break: break-word;
    }

    /* ===== Highlight ===== */
    .profile-value.highlight {
        color: #2563eb;
    }

    /* ===== Role Badge ===== */
    .role-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 600;
    }

    .role-user {
        background: #ecfdf5;
        color: #059669;
    }

    .role-admin {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* ===== Note ===== */
    .profile-note {
        margin-top: 26px;
        background: #f8fafc;
        border-left: 5px solid #2563eb;
        padding: 14px 16px;
        border-radius: 10px;
        font-size: 13.5px;
        color: #475569;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }
</style>

<div class="profile-card">

    <div class="profile-title">
        👤 ข้อมูลผู้ใช้งาน
    </div>

    <div class="profile-row">
        <div class="profile-label">ชื่อ</div>
        <div class="profile-value">{{ auth()->user()->first_name }}</div>
    </div>

    <div class="profile-row">
        <div class="profile-label">นามสกุล</div>
        <div class="profile-value">{{ auth()->user()->last_name }}</div>
    </div>

    <div class="profile-row">
        <div class="profile-label">เลขบัตรประชาชน</div>
        <div class="profile-value highlight">
            {{ auth()->user()->id_card }}
        </div>
    </div>

    <div class="profile-row">
        <div class="profile-label">อีเมล</div>
        <div class="profile-value">{{ auth()->user()->email }}</div>
    </div>

    <div class="profile-row">
        <div class="profile-label">เบอร์โทร</div>
        <div class="profile-value">{{ auth()->user()->phone }}</div>
    </div>

    <div class="profile-row">
        <div class="profile-label">สำนัก / กอง / ศูนย์</div>
        <div class="profile-value">{{ auth()->user()->department }}</div>
    </div>

    <div class="profile-row">
        <div class="profile-label">กลุ่มงาน</div>
        <div class="profile-value">{{ auth()->user()->workgroup }}</div>
    </div>

    <div class="profile-row">
        <div class="profile-label">สิทธิ์ผู้ใช้</div>
        <div class="profile-value">
            @if(auth()->user()->role === 'admin')
                <span class="role-badge role-admin">ผู้ดูแลระบบ</span>
            @else
                <span class="role-badge role-user">ผู้ใช้งาน</span>
            @endif
        </div>
    </div>

    <div class="profile-note">
        ⚠️
        <div>
            ข้อมูลนี้เป็นข้อมูลทางราชการ  
            หากข้อมูลไม่ถูกต้อง กรุณาติดต่อผู้ดูแลระบบ (แอดมิน) เพื่อแก้ไข
        </div>
    </div>

</div>

@endsection
