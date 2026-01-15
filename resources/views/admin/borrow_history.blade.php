@extends('admin.layouts')

@section('title','ประวัติการยืม')

@section('content')

<style>
    .search-box {
        margin-bottom: 15px;
        display: flex;
        gap: 10px;
    }

    .search-box input {
        padding: 8px;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .search-box button {
        padding: 8px 16px;
        border: none;
        background: #2c3e50;
        color: #fff;
        border-radius: 6px;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, .05);
    }

    .history-table th {
        background: #34495e;
        color: #fff;
        padding: 12px;
        text-align: center;
    }

    .history-table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        color: #fff;
    }

    .borrowed {
        background: #27ae60;
    }

    .returned {
        background: #3498db;
    }

    .pending {
        background: #f39c12;
    }

    .rejected {
        background: #c0392b;
    }
</style>

<h2>📚 ประวัติการยืมโน้ตบุ๊ค</h2>

<form class="search-box" method="GET">
    <input type="text" name="q" value="{{ $q ?? '' }}"
        placeholder="ค้นหาชื่อพนักงาน / รุ่น / Asset...">
    <button>ค้นหา</button>
</form>

<table class="history-table">
    <tr>
        <th>ผู้ยืม</th>
        <th>โน้ตบุ๊ค</th>
        <th>วันที่ยืม</th>
        <th>วันที่คืน</th>
        <th>สถานะ</th>
    </tr>

    @foreach($borrowings as $b)
    <tr>
        <td>{{ $b->user->first_name }} {{ $b->user->last_name }}</td>

        <td>
            {{ $b->notebook->brand }} {{ $b->notebook->model }}
            <div style="font-size:12px;color:#777">
                {{ $b->notebook->asset_code }}
            </div>
        </td>

        <td>{{ $b->borrow_date }}</td>
        <td>{{ $b->return_date ?? '-' }}</td>

        <td>
            <span class="badge {{ $b->status }}">
                @if($b->status == 'returned') คืนแล้ว
                @elseif($b->status == 'borrowed') กำลังยืม
                @elseif($b->status == 'pending') รออนุมัติ
                @elseif($b->status == 'rejected') ปฏิเสธ
                @endif
            </span>
        </td>
    </tr>
    @endforeach

</table>

@endsection