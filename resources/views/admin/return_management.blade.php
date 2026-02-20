@extends('admin.layouts')

@section('title','จัดการคืนเครื่อง')

@section('content')

<style>
    body {
        background: linear-gradient(180deg, #f1f5f9 0%, #eef2ff 100%);
    }

    .card-body {
        padding: 6px 0 !important;
    }

    /* ===== Header ===== */
    .page-header {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        border-radius: 14px;
        padding: 18px 24px;
        margin-bottom: 30px;
    }

    .page-header h2 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .page-header p {
        font-size: 12.5px;
        opacity: .85;
        margin: 0;
    }

    /* ===== Card หลัก ===== */
    .return-card {
        background: #ffffff;
        border-radius: 22px;
        padding: 14px 18px;
        border: none;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        transition: all .25s ease;
    }



    /* ปิด hover ลอย */
    .return-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    }

    .return-card+.return-card {
        margin-top: 12px;
    }

    /* ===== 3 ส่วนแบบเส้นคั่น ===== */
    .info-box {
        background: transparent;
        padding: 0 10px;
    }

    /* responsive */
    @media (max-width: 991px) {
        .info-box {
            padding: 0;
            margin-bottom: 20px;
        }

        .info-box:not(:last-child) {
            border-right: none;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 18px;
        }
    }

    /* ===== หัวข้อ ===== */
    .box-title {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #334155;
        letter-spacing: .3px;
    }

    /* ===== Text ===== */
    .box-subtitle {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-top: 12px;
        margin-bottom: 6px;
    }

    .user-name {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .info-line {
        font-size: 13px;
        color: #475569;
        margin-bottom: 6px;
    }

    .device-name {
        font-size: 14px;
        font-weight: 600;
    }

    .asset {
        font-size: 12px;
        color: #64748b;
    }

    /* ===== Date Badge ===== */
    .date-group {
        margin-top: 8px;
    }

    .date-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        margin-right: 6px;
    }

    .badge-borrow {
        background: #f3f4f6;
        color: #374151;
    }

    .badge-return {
        background: #e0edff;
        color: #2563eb;
    }

    /* ===== Accessories ===== */
    .acc-box {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px;
        background: #fafafa;
    }

    .acc-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        padding: 6px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .acc-item:last-child {
        border-bottom: none;
    }

    .acc-item input[type="checkbox"] {
        transform: scale(1.1);
        cursor: pointer;
    }

    /* ===== Input ===== */
    .note-input {
        font-size: 13px;
        padding: 8px 10px;
        border-radius: 8px;
    }

    /* ===== Button ===== */
    .btn-primary {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        border-radius: 10px;
        transition: all .2s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
    }

    /* ===== Empty State ===== */
    .empty-state {
        text-align: center;
        padding: 70px 20px;
        background: #ffffff;
        border-radius: 16px;
    }
</style>

{{-- ===== Header ===== --}}
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>
            <i class="bi bi-arrow-return-left me-1"></i>
            รายการคืนเครื่อง
        </h2>
        <p>แอดมินเป็นผู้ยืนยันการคืนเครื่อง เพื่อป้องกันการคืนไม่ตรงกับความจริง</p>
    </div>
    <span class="badge bg-primary px-3 py-2">
        กำลังยืมอยู่ {{ $borrowings->count() }} รายการ
    </span>
</div>

@if($borrowings->count() == 0)
<div class="empty-state">
    <i class="bi bi-inbox fs-1"></i>
    <h5 class="mt-3">ไม่มีรายการรอคืน</h5>
    <p>ไม่มีผู้ใช้งานที่กำลังยืมอยู่ในขณะนี้</p>
</div>
@else

<div class="row g-3">
    @foreach($borrowings as $b)
    <div class="col-12">
        <div class="card return-card">
            <div class="card-body p-3 p-lg-4">
                <div class="row g-3">

                    {{-- ===== ส่วนที่ 1 : ผู้ยืม / บัญชี ===== --}}
                    <div class="col-lg-4">
                        <div class="info-box user-box">

                            <div class="box-title">
                                <i class="bi bi-person me-1"></i>
                                ข้อมูลผู้ยืม
                            </div>

                            <div class="user-name">
                                {{ $b->borrower_first_name }} {{ $b->borrower_last_name }}
                            </div>

                            <div class="info-line">
                                <i class="bi bi-telephone"></i>
                                {{ $b->borrower_phone ?? '-' }}
                            </div>

                            <hr>

                            <div class="box-subtitle">บัญชีผู้ยื่นคำขอ</div>

                            <div class="info-line">
                                {{ $b->user->first_name }} {{ $b->user->last_name }}
                            </div>

                            <div class="info-line">
                                <i class="bi bi-telephone"></i>
                                {{ $b->user->phone ?? '-' }}
                            </div>

                        </div>
                    </div>


                    {{-- ===== ส่วนที่ 2 : ข้อมูลเครื่อง ===== --}}
                    <div class="col-lg-4">
                        <div class="info-box device-box">

                            <div class="box-title">
                                <i class="bi bi-laptop me-1"></i>
                                ข้อมูลเครื่อง
                            </div>

                            <div class="device-name">
                                {{ $b->device->brand }} {{ $b->device->model }}
                            </div>

                            <div class="asset">
                                Asset: {{ $b->device->asset_code }}
                            </div>

                            <div class="date-group mt-3">
                                <span class="date-badge badge-borrow">
                                    ยืม {{ \Carbon\Carbon::parse($b->borrow_date)->translatedFormat('d M Y') }}
                                </span>

                                <span class="date-badge badge-return">
                                    คืน {{ \Carbon\Carbon::parse($b->return_date)->translatedFormat('d M Y') }}
                                </span>
                            </div>

                        </div>
                    </div>


                    {{-- ===== ส่วนที่ 3 : อุปกรณ์ที่คืน ===== --}}
                    <div class="col-lg-4">
                        <div class="info-box form-box">

                            <form method="POST"
                                action="{{ $b->type === 'notebook'
                    ? route('admin.borrow.confirm_return', $b->id)
                    : route('admin.printer.confirm_return', $b->id) }}"
                                class="confirm-return-form">
                                @csrf

                                <div class="box-title">
                                    <i class="bi bi-box-seam me-1"></i>
                                    อุปกรณ์ที่คืน
                                </div>

                                <div class="acc-box mb-3">
                                    @foreach($b->accessories as $acc)
                                    <div class="acc-item">
                                        <span>{{ $acc->name }}</span>
                                        <input type="checkbox"
                                            name="returned_accessories[]"
                                            value="{{ $acc->id }}">
                                    </div>
                                    @endforeach
                                </div>

                                <input type="text"
                                    name="note"
                                    class="form-control note-input mb-3"
                                    placeholder="หมายเหตุ (ถ้ามี)">

                                <button type="submit"
                                    class="btn btn-primary w-100">
                                    ยืนยันคืนเครื่อง
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endif

{{-- ===== SweetAlert Script ===== --}}
<script>
    document.querySelectorAll('.confirm-return-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'ยืนยันการคืนเครื่อง',
                text: 'ระบบจะบันทึกอุปกรณ์ที่ติ๊กว่า “คืนแล้ว” และสิ่งที่ไม่ติ๊กจะถูกบันทึกว่า “ยังไม่คืน/สูญหาย”',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยันคืนเครื่อง',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection