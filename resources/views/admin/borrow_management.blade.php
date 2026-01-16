@extends('admin.layouts')

@section('title','จัดการการยืม')

@section('content')

<style>
.page-header{
    background:linear-gradient(135deg,#1e293b,#334155);
    color:#fff;
    border-radius:16px;
    padding:16px 20px;
    margin-bottom:24px;
}
.page-header h2{
    margin:0;
    font-weight:600;
    font-size:22px;
}
.page-header p{
    margin:0;
    opacity:.7;
    font-size:13px;
}

.borrow-card{
    border:none;
    border-radius:16px;
    box-shadow:0 12px 30px rgba(0,0,0,.08);
    transition:.25s;
}
.borrow-card:hover{
    transform:translateY(-4px);
    box-shadow:0 18px 40px rgba(0,0,0,.12);
}

.asset{
    font-size:12px;
    color:#6b7280;
}

.date-pill{
    background:#f1f5f9;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:500;
}

.empty-state{
    text-align:center;
    padding:100px 20px;
    color:#6b7280;
}
</style>

{{-- ===== Header ===== --}}
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>
            <i class="bi bi-clipboard-check me-1"></i>
            รายการขอยืมโน้ตบุ๊ค
        </h2>
        <p>ตรวจสอบและอนุมัติคำขอยืมอุปกรณ์</p>
    </div>
    <span class="badge bg-warning text-dark px-3 py-2">
        รออนุมัติ {{ $borrowings->count() }} รายการ
    </span>
</div>

@if($borrowings->count() == 0)
    <div class="empty-state">
        <i class="bi bi-inbox fs-1"></i>
        <h5 class="mt-3">ไม่มีรายการรออนุมัติ</h5>
        <p>ระบบยังไม่มีคำขอยืมในขณะนี้</p>
    </div>
@else

<div class="row g-4">
@foreach($borrowings as $b)
    <div class="col-xl-4 col-lg-6">
        <div class="card borrow-card h-100">
            <div class="card-body">

                {{-- User --}}
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-person-circle"></i>
                    {{ $b->user->first_name }} {{ $b->user->last_name }}
                </h5>

                {{-- Notebook --}}
                <div class="mt-3">
                    <strong>{{ $b->notebook->brand }} {{ $b->notebook->model }}</strong>
                    <div class="asset">Asset: {{ $b->notebook->asset_code }}</div>
                </div>

                {{-- Date --}}
                <div class="d-flex gap-2 mt-3">
                    <span class="date-pill">
                        <i class="bi bi-calendar-event"></i>
                        {{ $b->borrow_date }}
                    </span>
                    <span class="date-pill">
                        <i class="bi bi-calendar-check"></i>
                        {{ $b->return_date }}
                    </span>
                </div>

                {{-- Actions --}}
                <div class="d-flex gap-2 mt-4">

                    {{-- Approve --}}
                    <form method="POST"
                          action="{{ route('admin.borrow.approve',$b->id) }}"
                          class="flex-fill approve-form">
                        @csrf
                        <button type="button" class="btn btn-success w-100 btn-approve">
                            <i class="bi bi-check-circle"></i> อนุมัติ
                        </button>
                    </form>

                    {{-- Reject --}}
                    <form method="POST"
                          action="{{ route('admin.borrow.reject',$b->id) }}"
                          class="flex-fill reject-form">
                        @csrf
                        <button type="button" class="btn btn-outline-danger w-100 btn-reject">
                            <i class="bi bi-x-circle"></i> ปฏิเสธ
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endforeach
</div>

@endif

{{-- ===== SweetAlert Script ===== --}}
<script>
document.querySelectorAll('.btn-approve').forEach(btn => {
    btn.addEventListener('click', function () {
        const form = this.closest('form');

        Swal.fire({
            title: 'ยืนยันการอนุมัติ',
            text: 'คุณต้องการอนุมัติการยืมโน้ตบุ๊คนี้หรือไม่?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'อนุมัติ',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#e5e7eb'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

document.querySelectorAll('.btn-reject').forEach(btn => {
    btn.addEventListener('click', function () {
        const form = this.closest('form');

        Swal.fire({
            title: 'ยืนยันการปฏิเสธ',
            text: 'คุณต้องการปฏิเสธคำขอยืมนี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ปฏิเสธ',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#e5e7eb'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

@endsection
