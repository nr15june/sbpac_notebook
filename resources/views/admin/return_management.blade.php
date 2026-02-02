@extends('admin.layouts')

@section('title','จัดการคืนเครื่อง')

@section('content')

<style>
    .page-header {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
    }

    .page-header h2 {
        margin: 0;
        font-weight: 600;
        font-size: 22px;
    }

    .page-header p {
        margin: 0;
        opacity: .7;
        font-size: 13px;
    }

    .return-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
        transition: .25s;
        overflow: hidden;
    }

    .return-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 40px rgba(0, 0, 0, .12);
    }

    .asset {
        font-size: 12px;
        color: #6b7280;
    }

    .date-pill {
        background: #f1f5f9;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .empty-state {
        text-align: center;
        padding: 100px 20px;
        color: #6b7280;
    }

    .section-title {
        font-size: 12px;
        color: #6b7280;
        font-weight: 700;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .acc-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 12px;
    }

    .acc-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 12px;
        background: #fff;
        border: 1px solid #e5e7eb;
        margin-bottom: 10px;
    }

    .acc-item:last-child {
        margin-bottom: 0;
    }

    .acc-name {
        font-size: 13px;
        font-weight: 600;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .acc-help {
        font-size: 11px;
        color: #6b7280;
        margin-top: 8px;
    }

    .note-input {
        border-radius: 12px;
        padding: 10px 12px;
        font-size: 13px;
    }
</style>

{{-- ===== Header ===== --}}
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>
            <i class="bi bi-arrow-return-left me-1"></i>
            รายการคืนโน้ตบุ๊ค
        </h2>
        <p>แอดมินเป็นผู้ยืนยันการคืนเครื่อง เพื่อป้องกันการคืนไม่ตรงกับความจริง</p>
    </div>
    <span class="badge bg-primary px-3 py-2">
        กำลังยืมอยู่ {{ $borrowings->count() }} รายการ
    </span>
</div>

@if($borrowings->count() == 0)
<div class="empty-state">
    <i class="bi bi-inbox fs-1"></i>
    <h5 class="mt-3">ไม่มีรายการรอคืน</h5>
    <p>ไม่มีผู้ใช้งานที่กำลังยืมอยู่ในขณะนี้</p>
</div>
@else

<div class="row g-4">
    @foreach($borrowings as $b)
    <div class="col-xl-4 col-lg-6">
        <div class="card return-card h-100">
            <div class="card-body p-4">

                {{-- User --}}
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ $b->user->first_name }} {{ $b->user->last_name }}
                        </h5>

                        <div class="text-muted small">
                            <i class="bi bi-telephone me-1"></i>
                            เบอร์ติดต่อ: <b>{{ $b->phone ?? '-' }}</b>
                        </div>
                    </div>

                    <span class="badge bg-success px-3 py-2 rounded-pill">
                        <i class="bi bi-check-circle-fill me-1"></i> กำลังใช้งาน
                    </span>
                </div>

                <hr class="my-3">

                {{-- Notebook --}}
                <div>
                    <div class="section-title">
                        <i class="bi bi-laptop"></i> ข้อมูลเครื่อง
                    </div>

                    <div class="fw-semibold">
                        {{ $b->notebook->brand }} {{ $b->notebook->model }}
                    </div>
                    <div class="asset">
                        Asset: {{ $b->notebook->asset_code }}
                    </div>
                </div>

                {{-- Date --}}
                <div class="mt-3 d-flex flex-wrap gap-2">
                    <span class="date-pill">
                        <i class="bi bi-calendar-event"></i>
                        ยืม: {{ \Carbon\Carbon::parse($b->borrow_date)->format('d M Y') }}
                    </span>

                    <span class="date-pill">
                        <i class="bi bi-calendar-check"></i>
                        กำหนดคืน: {{ \Carbon\Carbon::parse($b->return_date)->format('d M Y') }}
                    </span>
                </div>

                {{-- FORM --}}
                <form method="POST"
                    action="{{ route('admin.borrow.confirm_return', $b->id) }}"
                    class="confirm-return-form mt-4">
                    @csrf

                    {{-- Accessories checklist --}}
                    <div class="section-title">
                        <i class="bi bi-bag-check"></i> อุปกรณ์เสริมที่ยืม (ติ๊กเฉพาะที่คืนแล้ว)
                    </div>

                    <div class="acc-box">
                        @if($b->accessories && $b->accessories->count() > 0)

                        @foreach($b->accessories as $acc)
                        <div class="acc-item">
                            <div class="acc-name">
                                <i class="bi bi-box-seam"></i>
                                {{ $acc->name }}
                            </div>

                            <div class="form-check m-0">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="returned_accessories[]"
                                    value="{{ $acc->id }}"
                                    id="acc{{ $b->id }}_{{ $acc->id }}">

                                <label class="small text-muted ms-1" for="acc{{ $b->id }}_{{ $acc->id }}">
                                    คืนแล้ว
                                </label>
                            </div>
                        </div>
                        @endforeach

                        <div class="acc-help">
                            *ถ้าไม่ติ๊ก = ระบบจะบันทึกว่า “ยังไม่คืน/อาจสูญหาย”
                        </div>

                        @else
                        <div class="text-muted small">
                            ไม่มีอุปกรณ์เสริม
                        </div>
                        @endif
                    </div>

                    {{-- note --}}
                    <div class="mt-3">
                        <label class="form-label small mb-1">
                            หมายเหตุ (หาย/ชำรุด/อื่นๆ)
                        </label>
                        <input type="text"
                            name="note"
                            class="form-control note-input"
                            placeholder="เช่น เมาส์หาย / สายชาร์จชำรุด">
                    </div>

                    {{-- button --}}
                    <button type="submit"
                        class="btn btn-primary w-100 mt-3">
                        <i class="bi bi-box-arrow-in-left me-1"></i> ยืนยันคืนเครื่อง
                    </button>

                </form>


            </div>
        </div>
    </div>
    @endforeach
</div>

@endif

{{-- ===== SweetAlert Script ===== --}}
<script>
    document.querySelectorAll('.confirm-return-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'ยืนยันการคืนเครื่อง',
                text: 'ระบบจะบันทึกอุปกรณ์ที่ติ๊กว่า “คืนแล้ว” และสิ่งที่ไม่ติ๊กจะถูกบันทึกว่า “ยังไม่คืน/สูญหาย”',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยันคืนเครื่อง',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection