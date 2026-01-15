@extends('user.layouts')

@section('title','โปรไฟล์')

@section('content')

<style>
    .profile-box {
        max-width: 700px;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }

    .profile-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-row {
        display: grid;
        grid-template-columns: 180px 1fr;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .profile-label {
        color: #555;
        font-weight: 500;
    }

    .profile-value {
        color: #111;
        font-weight: 600;
    }

    .profile-note {
        margin-top: 25px;
        background: #f8f9fa;
        border-left: 4px solid #3498db;
        padding: 15px;
        border-radius: 6px;
        color: #555;
    }
</style>

<div class="profile-box">
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
        <div class="profile-value">{{ auth()->user()->id_card }}</div>
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
            @if(auth()->user()->role == 'admin')
                ผู้ดูแลระบบ
            @else
                ผู้ใช้งาน
            @endif
        </div>
    </div>

    <div class="profile-note">
        ⚠️ ข้อมูลนี้เป็นข้อมูลทางราชการ  
        หากข้อมูลไม่ถูกต้อง กรุณาติดต่อผู้ดูแลระบบ (แอดมิน) เพื่อแก้ไข
    </div>
</div>

@endsection
