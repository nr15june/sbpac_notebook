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
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
        transition: .25s;
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
    }

    .empty-state {
        text-align: center;
        padding: 100px 20px;
        color: #6b7280;
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
            <div class="card-body">

                {{-- User --}}
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-person-circle"></i>
                    {{ $b->user->first_name }} {{ $b->user->last_name }}
                </h5>
                <div class="text-muted small mt-1">
                    <i class="bi bi-telephone me-1"></i>
                    เบอร์ติดต่อ: <b>{{ $b->phone ?? '-' }}</b>
                </div>


                {{-- Notebook --}}
                <div class="mt-3">
                    <strong>{{ $b->notebook->brand }} {{ $b->notebook->model }}</strong>
                    <div class="asset">Asset: {{ $b->notebook->asset_code }}</div>
                </div>
                {{-- Accessories (Checklist คืนทีละชิ้น) --}}
                <div class="mt-3">
                    <div class="text-muted small mb-2">
                        <i class="bi bi-bag-check me-1"></i> อุปกรณ์เสริมที่ยืม:
                    </div>

                    @if($b->accessories && $b->accessories->count() > 0)
                    @foreach($b->accessories as $acc)
                    <div class="form-check">
                        <input class="form-check-input acc-item-check"
                            type="checkbox"
                            id="acc{{ $b->id }}_{{ $acc->id }}"
                            data-borrow-id="{{ $b->id }}">

                        <label class="form-check-label small" for="acc{{ $b->id }}_{{ $acc->id }}">
                            {{ $acc->name }}
                        </label>
                    </div>
                    @endforeach

                    <div class="text-muted small mt-2">
                        *กรุณาติ๊กให้ครบทุกชิ้นก่อนยืนยันคืนเครื่อง
                    </div>
                    @else
                    <div class="text-muted small">
                        ไม่มีอุปกรณ์เสริม
                    </div>
                    @endif
                </div>



                {{-- Date --}}
                <div class="d-flex gap-2 mt-3 flex-wrap">
                    <span class="date-pill">
                        <i class="bi bi-calendar-event"></i>
                        ยืม: {{ \Carbon\Carbon::parse($b->borrow_date)->format('d M Y') }}
                    </span>
                    <span class="date-pill">
                        <i class="bi bi-calendar-check"></i>
                        กำหนดคืน: {{ \Carbon\Carbon::parse($b->return_date)->format('d M Y') }}
                    </span>
                </div>

                {{-- Status --}}
                <div class="mt-3">
                    <span class="badge bg-success px-3 py-2 rounded-pill">
                        <i class="bi bi-check-circle-fill me-1"></i> กำลังใช้งาน
                    </span>
                </div>

                <div class="form-check mt-3">
                    <input class="form-check-input accessory-check"
                        type="checkbox"
                        id="accCheck{{ $b->id }}"
                        data-borrow-id="{{ $b->id }}">

                    <label class="form-check-label small" for="accCheck{{ $b->id }}">
                        ยืนยันว่า “คืนอุปกรณ์เสริมครบแล้ว”
                    </label>
                </div>


                {{-- Actions --}}
                <div class="d-flex gap-2 mt-4">

                    {{-- Confirm Return --}}
                    <form method="POST"
                        action="{{ route('admin.borrow.confirm_return',$b->id) }}"
                        class="flex-fill confirm-return-form">
                        @csrf
                        <button type="button"
                            class="btn btn-primary w-100 btn-confirm-return"
                            data-borrow-id="{{ $b->id }}"
                            disabled>
                            <i class="bi bi-box-arrow-in-left"></i> ยืนยันคืนเครื่อง
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
    function updateReturnButton(borrowId) {

        const allChecks = document.querySelectorAll('.acc-item-check[data-borrow-id="' + borrowId + '"]');
        const btn = document.querySelector('.btn-confirm-return[data-borrow-id="' + borrowId + '"]');

        // ถ้าไม่มีอุปกรณ์เสริม -> กดคืนได้เลย
        if (allChecks.length === 0) {
            btn.disabled = false;
            return;
        }

        // ต้องติ๊กครบทุกชิ้น
        const allChecked = Array.from(allChecks).every(chk => chk.checked);
        btn.disabled = !allChecked;
    }

    // โหลดครั้งแรก
    document.querySelectorAll('.btn-confirm-return').forEach(btn => {
        updateReturnButton(btn.dataset.borrowId);
    });

    // เวลาเปลี่ยน checkbox
    document.querySelectorAll('.acc-item-check').forEach(chk => {
        chk.addEventListener('change', function () {
            updateReturnButton(this.dataset.borrowId);
        });
    });

    // SweetAlert ตอนกดยืนยันคืน
    document.querySelectorAll('.btn-confirm-return').forEach(btn => {
        btn.addEventListener('click', function() {

            const borrowId = this.dataset.borrowId;
            const form = this.closest('form');

            Swal.fire({
                title: 'ยืนยันการคืนเครื่อง',
                text: 'คุณต้องการยืนยันการคืนโน้ตบุ๊คนี้หรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ยืนยันคืนเครื่อง',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#2563eb',
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