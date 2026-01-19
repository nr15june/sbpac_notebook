@extends('user.layouts')

@section('title','ประวัติการยืมโน้ตบุ๊ค')

@section('content')

<style>
    body {
        background: #f3f4f6;
    }

    /* ===== Page Title ===== */
    .page-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 18px;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ===== Card Wrapper ===== */
    .history-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 26px rgba(0,0,0,.06);
        overflow: hidden;
    }

    /* ===== Table ===== */
    .history-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    /* ===== Table Header ===== */
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

    /* ===== Table Body ===== */
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

    /* ===== Notebook Info ===== */
    .nb-name {
        font-weight: 600;
    }

    .nb-asset {
        font-size: 12.5px;
        color: #6b7280;
        margin-top: 2px;
    }

    /* ===== Duration Badge ===== */
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

    /* ===== Empty ===== */
    .empty-box {
        padding: 60px;
        text-align: center;
        color: #6b7280;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 26px rgba(0,0,0,.06);
    }
</style>

<div class="page-title">
    📚 ประวัติการยืมของฉัน
</div>

@if($borrowings->count() == 0)

<div class="empty-box">
    ยังไม่มีประวัติการยืม–คืนโน้ตบุ๊ค
</div>

@else

<div class="history-card">
    <table class="history-table">
        <thead>
            <tr>
                <th class="text-start">โน้ตบุ๊ค</th>
                <th style="width:18%">วันที่ยืม</th>
                <th style="width:18%">วันที่คืน</th>
                <th style="width:16%">ระยะเวลา</th>
            </tr>
        </thead>

        <tbody>
            @foreach($borrowings as $b)
            @php
                $days = \Carbon\Carbon::parse($b->borrow_date)
                            ->diffInDays($b->return_date, false);
            @endphp
            <tr>
                <td class="text-start">
                    <div class="nb-name">
                        {{ $b->notebook->brand }} {{ $b->notebook->model }}
                    </div>
                    <div class="nb-asset">
                        Asset: {{ $b->notebook->asset_code }}
                    </div>
                </td>

                <td>{{ $b->borrow_date }}</td>
                <td>{{ $b->return_date }}</td>

                <td>
                    @if($days > 0)
                        <span class="duration duration-normal">{{ $days }} วัน</span>
                    @elseif($days == 0)
                        <span class="duration duration-zero">0 วัน</span>
                    @else
                        <span class="duration duration-negative">{{ $days }} วัน</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endif

@endsection
