@extends('user.layouts')

@section('title','โปรไฟล์')

@section('content')

<style>
    body {
        background: #f3f4f6;
    }

    /* ===== PROFILE WRAPPER ===== */
    .profile-wrapper {
        max-width: 820px;
        margin: auto;
    }

    /* ===== HERO HEADER ===== */
    .profile-hero {
        background: linear-gradient(135deg, #1f2937, #334155);
        border-radius: 18px;
        padding: 28px 32px;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, .18);
    }

    /* Avatar */
    .profile-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #3b82f6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        font-weight: 700;
    }

    /* Hero text */
    .profile-hero-title {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
    }

    .profile-hero-subtitle {
        font-size: 13px;
        opacity: .75;
    }

    /* ===== PROFILE CARD ===== */
    .profile-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 32px;
        margin-top: -24px;
        box-shadow:
            0 30px 70px rgba(15, 23, 42, .12),
            0 0 0 1px #e5e7eb;
    }

    /* ===== SECTION ===== */
    .profile-section-title {
        font-size: 14px;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ===== INFO GRID ===== */
    .profile-grid {
        display: grid;
        grid-template-columns: 220px 1fr;
        row-gap: 14px;
        column-gap: 16px;
        font-size: 14px;
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

    .profile-value.highlight {
        color: #2563eb;
    }

    /* ===== ROLE BADGE ===== */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
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

    /* ===== NOTE ===== */
    .profile-note {
        margin-top: 26px;
        background: linear-gradient(180deg, #f8fafc, #ffffff);
        border-left: 5px solid #2563eb;
        padding: 16px 18px;
        border-radius: 12px;
        font-size: 13.5px;
        color: #475569;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        box-shadow: 0 10px 24px rgba(0, 0, 0, .06);
    }
</style>

<div class="profile-wrapper">

    {{-- HERO --}}
    <div class="profile-hero">
        <div class="profile-avatar">
            {{ mb_substr(auth()->user()->first_name,0,1) }}
        </div>
        <div>
            <h3 class="profile-hero-title">
                {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
            </h3>
            <div class="profile-hero-subtitle">
                ข้อมูลผู้ใช้งานในระบบยืม–คืนโน้ตบุ๊ค
            </div>
        </div>
    </div>

    {{-- CARD --}}
    <div class="profile-card">

        <div class="profile-section-title">
            <i class="bi bi-person-lines-fill"></i> ข้อมูลส่วนตัว
        </div>

        <div class="profile-grid">
            <div class="profile-label">ชื่อ</div>
            <div class="profile-value">{{ auth()->user()->first_name }}</div>

            <div class="profile-label">นามสกุล</div>
            <div class="profile-value">{{ auth()->user()->last_name }}</div>

            <div class="profile-label">เลขบัตรประชาชน</div>
            <div class="profile-value highlight">{{ auth()->user()->id_card }}</div>

            <div class="profile-label">อีเมล</div>
            <div class="profile-value">{{ auth()->user()->email }}</div>

            <div class="profile-label">เบอร์โทร</div>
            <div class="profile-value">{{ auth()->user()->phone }}</div>
        </div>

        <hr class="my-4 opacity-25">

        <div class="profile-section-title">
            <i class="bi bi-building"></i> ข้อมูลหน่วยงาน
        </div>

        <div class="profile-grid">
            <div class="profile-label">สำนัก / กอง / ศูนย์</div>
            <div class="profile-value">{{ auth()->user()->department }}</div>

            <div class="profile-label">กลุ่มงาน</div>
            <div class="profile-value">{{ auth()->user()->workgroup }}</div>

            <div class="profile-label">สิทธิ์ผู้ใช้</div>
            <div class="profile-value">
                @if(auth()->user()->role === 'admin')
                <span class="role-badge role-admin">
                    <i class="bi bi-shield-lock-fill"></i> ผู้ดูแลระบบ
                </span>
                @else
                <span class="role-badge role-user">
                    <i class="bi bi-person-check-fill"></i> ผู้ใช้งาน
                </span>
                @endif
            </div>
        </div>

        <div class="profile-note">
            <i class="bi bi-exclamation-triangle-fill text-warning fs-5"></i>
            <div>
                ข้อมูลนี้เป็นข้อมูลทางราชการ
                หากข้อมูลไม่ถูกต้อง กรุณาติดต่อผู้ดูแลระบบ (แอดมิน) เพื่อดำเนินการแก้ไข
            </div>
        </div>

    </div>
</div>


@endsection