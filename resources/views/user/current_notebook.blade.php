@extends('user.layouts')

@section('title','สถานะการยืมโน้ตบุ๊ก')

@section('content')

<style>
    .hero {
        background: linear-gradient(135deg, #1f2937, #334155);
        color: #fff;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 28px;
    }

    .hero-title {
        font-size: 22px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 20px 40px rgba(0,0,0,.08);
        border: 1px solid #e5e7eb;
    }

    .available-simple {
        text-align: center;
        padding: 40px 20px;
        background: #f8fafc;
        border-radius: 14px;
        border: 1px dashed #cbd5e1;
    }

    .available-simple i {
        font-size: 40px;
        color: #22c55e;
        margin-bottom: 12px;
    }

    .borrow-box {
        background: #ffffffff;
        border-radius: 14px;
        padding: 24px;
        border: 1px solid #dbeafe;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-borrowed {
        background: #04ca25ff;
        color: #fff;
    }
</style>

<div class="container-fluid">

    <div class="hero">
        <div class="hero-title">
            <i class="bi bi-laptop"></i>
            สถานะการใช้งานโน้ตบุ๊ก
        </div>
    </div>

    <div class="status-card">

        <h5 class="fw-semibold">
            {{ $notebook->brand }} {{ $notebook->model }}
        </h5>

        <div class="text-muted mb-4">
            Asset: {{ $notebook->asset_code }}
        </div>

        {{-- ✅ ถ้ามีการยืม --}}
        @if($borrowing)

            <div class="borrow-box">

                <h6 class="fw-semibold mb-3">กำลังถูกใช้งานโดย</h6>

                <div class="row">
                    <div class="col-md-6">
                        <div><strong>ชื่อผู้ยืม:</strong></div>
                        <div class="mb-2">
                            {{ $borrowing->borrower_first_name }} {{ $borrowing->borrower_last_name }}
                        </div>

                        <div><strong>เบอร์ติดต่อ:</strong></div>
                        <div>
                            {{ $borrowing->borrower_phone }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div><strong>วันที่ยืม:</strong></div>
                        <div class="mb-2">
                            {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') }}
                        </div>

                        <div><strong>วันที่คืน:</strong></div>
                        <div class="mb-2">
                            {{ \Carbon\Carbon::parse($borrowing->return_date)->format('d/m/Y') }}
                        </div>

                        <div><strong>สถานะ:</strong></div>
                        @if($borrowing->status == 'pending')
                            <span class="status-badge status-pending">รออนุมัติ</span>
                        @else
                            <span class="status-badge status-borrowed">กำลังใช้งาน</span>
                        @endif
                    </div>
                </div>

            </div>

        {{-- ✅ ถ้ายังว่าง --}}
        @else

            <div class="available-simple">
                <i class="bi bi-check-circle-fill"></i>
                <div class="fw-semibold mb-2">เครื่องนี้ว่าง</div>
                <div class="text-muted">
                    พร้อมให้ทำรายการยืมได้ทันที
                </div>
            </div>

        @endif

        <a href="{{ url()->previous() }}"
           class="btn btn-secondary w-100 rounded-pill mt-4">
            กลับ
        </a>

    </div>

</div>

@endsection