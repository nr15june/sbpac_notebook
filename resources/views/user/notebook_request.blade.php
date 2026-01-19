@extends('user.layouts')

@section('title','ยืมโน้ตบุ๊ค')

@section('content')

<style>
    /* ===== HERO ===== */
    .hero {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 32px;
    }

    /* ===== NOTEBOOK CARD ===== */
    .nb-card {
        border-radius: 20px;
        border: none;
        overflow: hidden;
        transition: .25s;
        background: #fff;
    }

    .nb-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, .12);
    }

    .nb-status {
        padding: 10px;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
    }

    .status-free {
        background: #dcfce7;
        color: #166534;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-busy {
        background: #fee2e2;
        color: #991b1b;
    }

    .nb-image {
        background: #f8fafc;
        padding: 20px;
    }

    .nb-image img {
        height: 140px;
        object-fit: contain;
    }

    /* ===== FORM ===== */
    .borrow-form {
        background: #fff;
        border-radius: 24px;
        padding: 32px;
        margin-top: 48px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
        display: none;
    }

    .borrow-form.show {
        display: block;
    }

    .borrow-user-box {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 24px;
    }
</style>

<div class="container-fluid">

    {{-- HERO --}}
    <div class="hero">
        <h3 class="fw-bold mb-1">ยืมโน้ตบุ๊ค</h3>
        <p class="opacity-75 mb-0">
            กรุณาเลือกอุปกรณ์ที่พร้อมใช้งาน และกรอกข้อมูลเพื่อขออนุมัติ
        </p>
    </div>

    {{-- NOTEBOOK GRID --}}
    <div class="row g-4">
        @foreach($notebooks as $nb)
        <div class="col-xl-4 col-md-6">
            <div class="nb-card">

                {{-- STATUS --}}
                @if($nb->status === 'available')
                <div class="nb-status status-free">✔ พร้อมให้ยืม</div>
                @elseif($nb->status === 'pending')
                <div class="nb-status status-pending">⏳ รออนุมัติ</div>
                @else
                <div class="nb-status status-busy">✖ ไม่พร้อมใช้งาน</div>
                @endif

                {{-- IMAGE --}}
                <div class="nb-image text-center">
                    <img src="{{ $nb->image ? asset('storage/'.$nb->image) : asset('images/no-image.png') }}">
                </div>

                {{-- INFO --}}
                <div class="p-4 text-center">
                    <h5 class="fw-semibold mb-1">
                        {{ $nb->brand }} {{ $nb->model }}
                    </h5>
                    <div class="text-muted small mb-3">
                        Asset: {{ $nb->asset_code }}
                    </div>

                    @if($nb->status === 'available')
                    <button class="btn btn-primary rounded-pill px-4"
                        onclick="selectNotebook(
                                '{{ $nb->id }}',
                                '{{ $nb->brand }} {{ $nb->model }}',
                                '{{ $nb->asset_code }}'
                            )">
                        ยืมเครื่องนี้
                    </button>
                    @else
                    <button class="btn btn-outline-secondary rounded-pill px-4" disabled>
                        ไม่สามารถยืมได้
                    </button>
                    @endif
                </div>

            </div>
        </div>
        @endforeach
    </div>

    {{-- FORM --}}
    <div id="borrowForm" class="borrow-form">
        <h4 class="fw-semibold mb-3">📝 แบบฟอร์มขอยืมโน้ตบุ๊ค</h4>

        <form method="POST" action="{{ route('user.borrow.store') }}" id="borrowSubmitForm">
            @csrf

            <input type="hidden" name="notebook_id" id="notebook_id">

            <p class="mb-3">
                <b>เครื่องที่เลือก:</b>
                <span id="notebook_name" class="text-primary"></span>
            </p>

            {{-- USER INFO --}}
            <div class="borrow-user-box">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-person-badge text-primary"></i>
                    <span class="fw-semibold">ข้อมูลผู้ยืม</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small">ชื่อ</label>
                        <input type="text" name="first_name"
                            class="form-control form-control-sm"
                            value="{{ auth()->user()->first_name }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">นามสกุล</label>
                        <input type="text" name="last_name"
                            class="form-control form-control-sm"
                            value="{{ auth()->user()->last_name }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">สำนัก / กอง / ศูนย์</label>
                        <input type="text" name="department"
                            class="form-control form-control-sm"
                            value="{{ auth()->user()->department }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">กลุ่มงาน</label>
                        <input type="text" name="workgroup"
                            class="form-control form-control-sm"
                            value="{{ auth()->user()->workgroup }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">เบอร์ติดต่อ</label>
                        <input type="text" name="phone"
                            class="form-control form-control-sm"
                            value="{{ auth()->user()->phone }}">
                    </div>
                </div>
            </div>

            {{-- DATE --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">วันที่ยืม</label>
                    <input type="date" name="borrow_date" id="borrow_date"
                        class="form-control"
                        required onchange="setReturnLimit()">
                </div>
                <div class="col-md-6">
                    <label class="form-label">วันที่คืน</label>
                    <input type="date" name="return_date" id="return_date"
                        class="form-control"
                        required>
                </div>
            </div>

            <button type="button"
                class="btn btn-primary w-100 mt-4 rounded-pill"
                onclick="confirmBorrow()">
                ยืนยันการยืม
            </button>
        </form>
    </div>

</div>

<script>
    function selectNotebook(id, name, asset) {
        borrowForm.classList.add('show');
        notebook_id.value = id;
        notebook_name.innerText = name + ' (' + asset + ')';
        borrowForm.scrollIntoView({
            behavior: 'smooth'
        });
    }

    function setReturnLimit() {
        let b = new Date(borrow_date.value);
        let m = new Date(b);
        m.setDate(m.getDate() + 14);
        return_date.min = borrow_date.value;
        return_date.max = m.toISOString().slice(0, 10);
    }

    function confirmBorrow() {
        Swal.fire({
            title: 'ยืนยันการยืม',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then(r => {
            if (r.isConfirmed) {
                borrowSubmitForm.submit();
            }
        });
    }
</script>

@endsection