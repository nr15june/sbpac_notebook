@extends('user.layouts')

@section('title','ประวัติการยืมโน้ตบุ๊ค')

@section('content')

<style>
    .history-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .history-table th {
        background: #34495e;
        color: #fff;
        padding: 12px;
        text-align: center;
    }

    .history-table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        text-align: center;
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

<h2>📚 ประวัติการยืมของฉัน</h2>

@if($borrowings->count() == 0)
<div class="empty-box">
    ยังไม่มีประวัติการคืนเครื่อง
</div>
@else
<table class="history-table">
    <tr>
        <th>โน้ตบุ๊ค</th>
        <th>วันที่ยืม</th>
        <th>วันที่คืน</th>
        <th>ระยะเวลา</th>
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
            {{ \Carbon\Carbon::parse($b->borrow_date)->diffInDays($b->return_date) }} วัน
        </td>
    </tr>
    @endforeach
</table>
@endif

@endsection