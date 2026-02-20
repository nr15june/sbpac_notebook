@extends('admin.layouts')

@section('title','จัดการการยืมเครื่องปริ้น')

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

    .borrower-header {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .borrower-avatar {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
    }

    .borrower-name {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .borrower-phone {
        font-size: 13px;
        color: #475569;
        margin-top: 3px;
    }

    .account-info {
        margin-top: 10px;
        font-size: 13px;
        color: #64748b;
    }

    .account-info strong {
        color: #334155;
        font-weight: 700;
    }

    /* ===== PRINTER INFO ===== */
    .nb-title {
        font-weight: 800;
        font-size: 15px;
        margin: 0;
    }

    .asset {
        font-size: 12px;
        color: #64748b;
    }

    .section-divider {
        border-top: 1px dashed #e5e7eb;
        margin: 14px 0;
    }

    /* ===== DATE ===== */
    .pill-row {
        display: flex;
        gap: 8px;
        margin-top: 10px;
        flex-wrap: wrap;
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
    }

    /* ===== ACCESSORIES ===== */
    .accessory-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 12px;
        margin-top: 12px;
    }

    .accessory-title {
        font-size: 12.5px;
        font-weight: 700;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .acc-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        background: #fff;
        font-size: 12px;
        font-weight: 700;
    }

    .acc-empty {
        font-size: 12.5px;
        color: #64748b;
    }

    /* ===== ACTION ===== */
    .action-row {
        display: flex;
        gap: 10px;
        margin-top: 16px;
    }

    .btn-approve,
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
            <i class="bi bi-printer me-1"></i>
            รายการขอยืมเครื่องปริ้น
        </h2>
        <p>ตรวจสอบและอนุมัติคำขอยืมเครื่องปริ้น</p>
    </div>

    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
        รออนุมัติ {{ $printerBorrowings->count() }} รายการ
    </span>
</div>

@if($printerBorrowings->isEmpty())
<div class="empty-state">
    <i class="bi bi-inbox fs-1"></i>
    <h5 class="mt-3">ไม่มีรายการรออนุมัติ</h5>
    <p>ยังไม่มีคำขอยืมเครื่องปริ้นในขณะนี้</p>
</div>
@else

<div class="row g-4">
    @foreach($printerBorrowings as $b)
    <div class="col-xl-4 col-lg-6">
        <div class="card borrow-card h-100">
            <div class="card-top-accent"></div>

            <div class="card-body p-4">

                {{-- ผู้ยืมจริง --}}
                <div class="borrower-header">
                    <div class="borrower-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div>
                        <div class="borrower-name">
                            {{ $b->borrower_first_name }} {{ $b->borrower_last_name }}
                        </div>

                        <div class="borrower-phone">
                            <i class="bi bi-telephone me-1"></i>
                            {{ $b->borrower_phone ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="section-divider"></div>

                <div class="account-info">
                    <i class="bi bi-building me-1"></i>
                    บัญชีผู้ยื่นคำขอ:
                    <strong>{{ $b->user->first_name }} {{ $b->user->last_name }}</strong>
                    <span class="ms-2">
                        <i class="bi bi-telephone"></i>
                        {{ $b->user->phone ?? '-' }}
                    </span>
                </div>

                {{-- PRINTER --}}
                <div>
                    <p class="nb-title mb-1">
                        {{ $b->printer?->brand }} {{ $b->printer?->model }}
                    </p>
                    <div class="asset">
                        <i class="bi bi-upc-scan me-1"></i>
                        Asset: {{ $b->printer?->asset_code ?? '-' }}
                    </div>
                </div>

                {{-- ACCESSORIES --}}
                <div class="accessory-box">
                    <div class="accessory-title">
                        <i class="bi bi-bag-check"></i>
                        อุปกรณ์เสริมที่ยืม
                    </div>

                    @forelse($b->accessories as $acc)
                    <span class="acc-chip">
                        <i class="bi bi-check2-circle text-success"></i>
                        {{ $acc->name }}
                    </span>
                    @empty
                    <div class="acc-empty">ไม่มีอุปกรณ์เสริม</div>
                    @endforelse
                </div>

                {{-- DATE --}}
                <div class="pill-row">
                    <span class="date-pill">
                        <i class="bi bi-calendar-event"></i>
                        {{ \Carbon\Carbon::parse($b->borrow_date)->translatedFormat('d M Y') }}
                    </span>
                    <span class="date-pill">
                        <i class="bi bi-calendar-check"></i>
                        {{ \Carbon\Carbon::parse($b->return_date)->translatedFormat('d M Y') }}
                    </span>
                </div>

                {{-- ACTION --}}
                <div class="action-row">
                    <form method="POST" action="{{ route('admin.printer.borrow.approve',$b->id) }}" class="flex-fill">
                        @csrf
                        <button type="button" class="btn btn-success w-100 btn-approve">
                            <i class="bi bi-check-circle me-1"></i> อนุมัติ
                        </button>
                    </form>

                    <form method="POST"
                        action="{{ route('admin.printer.borrow.reject',$b->id) }}"
                        class="flex-fill reject-form">
                        @csrf

                        <input type="hidden" name="reject_reason" value="ไม่ผ่านการพิจารณา">

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

{{-- ===== SweetAlert ===== --}}
<script>
    document.querySelectorAll('.btn-approve').forEach(btn => {
        btn.addEventListener('click', function() {

            const form = this.closest('form');

            Swal.fire({
                title: 'ยืนยันการอนุมัติ',
                text: 'คุณต้องการอนุมัติการยืมเครื่องปริ้นนี้หรือไม่?',
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
        btn.addEventListener('click', () => {
            const form = btn.closest('form');
            const input = form.querySelector('input[name="reject_reason"]');

            Swal.fire({
                title: 'ปฏิเสธคำขอยืม',
                input: 'textarea',
                inputLabel: 'เหตุผลในการปฏิเสธ',
                inputPlaceholder: 'กรุณาระบุเหตุผล',
                inputValidator: v => !v && 'กรุณาระบุเหตุผล',
                showCancelButton: true,
                confirmButtonText: 'ปฏิเสธ',
                icon: 'warning'
            }).then(r => {
                if (r.isConfirmed) {
                    input.value = r.value;
                    form.submit();
                }
            });
        });
    });
</script>

@endsection