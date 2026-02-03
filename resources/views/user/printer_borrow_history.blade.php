@extends('user.layouts')

@section('title','ประวัติการยืมเครื่องปริ้น')

@section('content')

<div class="page-header mb-4">
    <h2 class="fw-bold mb-1">ประวัติการยืมเครื่องปริ้น</h2>
    <p class="text-muted mb-0">แสดงรายการยืมเครื่องปริ้นทั้งหมดของคุณ</p>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">รายการยืม</h5>

            <a href="{{ route('user.printers.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-left"></i> กลับไปหน้ายืมเครื่องปริ้น
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>รหัสครุภัณฑ์</th>
                        <th>ยี่ห้อ</th>
                        <th>รุ่น</th>
                        <th>วันยืม</th>
                        <th>วันคืน</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $index => $borrowing)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $borrowing->printer->asset_code ?? '-' }}</td>
                            <td>{{ $borrowing->printer->brand ?? '-' }}</td>
                            <td>{{ $borrowing->printer->model ?? '-' }}</td>
                            <td>{{ $borrowing->borrow_date }}</td>
                            <td>{{ $borrowing->return_date }}</td>
                            <td>
                                @if($borrowing->status === 'borrowed')
                                    <span class="badge bg-warning text-dark">กำลังยืม</span>
                                @elseif($borrowing->status === 'returned')
                                    <span class="badge bg-success">คืนแล้ว</span>
                                @else
                                    <span class="badge bg-secondary">{{ $borrowing->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                ยังไม่มีประวัติการยืมเครื่องปริ้น
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
