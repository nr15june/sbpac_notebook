@extends('admin.layouts')

@section('title','จัดการการยืม')

@section('content')

<style>
    /* ===== HEADER ===== */
    .page-header {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        border-radius: 18px;
        padding: 18px 22px;
        margin-bottom: 24px;
        box-shadow: 0 16px 40px rgba(0, 0, 0, .10);
    }

    .page-header h2 {
        margin: 0;
        font-weight: 700;
        font-size: 22px;
        letter-spacing: -.2px;
    }

    .page-header p {
        margin: 0;
        opacity: .75;
        font-size: 13px;
    }

    /* ===== CARD ===== */
    .borrow-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 14px 34px rgba(0, 0, 0, .08);
        transition: .25s;
        overflow: hidden;
        background: #fff;
    }

    .borrow-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 46px rgba(0, 0, 0, .12);
    }

    .card-top-accent {
        height: 5px;
        background: linear-gradient(90deg, #2563eb, #4f46e5);
    }

    /* ===== USER BLOCK ===== */
    .user-row {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex: 0 0 auto;
    }

    .user-name {
        font-weight: 800;
        margin: 0;
        font-size: 16px;
        color: #0f172a;
        line-height: 1.2;
    }

    .user-phone {
        font-size: 12.5px;
        color: #64748b;
        margin-top: 2px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* ===== NOTEBOOK INFO ===== */
    .nb-title {
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        font-size: 15px;
    }

    .asset {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    .section-divider {
        border-top: 1px dashed #e5e7eb;
        margin: 14px 0;
    }

    /* ===== DATE PILL ===== */
    .pill-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .date-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f1f5f9;
        border: 1px solid #e5e7eb;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 600;
        color: #0f172a;
    }

    /* ===== ACCESSORY BOX ===== */
    .accessory-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 12px 12px;
        margin-top: 12px;
    }

    .accessory-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: #475569;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .acc-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        font-size: 12px;
        font-weight: 700;
        color: #0f172a;
    }

    .acc-chip i {
        font-size: 13px;
    }

    .acc-empty {
        font-size: 12.5px;
        color: #64748b;
    }

    /* ===== ACTION BUTTONS ===== */
    .action-row {
        display: flex;
        gap: 10px;
        margin-top: 16px;
    }

    .btn-approve {
        border-radius: 14px;
        padding: 10px 14px;
        font-weight: 700;
    }

    .btn-reject {
        border-radius: 14px;
        padding: 10px 14px;
        font-weight: 700;
    }

    .empty-state {
        text-align: center;
        padding: 90px 20px;
        color: #6b7280;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 14px 34px rgba(0, 0, 0, .06);
    }
</style>

{{-- ===== Header ===== --}}
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h2>
            <i class="bi bi-clipboard-check me-1"></i>
            รายการขอยืมโน้ตบุ๊ค
        </h2>
        <p>ตรวจสอบและอนุมัติคำขอยืมอุปกรณ์</p>
    </div>

    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
        รออนุมัติ {{ $borrowings->count() }} รายการ
    </span>
</div>

@if($borrowings->count() == 0)
<div class="empty-state">
    <i class="bi bi-inbox fs-1"></i>
    <h5 class="mt-3">ไม่มีรายการรออนุมัติ</h5>
    <p>ระบบยังไม่มีคำขอยืมในขณะนี้</p>
</div>
@else

<div class="row g-4">
    @foreach($borrowings as $b)
    <div class="col-xl-4 col-lg-6">
        <div class="card borrow-card h-100">
            <div class="card-top-accent"></div>

            <div class="card-body p-4">

                {{-- USER --}}
                <div class="user-row">
                    <div class="user-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>

                    <div class="flex-grow-1">
                        <p class="user-name">
                            {{ $b->user->first_name }} {{ $b->user->last_name }}
                        </p>

                        <div class="user-phone">
                            <i class="bi bi-telephone"></i>
                            <span>{{ $b->phone ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="section-divider"></div>

                {{-- NOTEBOOK --}}
                <div>
                    <p class="nb-title mb-1">
                        {{ $b->notebook->brand }} {{ $b->notebook->model }}
                    </p>
                    <div class="asset">
                        <i class="bi bi-upc-scan me-1"></i>
                        Asset: {{ $b->notebook->asset_code }}
                    </div>
                </div>

                {{-- ACCESSORIES --}}
                <div class="accessory-box">
                    <div class="accessory-title">
                        <i class="bi bi-bag-check"></i>
                        อุปกรณ์เสริมที่ยืม
                    </div>

                    @if($b->accessories && $b->accessories->count() > 0)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($b->accessories as $acc)
                        <span class="acc-chip">
                            <i class="bi bi-check2-circle text-success"></i>
                            {{ $acc->name }}
                        </span>
                        @endforeach
                    </div>
                    @else
                    <div class="acc-empty">
                        <i class="bi bi-dash-circle me-1"></i>
                        ไม่มีอุปกรณ์เสริม
                    </div>
                    @endif
                </div>

                {{-- DATE --}}
                <div class="pill-row">
                    <span class="date-pill">
                        <i class="bi bi-calendar-event text-primary"></i>
                        {{ \Carbon\Carbon::parse($b->borrow_date)->format('d M Y') }}
                    </span>
                    <span class="date-pill">
                        <i class="bi bi-calendar-check text-success"></i>
                        {{ \Carbon\Carbon::parse($b->return_date)->format('d M Y') }}
                    </span>
                </div>

                {{-- ACTIONS --}}
                <div class="action-row">

                    {{-- Approve --}}
                    <form method="POST"
                        action="{{ route('admin.borrow.approve',$b->id) }}"
                        class="flex-fill approve-form">
                        @csrf
                        <button type="button" class="btn btn-success w-100 btn-approve">
                            <i class="bi bi-check-circle me-1"></i> อนุมัติ
                        </button>
                    </form>

                    {{-- Reject --}}
                    <form method="POST"
                        action="{{ route('admin.borrow.reject',$b->id) }}"
                        class="flex-fill reject-form">
                        @csrf
                        <button type="button" class="btn btn-outline-danger w-100 btn-reject">
                            <i class="bi bi-x-circle me-1"></i> ปฏิเสธ
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    @endforeach
</div>

@endif

{{-- ===== SweetAlert Script ===== --}}
<script>
    document.querySelectorAll('.btn-approve').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');

            Swal.fire({
                title: 'ยืนยันการอนุมัติ',
                text: 'คุณต้องการอนุมัติการยืมโน้ตบุ๊คนี้หรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'อนุมัติ',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#e5e7eb'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.querySelectorAll('.btn-reject').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');

            Swal.fire({
                title: 'ยืนยันการปฏิเสธ',
                text: 'คุณต้องการปฏิเสธคำขอยืมนี้หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ปฏิเสธ',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#e5e7eb'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection