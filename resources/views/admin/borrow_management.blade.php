@extends('admin.layouts')

@section('title','จัดการการยืม')

@section('content')

<style>
    .page-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 20px;
    }

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
        font-weight: 500;
    }

    .borrow-table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    .borrow-table tr:hover {
        background: #f9f9f9;
    }

    .user-name {
        font-weight: 600;
        color: #333;
    }

    .notebook-name {
        color: #555;
        font-size: 14px;
    }

    .date {
        color: #666;
        font-size: 13px;
    }

    .btn-group {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .btn-approve {
        background: #28a745;
        color: #fff;
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
    }

    .btn-approve:hover {
        background: #218838;
    }

    .btn-reject {
        background: #dc3545;
        color: #fff;
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
    }

    .btn-reject:hover {
        background: #c82333;
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

<div class="page-title">📋 รายการขอยืมโน้ตบุ๊ค</div>

@if($borrowings->count() == 0)
<div class="empty-box">
    🎉 ไม่มีรายการรออนุมัติ
</div>
@else
<table class="borrow-table">
    <tr>
        <th>ผู้ยืม</th>
        <th>โน้ตบุ๊ค</th>
        <th>วันที่ยืม</th>
        <th>วันที่คืน</th>
        <th>การดำเนินการ</th>
    </tr>

    @foreach($borrowings as $b)
    <tr>
        <td class="user-name">
            {{ $b->user->first_name }} {{ $b->user->last_name }}
        </td>

        <td class="notebook-name">
            {{ $b->notebook->brand }} {{ $b->notebook->model }}
            <div style="font-size:12px;color:#888">
                Asset: {{ $b->notebook->asset_code }}
            </div>
        </td>

        <td class="date">{{ $b->borrow_date }}</td>
        <td class="date">{{ $b->return_date }}</td>

        <td>
            <div class="btn-group">
                <form method="POST" action="{{ route('admin.borrow.approve',$b->id) }}"
                    onsubmit="return confirmApprove();">
                    @csrf
                    <button class="btn-approve">✔ อนุมัติ</button>
                </form>

                <form method="POST" action="{{ route('admin.borrow.reject',$b->id) }}"
                    onsubmit="return confirmReject();">
                    @csrf
                    <button class="btn-reject">✖ ปฏิเสธ</button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</table>
@endif
<script>
    function confirmApprove() {
        return confirm("คุณต้องการอนุมัติการยืมเครื่องนี้ใช่หรือไม่?");
    }

    function confirmReject() {
        return confirm("คุณต้องการปฏิเสธการยืมรายการนี้ใช่หรือไม่?");
    }
</script>
@endsection