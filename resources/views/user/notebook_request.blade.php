@extends('user.layouts')

@section('title','ยืมโน้ตบุ๊ค')

@section('content')

<style>
    /* ===== HERO (REFINED) ===== */
    .hero {
        background: linear-gradient(135deg, #1f2937, #334155);
        color: #ffffff;
        border-radius: 16px;
        padding: 18px 22px;
        margin-bottom: 28px;
    }

    /* Title */
    .hero-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .hero-title i {
        font-size: 20px;
        opacity: .9;
    }

    /* Subtitle */
    .hero-subtitle {
        font-size: 13px;
        line-height: 1.5;
        color: rgba(255, 255, 255, .75);
        max-width: 640px;
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
        padding: 0;
        height: 200px;
        /* เต็มขึ้น */
        overflow: hidden;
    }

    .nb-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        /* ไม่บิด ไม่ตัด */
    }


    /* ===== BORROW FORM (MODERN CARD) ===== */
    .borrow-form {
        background: linear-gradient(180deg, #ffffff, #f8fafc);
        border-radius: 24px;
        padding: 40px;
        margin-top: 56px;
        box-shadow:
            0 30px 60px rgba(15, 23, 42, .12),
            0 0 0 1px #e5e7eb;
        display: none;
    }

    .borrow-form.show {
        display: block;
    }

    /* Header */
    .borrow-form h4 {
        font-weight: 700;
        letter-spacing: -.3px;
        margin-bottom: 20px;
    }

    /* ===== USER INFO CARD ===== */
    .borrow-user-box {
        background: #ffffff;
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 12px 28px rgba(0, 0, 0, .06);
        border: none;
        margin-bottom: 32px;
    }

    /* ===== NOTICE ===== */
    .borrow-note {
        background: #eff6ff;
        border-left: 4px solid #2563eb;
        border-radius: 12px;
        padding: 14px 16px;
        font-size: 14px;
        color: #1e3a8a;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-top: 20px;
    }

    .borrow-note i {
        font-size: 18px;
        margin-top: 2px;
    }

    /* ===== FORM HEADER ===== */
    .borrow-form-header {
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid #e5e7eb;
    }

    .borrow-form-header-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #4f46e5;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .borrow-form-header-title {
        font-weight: 700;
        font-size: 15px;
        color: #1f2937;
    }

    .borrow-form-header-subtitle {
        font-size: 12.5px;
        color: #6b7280;
    }

    /* ===== STEP LABEL ===== */
    .form-step {
        font-size: 13px;
        font-weight: 700;
        color: #2563eb;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    /* ===== ACTION FOOTER ===== */
    .borrow-form-footer {
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px dashed #e5e7eb;
    }

    /* ===== ACCESSORIES BOX ===== */
    .accessories-box {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: 0 12px 28px rgba(0, 0, 0, .06);
        margin-top: 18px;
    }

    .accessory-item {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: .2s;
        cursor: pointer;
    }

    .accessory-item:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .accessory-item input {
        width: 18px;
        height: 18px;
    }

    .accessory-name {
        font-weight: 600;
        color: #111827;
        font-size: 14px;
    }

    .accessory-sub {
        font-size: 12px;
        color: #6b7280;
    }
</style>

<div class="container-fluid">

    {{-- HERO --}}
    <div class="hero">
        <div class="hero-title">
            <i class="bi bi-box-arrow-in-down"></i>
            <span>ยืมโน้ตบุ๊ค</span>
        </div>
        <div class="hero-subtitle">
            กรุณาเลือกอุปกรณ์ที่พร้อมใช้งาน และกรอกข้อมูลเพื่อขออนุมัติ
        </div>
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
                <div class="form-step">
                    <i class="bi bi-1-circle-fill"></i>
                    ข้อมูลผู้ยืม
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
                        <input type="text"
                            name="phone"
                            class="form-control form-control-sm"
                            value="{{ old('phone') }}"
                            placeholder="กรอกเบอร์โทรที่ติดต่อได้ (เช่น 08x-xxx-xxxx)"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">วันที่ยืม</label>
                        <input type="date"
                            name="borrow_date"
                            id="borrow_date"
                            class="form-control"
                            required
                            onchange="setReturnLimit()">

                    </div>
                    <div class="col-md-6">
                        <label class="form-label">วันที่คืน</label>
                        <input type="date" name="return_date" id="return_date"
                            class="form-control"
                            required>
                    </div>
                </div>
            </div>

            <div class="accessories-box">
                <div class="form-step">
                    <i class="bi bi-2-circle-fill"></i>
                    อุปกรณ์เสริมที่ต้องการ
                </div>

                <div class="row g-3">
                    @foreach($accessories as $acc)
                    <div class="col-md-6">
                        <label class="accessory-item w-100">
                            <input type="checkbox" name="accessories[]" value="{{ $acc->id }}">
                            <div>
                                <div class="accessory-name">{{ $acc->name }}</div>
                                <div class="accessory-sub">เลือกอุปกรณ์เสริมประกอบการยืม</div>
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="borrow-note">
                <i class="bi bi-info-circle-fill"></i>
                <div>
                    <b>หมายเหตุ:</b> สามารถยืมโน้ตบุ๊คได้ไม่เกิน <b>15 วัน</b>
                    และต้องคืนภายในระยะเวลาที่กำหนด หากเกินกำหนดอาจไม่สามารถยืมครั้งถัดไปได้
                </div>
            </div>

            <div class="borrow-form-footer">
                <button type="button"
                    class="btn btn-primary w-100 rounded-pill"
                    onclick="confirmBorrow()">
                    ยืนยันการยืม
                </button>
            </div>

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

    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date().toISOString().slice(0, 10);
        borrow_date.min = today;
    });
</script>

@endsection