@extends('user.layouts')

@section('title','สถานะการยืมเครื่องปริ้น')

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

    .device-title {
        font-size: 20px;
        font-weight: 600;
    }

    .asset-code {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 20px;
    }

    .borrow-box {
        background: #ffffffff;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid #ecececff;
    }

    .borrow-box h6 {
        font-weight: 600;
        margin-bottom: 12px;
    }

    .info-label {
        font-size: 13px;
        color: #64748b;
    }

    .info-value {
        font-weight: 500;
        margin-bottom: 8px;
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
        color: #ffffffff;
    }

    .available-box {
        background: #dcfce7;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid #bbf7d0;
        color: #166534;
        font-weight: 500;
    }

    .back-btn {
        margin-top: 24px;
    }
</style>

<div class="container-fluid">

    {{-- HERO --}}
    <div class="hero">
        <div class="hero-title">
            <i class="bi bi-printer"></i>
            สถานะการใช้งานเครื่องปริ้น
        </div>
    </div>

    <div class="status-card">

        <div class="device-title">
            {{ $printer->brand }} {{ $printer->model }}
        </div>

        <div class="asset-code">
            Asset: {{ $printer->asset_code }}
        </div>

        @if($borrowing)

            <div class="borrow-box">

                <h6>กำลังถูกใช้งานโดย</h6>

                <div class="row">
                    <div class="col-md-6">
                        <div class="info-label">ชื่อผู้ยืม</div>
                        <div class="info-value">
                            {{ $borrowing->borrower_first_name }} {{ $borrowing->borrower_last_name }}
                        </div>

                        <div class="info-label">เบอร์ติดต่อ</div>
                        <div class="info-value">
                            {{ $borrowing->borrower_phone }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-label">วันที่ยืม</div>
                        <div class="info-value">
                            {{ $borrowing->borrow_date->format('d/m/Y') }}
                        </div>

                        <div class="info-label">วันที่คืน</div>
                        <div class="info-value">
                            {{ $borrowing->return_date->format('d/m/Y') }}
                        </div>

                        <div class="info-label">สถานะ</div>
                        <div class="info-value">
                            @if($borrowing->status == 'pending')
                                <span class="status-badge status-pending">รออนุมัติ</span>
                            @else
                                <span class="status-badge status-borrowed">กำลังใช้งาน</span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        @else

            <div class="available-box">
                เครื่องนี้ว่าง พร้อมให้ยืม
            </div>

        @endif

        <div class="back-btn">
            <a href="{{ url()->previous() }}" class="btn btn-secondary w-100 rounded-pill">
                กลับ
            </a>
        </div>

    </div>

</div>

@endsection