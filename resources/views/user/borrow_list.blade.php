@extends('user.layouts')

@section('title','รายการยืมของฉัน')

@section('content')

<style>
    .hover-shadow:hover {
        box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .08) !important;
        transition: all 0.3s ease;
    }

    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-top: none;
    }

    .device-icon {
        width: 45px;
        height: 45px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .device-icon.printer {
        background: #ecfeff;
        color: #0e7490;
    }

    .page-header-card {
        background: linear-gradient(180deg, #ffffff, #f8fafc);
        border-radius: 18px;
        padding: 20px 24px;
        margin-bottom: 24px;
        box-shadow:
            0 12px 30px rgba(0, 0, 0, .06),
            0 0 0 1px #e5e7eb;
        position: relative;
    }

    .page-header-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 18px;
        bottom: 18px;
        width: 4px;
        border-radius: 4px;
        background: linear-gradient(180deg, #4f46e5, #3b82f6);
    }

    .page-header-icon {
        width: 46px;
        height: 46px;
        background: #eef2ff;
        color: #4f46e5;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .page-header-title {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
    }

    .page-header-subtitle {
        font-size: 13px;
        color: #6b7280;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        background: #eef2ff;
        color: #4f46e5;
        margin-top: 6px;
        width: fit-content;
    }

    .type-badge.printer {
        background: #ecfeff;
        color: #0e7490;
    }

    .type-badge.notebook {
        background: #ecfdf5;
        color: #166534;
    }
</style>

<div class="container-fluid py-4">

    <div class="page-header-card">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">
                <div class="page-header-icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <div>
                    <h3 class="page-header-title">รายการยืมของฉัน</h3>
                    <div class="page-header-subtitle">
                        แสดงรายการยืม (โน้ตบุ๊ค + เครื่องปริ้น) ที่กำลังดำเนินการ
                    </div>
                </div>
            </div>

            <div>
                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                    รวมทั้งหมด {{ $borrowings->count() }} รายการ
                </span>
            </div>

        </div>
    </div>


    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">

            @if($borrowings->count() == 0)
            <div class="text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/5058/5058432.png" alt="empty" style="width: 120px;" class="opacity-50 mb-3">
                <h5 class="text-muted">ไม่พบรายการยืมในขณะนี้</h5>
                <p class="text-secondary small">หากคุณทำการยืมเครื่อง รายการจะมาปรากฏที่นี่</p>
            </div>
            @else

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">ข้อมูลเครื่อง</th>
                            <th class="text-center py-3">ระยะเวลาการยืม</th>
                            <th class="text-center py-3">สถานะรายการ</th>
                            <th class="text-center py-3">จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($borrowings as $b)
                        <tr class="hover-shadow">
                            {{-- Device Info --}}
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="device-icon me-3 {{ $b['type'] === 'printer' ? 'printer' : '' }}">
                                        @if($b['type'] === 'printer')
                                        <i class="bi bi-printer fs-4"></i>
                                        @else
                                        <i class="bi bi-laptop fs-4"></i>
                                        @endif
                                    </div>

                                    <div>
                                        <div class="fw-bold text-dark">{{ $b['name'] }}</div>

                                        <span class="badge bg-light text-secondary border mt-1" style="font-size: 10px;">
                                            <i class="bi bi-upc-scan me-1"></i>{{ $b['asset_code'] }}
                                        </span>

                                        {{-- Type Badge --}}
                                        @if($b['type'] === 'printer')
                                        <div class="type-badge printer">
                                            <i class="bi bi-printer"></i> เครื่องปริ้น
                                        </div>
                                        @else
                                        <div class="type-badge notebook">
                                            <i class="bi bi-laptop"></i> โน้ตบุ๊ค
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Accessories (Notebook + Printer) --}}
                                <div class="mt-2">
                                    @if(isset($b['accessories']) && $b['accessories']->count() > 0)

                                    <div class="text-muted" style="font-size: 11px;">
                                        <i class="bi bi-bag-check me-1"></i> อุปกรณ์เสริม:
                                    </div>

                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        @foreach($b['accessories'] as $acc)
                                        <span class="badge bg-light text-dark border" style="font-size: 10px;">
                                            <i class="bi bi-check2-circle me-1 text-success"></i>
                                            {{ $acc->name }}
                                        </span>
                                        @endforeach
                                    </div>

                                    @else
                                    <div class="text-muted" style="font-size: 11px;">
                                        <i class="bi bi-bag me-1"></i> ไม่มีอุปกรณ์เสริม
                                    </div>
                                    @endif
                                </div>

                            </td>

                            {{-- Dates --}}
                            <td class="text-center">
                                <div class="small fw-medium text-dark">
                                    <i class="bi bi-calendar-event me-1 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($b['borrow_date'])->format('d M Y') }}
                                </div>
                                <div class="text-muted" style="font-size: 11px;">
                                    ถึง {{ \Carbon\Carbon::parse($b['return_date'])->format('d M Y') }}
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                @if($b['is_overdue'])
                                <div class="badge bg-danger px-3 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> เกินกำหนดคืน
                                </div>
                                @elseif($b['status'] === 'pending')
                                <div class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-clock-history me-1"></i> รอการยืนยัน
                                </div>
                                @elseif($b['status'] === 'borrowed')
                                <div class="badge bg-success px-3 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-check-circle-fill me-1"></i> กำลังใช้งาน
                                </div>

                                <div class="mt-1">
                                    <span class="text-primary fw-bold" style="font-size: 12px;">
                                        เหลืออีก {{ $b['days_left'] }} วัน
                                    </span>
                                </div>
                                @endif
                            </td>

                            {{-- Action --}}
                            <td class="text-center">
                                @if($b['status'] === 'borrowed')
                                <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill">
                                    <i class="bi bi-shield-check me-1"></i> รอแอดมินยืนยันการคืนเครื่อง
                                </span>
                                @else
                                <button class="btn btn-sm btn-light disabled rounded-pill">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @endif
        </div>
    </div>
</div>

@endsection