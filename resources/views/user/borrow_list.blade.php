@extends('user.layouts')

@section('title','รายการยืมโน้ตบุ๊ค')

@section('content')

<style>
    .borrow-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .borrow-table th {
        background: #2c3e50;
        color: #fff;
        padding: 12px;
        text-align: center;
    }

    .borrow-table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    .status-pending {
        color: #f39c12;
        font-weight: 600;
    }

    .status-borrowed {
        color: #27ae60;
        font-weight: 600;
    }

    .btn-return {
        background: #3498db;
        color: #fff;
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-return:hover {
        background: #2980b9;
    }

    .empty-box {
        padding: 60px;
        text-align: center;
        color: #777;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
</style>

<h2>📋 รายการยืมของฉัน</h2>

@if($borrowings->count() == 0)
<div class="empty-box">
    คุณยังไม่มีรายการยืม
</div>
@else
<table class="borrow-table">
    <tr>
        <th>โน้ตบุ๊ค</th>
        <th>วันที่ยืม</th>
        <th>วันที่คืน</th>
        <th>สถานะ</th>
        <th>การจัดการ</th>
    </tr>

    @foreach($borrowings as $b)
    <tr>
        <td>
            {{ $b->notebook->brand }} {{ $b->notebook->model }}
            <div style="font-size:12px;color:#888">
                Asset: {{ $b->notebook->asset_code }}
            </div>
        </td>

        <td>{{ $b->borrow_date }}</td>
        <td>{{ $b->return_date }}</td>

        <td>
            @if($b->isOverdue())
            <span style="color:red;font-weight:bold">⛔ เกินกำหนด</span>
            @elseif($b->status == 'pending')
            <span class="status-pending">⏳ รอแอดมินอนุมัติ</span>
            @elseif($b->status == 'borrowed')
            <span class="status-borrowed">✔ กำลังยืม</span>
            @endif

            @if($b->status == 'borrowed' && !$b->isOverdue())
            <div style="font-size:12px;color:#888;margin-top:4px">
                เหลือ {{ $b->daysLeft() }} วัน
            </div>
            @endif
        </td>

        <td>
            @if($b->status == 'borrowed')
            <form method="POST"
                action="{{ route('user.borrow.return',$b->id) }}"
                onsubmit="return confirmReturn();">
                @csrf
                <button class="btn-return">คืนเครื่อง</button>
            </form>
            @else
            -
            @endif
        </td>
    </tr>
    @endforeach
</table>
@endif
<script>
    function confirmReturn() {
        return confirm("คุณต้องการคืนโน้ตบุ๊คเครื่องนี้ใช่หรือไม่?");
    }
</script>

@endsection