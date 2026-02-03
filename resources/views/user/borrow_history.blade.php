@extends('user.layouts')

@section('title','ประวัติการยืม')

@section('content')

<style>
    body {
        background: #f3f4f6;
    }

    .history-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 26px rgba(0, 0, 0, .06);
        overflow: hidden;
    }

    .history-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .history-table thead tr {
        background: #334155;
    }

    .history-table th {
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        padding: 14px 12px;
        text-align: center;
    }

    .history-table th:first-child {
        border-top-left-radius: 16px;
    }

    .history-table th:last-child {
        border-top-right-radius: 16px;
    }

    .history-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: center;
        font-size: 14px;
        color: #1f2937;
        vertical-align: middle;
    }

    .history-table tbody tr:hover {
        background: #f8fafc;
    }

    .history-table tbody tr:last-child td {
        border-bottom: none;
    }

    .item-name {
        font-weight: 600;
    }

    .item-asset {
        font-size: 12.5px;
        color: #6b7280;
        margin-top: 2px;
    }

    .duration {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 600;
    }

    .duration-normal {
        background: #ecfdf5;
        color: #059669;
    }

    .duration-zero {
        background: #f1f5f9;
        color: #475569;
    }

    .duration-negative {
        background: #fef2f2;
        color: #dc2626;
    }

    .empty-box {
        padding: 60px;
        text-align: center;
        color: #6b7280;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 26px rgba(0, 0, 0, .06);
    }

    .history-header {
        background: linear-gradient(180deg, #ffffff, #f8fafc);
        border-radius: 18px;
        padding: 20px 24px;
        margin-bottom: 22px;
        box-shadow:
            0 12px 30px rgba(0, 0, 0, .06),
            0 0 0 1px #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .history-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .history-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .history-header-title {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
        color: #1f2937;
    }

    .history-header-subtitle {
        font-size: 13px;
        color: #6b7280;
    }

    .history-count {
        background: #eef2ff;
        color: #4f46e5;
        font-size: 13px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 999px;
    }

    .history-table tbody tr {
        transition: background .2s ease;
    }

    .history-table td:first-child {
        padding-left: 20px;
    }

    .history-table th:first-child {
        padding-left: 20px;
        text-align: left;
    }

    .status-returned {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 600;
        background: #f1f5f9;
        color: #334155;
    }

    .status-borrowed {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 600;
        background: #fff7ed;
        color: #9a3412;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        background: #eef2ff;
        color: #4f46e5;
        white-space: nowrap;
    }

    .type-printer {
        background: #ecfeff;
        color: #0e7490;
    }

    .type-notebook {
        background: #ecfdf5;
        color: #166534;
    }

    .return-date-text {
        font-size: 11px;
        color: #6b7280;
        margin-top: 6px;
    }
</style>

<div class="history-header">
    <div class="history-header-left">
        <div class="history-header-icon">
            <i class="bi bi-clock-history"></i>
        </div>
        <div>
            <h3 class="history-header-title">ประวัติการยืมของฉัน</h3>
            <div class="history-header-subtitle">
                แสดงรายการยืม–คืน (โน้ตบุ๊ค + เครื่องปริ้น) ทั้งหมดของคุณย้อนหลัง
            </div>
        </div>
    </div>

    <div class="history-count">
        ทั้งหมด {{ $borrowings->count() }} รายการ
    </div>
</div>

@if($borrowings->count() == 0)

<div class="empty-box">
    ยังไม่มีประวัติการยืม
</div>

@else

<div class="history-card">
    <table class="history-table">
        <thead>
            <tr>
                <th>อุปกรณ์</th>
                <th style="width:12%">ประเภท</th>
                <th style="width:18%">วันที่ยืม</th>
                <th style="width:18%">วันที่คืน</th>
                <th style="width:16%">ระยะเวลา</th>
                <th style="width:16%">สถานะ</th>
            </tr>
        </thead>

        <tbody>
            @foreach($borrowings as $b)
            @php
                $borrowDate = \Carbon\Carbon::parse($b['borrow_date']);
                $returnDate = \Carbon\Carbon::parse($b['return_date']);
                $days = $borrowDate->diffInDays($returnDate, false);
            @endphp

            <tr>
                <td class="text-start">
                    <div class="item-name">
                        {{ $b['name'] }}
                    </div>
                    <div class="item-asset">
                        Asset: {{ $b['asset_code'] }}
                    </div>
                </td>

                <td>
                    @if($b['type'] === 'printer')
                        <span class="type-badge type-printer">
                            <i class="bi bi-printer"></i> เครื่องปริ้น
                        </span>
                    @else
                        <span class="type-badge type-notebook">
                            <i class="bi bi-laptop"></i> โน้ตบุ๊ค
                        </span>
                    @endif
                </td>

                <td>{{ $borrowDate->format('d M Y') }}</td>

                <td>{{ $returnDate->format('d M Y') }}</td>

                <td>
                    @if($days > 0)
                        <span class="duration duration-normal">{{ $days }} วัน</span>
                    @elseif($days == 0)
                        <span class="duration duration-zero">0 วัน</span>
                    @else
                        <span class="duration duration-negative">{{ $days }} วัน</span>
                    @endif
                </td>

                <td>
                    @if($b['status'] === 'returned')
                        <span class="status-returned">
                            <i class="bi bi-box-arrow-in-left"></i> คืนเครื่องแล้ว
                        </span>
                        <div class="return-date-text">
                            แอดมินยืนยันเมื่อ {{ $returnDate->format('d M Y') }}
                        </div>
                    @else
                        <span class="status-borrowed">
                            <i class="bi bi-box-arrow-in-right"></i> กำลังยืม
                        </span>
                        <div class="return-date-text">
                            กรุณาคืนภายใน {{ $returnDate->format('d M Y') }}
                        </div>
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endif

@endsection