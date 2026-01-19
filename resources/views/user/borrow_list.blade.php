@extends('user.layouts')

@section('title','รายการยืมโน้ตบุ๊ค')

@section('content')

{{-- CSS เพิ่มเติมเพื่อความสวยงาม --}}
<style>
    .hover-shadow:hover {
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08)!important;
        transition: all 0.3s ease;
    }
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-top: none;
    }
    .notebook-icon {
        width: 45px;
        height: 45px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
</style>

<div class="container-fluid py-4">

    {{-- ===== Page Header ===== --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h3 class="fw-bold text-dark mb-1">💻 รายการยืมของฉัน</h3>
            <p class="text-muted mb-0">ติดตามสถานะและจัดการการคืนเครื่องโน้ตบุ๊คของคุณ</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            {{-- สามารถเพิ่มปุ่ม "ยืมใหม่" ตรงนี้ได้ --}}
            <span class="badge bg-primary-subtle text-primary px-3 py-2">รวมทั้งหมด {{ $borrowings->count() }} รายการ</span>
        </div>
    </div>

    {{-- ===== Main Card ===== --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">

            @if($borrowings->count() == 0)
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/5058/5058432.png" alt="empty" style="width: 120px;" class="opacity-50 mb-3">
                    <h5 class="text-muted">ไม่พบรายการยืมในขณะนี้</h5>
                    <p class="text-secondary small">หากคุณทำการยืมเครื่อง รายการจะมาปรากฏที่นี่</p>
                </div>
            @else

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">ข้อมูลเครื่อง</th>
                            <th class="text-center py-3">ระยะเวลาการยืม</th>
                            <th class="text-center py-3">สถานะรายการ</th>
                            <th class="text-center py-3">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($borrowings as $b)
                        <tr class="hover-shadow">
                            {{-- Notebook Info --}}
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="notebook-icon me-3">
                                        <i class="bi bi-laptop fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $b->notebook->brand }}</div>
                                        <div class="text-muted small">{{ $b->notebook->model }}</div>
                                        <span class="badge bg-light text-secondary border mt-1" style="font-size: 10px;">
                                            <i class="bi bi-upc-scan me-1"></i>{{ $b->notebook->asset_code }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Dates --}}
                            <td class="text-center">
                                <div class="small fw-medium text-dark">
                                    <i class="bi bi-calendar-event me-1 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($b->borrow_date)->format('d M Y') }}
                                </div>
                                <div class="text-muted" style="font-size: 11px;">
                                    ถึง {{ \Carbon\Carbon::parse($b->return_date)->format('d M Y') }}
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                @if($b->isOverdue())
                                    <div class="badge bg-danger px-3 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> เกินกำหนดคืน
                                    </div>
                                @elseif($b->status === 'pending')
                                    <div class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-clock-history me-1"></i> รอการยืนยัน
                                    </div>
                                @elseif($b->status === 'borrowed')
                                    <div class="badge bg-success px-3 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-check-circle-fill me-1"></i> กำลังใช้งาน
                                    </div>
                                    @if(!$b->isOverdue())
                                        <div class="mt-1">
                                            <span class="text-primary fw-bold" style="font-size: 12px;">เหลืออีก {{ $b->daysLeft() }} วัน</span>
                                        </div>
                                    @endif
                                @endif
                            </td>

                            {{-- Action --}}
                            <td class="text-center">
                                @if($b->status === 'borrowed')
                                    <form method="POST" action="{{ route('user.borrow.return',$b->id) }}" id="returnForm{{ $b->id }}">
                                        @csrf
                                        <button type="button" 
                                                class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm"
                                                onclick="confirmReturn('{{ $b->id }}', '{{ $b->notebook->brand }} {{ $b->notebook->model }}')">
                                            คืนเครื่อง
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-light disabled rounded-pill">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- SweetAlert2 JS --}}
<script>
function confirmReturn(id, notebookName) {
    Swal.fire({
        title: 'ยืนยันการคืนเครื่อง?',
        text: `คุณกำลังจะดำเนินการคืนเครื่อง ${notebookName}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'ใช่, ฉันคืนแล้ว',
        cancelButtonText: 'ยกเลิก',
        padding: '2em',
        customClass: {
            confirmButton: 'btn btn-primary px-4',
            cancelButton: 'btn btn-outline-danger px-4'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('returnForm' + id).submit();
        }
    });
}
</script>

@endsection