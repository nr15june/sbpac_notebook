@extends('admin.layouts')

@section('title','ประวัติการยืม')

@section('content')


<style>
    body {
        background: #f3f4f6;
    }

    /* ===== HEADER (เหมือน page-header) ===== */
    .page-header {
        background: linear-gradient(135deg, #1f2937, #334155);
        color: #fff;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
    }

    .page-header p {
        margin: 0;
        opacity: .7;
        font-size: 13px;
    }

    /* ===== TABLE WRAPPER ===== */
    .table-responsive {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 26px rgba(0, 0, 0, .06);
        overflow: hidden;
        /* บังคับให้โค้งจริง */
    }

    /* ===== TABLE ===== */
    .table {
        border-collapse: separate;
        border-spacing: 0;
    }

    /* ===== TABLE HEADER (เส้นยาว) ===== */
    .table thead tr {
        background: #334155;
    }

    .table thead th {
        background: transparent;
        /* ใช้สีจาก tr */
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        padding: 14px 12px;
        border: none;
    }

    /* โค้งเฉพาะหัวซ้าย-ขวา */
    .table thead th:first-child {
        border-top-left-radius: 16px;
    }

    .table thead th:last-child {
        border-top-right-radius: 16px;
    }

    /* ===== TABLE BODY ===== */
    .table tbody td {
        font-size: 14px;
        padding: 14px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #e5e7eb;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }


    .asset-code {
        font-size: 12px;
        color: #6b7280;
    }

    /* ===== STATUS ===== */
    .status-badge {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }

    .status-returned {
        background: #e0ecff;
        color: #2563eb;
    }

    .status-borrowed {
        background: #dcfce7;
        color: #15803d;
    }

    .status-pending {
        background: #fef3c7;
        color: #b45309;
    }

    .status-rejected {
        background: #fee2e2;
        color: #b91c1c;
    }

    .table tbody td {
        text-align: left;
    }

    .table td:last-child {
        width: 30%;
    }
</style>

{{-- ===== HEADER ===== --}}
<div class="page-header">
    <div>
        <h2>
            <i class="bi bi-clock-history"></i>
            ประวัติการยืมโน้ตบุ๊ก
        </h2>
        <p>รายการยืม–คืนอุปกรณ์ทั้งหมดในระบบ</p>
    </div>

    <form method="GET" class="d-flex gap-2">
        <input type="text"
            name="q"
            value="{{ $q ?? '' }}"
            class="form-control form-control-sm"
            style="width:260px"
            placeholder="ค้นหาชื่อ / รุ่น / Asset">
        <button class="btn btn-light btn-sm px-3">ค้นหา</button>
    </form>
</div>

{{-- ===== CONTENT ===== --}}

<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th style="width:14%" class="text-start">ผู้ยืม</th>
                <th style="width:26%" class="text-start">โน้ตบุ๊ก</th>
                <th style="width:10%" class="text-center">วันที่ยืม</th>
                <th style="width:10%" class="text-center">วันที่คืน</th>
                <th style="width:26%" class="text-start">อุปกรณ์เสริม</th>
                <th style="width:14%" class="text-center">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $b)
            <tr>
                <td class="text-start">
                    {{ $b->user->first_name }} {{ $b->user->last_name }}
                </td>
                <td>
                    <div class="fw-medium">
                        {{ $b->notebook->brand }} {{ $b->notebook->model }}
                    </div>
                    <div class="asset-code">{{ $b->notebook->asset_code }}</div>
                </td>
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($b->borrow_date)->translatedFormat('d M Y') }}
                </td>

                <td class="text-center">
                    {{ $b->return_date
                        ? \Carbon\Carbon::parse($b->return_date)->translatedFormat('d M Y')
                    : '-' }}
                </td>
                <td class="text-start">
                    @if($b->accessories && $b->accessories->count() > 0)

                    <div class="d-flex flex-wrap gap-1">
                        @foreach($b->accessories as $acc)
                        @php
                        $returned = $acc->pivot->is_returned ?? 0;
                        @endphp

                        @if($returned)
                        <span class="badge bg-success-subtle text-success border" style="font-size:11px;">
                            <i class="bi bi-check2-circle me-1"></i> {{ $acc->name }}
                        </span>
                        @else
                        <span class="badge bg-danger-subtle text-danger border" style="font-size:11px;">
                            <i class="bi bi-x-circle me-1"></i> {{ $acc->name }} (ยังไม่คืน)
                        </span>
                        @endif
                        @endforeach
                    </div>

                    {{-- ✅ หมายเหตุ --}}
                    @php
                    $note = optional($b->accessories->first())->pivot->note ?? null;
                    @endphp

                    @if($note)
                    <div class="mt-2 small text-muted">
                        <i class="bi bi-pencil-square me-1"></i>
                        หมายเหตุ: <b>{{ $note }}</b>
                    </div>
                    @endif

                    @else
                    <span class="text-muted small">ไม่มีอุปกรณ์เสริม</span>
                    @endif
                </td>

                <td class="text-center">
                    <span class="status-badge status-{{ $b->status }}">
                        @if($b->status=='returned') คืนแล้ว
                        @elseif($b->status=='borrowed') กำลังยืม
                        @elseif($b->status=='pending') รออนุมัติ
                        @else ปฏิเสธ
                        @endif
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-4">
                    ไม่พบข้อมูลการยืม
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


@endsection