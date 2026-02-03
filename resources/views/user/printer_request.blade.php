@extends('user.layouts')

@section('title','ยืมเครื่องปริ้น')

@section('content')

<style>
    /* ===== HERO ===== */
    .hero {
        background: linear-gradient(135deg, #1f2937, #334155);
        color: #ffffff;
        border-radius: 16px;
        padding: 18px 22px;
        margin-bottom: 28px;
    }

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

    .hero-subtitle {
        font-size: 13px;
        line-height: 1.5;
        color: rgba(255, 255, 255, .75);
        max-width: 640px;
    }

    /* ===== PRINTER CARD ===== */
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

    .status-busy {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-broken {
        background: #fef3c7;
        color: #92400e;
    }

    .nb-image {
        background: #f8fafc;
        height: 200px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nb-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* ===== BORROW FORM ===== */
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

    .borrow-user-box {
        background: #ffffff;
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 12px 28px rgba(0, 0, 0, .06);
        border: none;
        margin-bottom: 32px;
    }

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

    .form-step {
        font-size: 13px;
        font-weight: 700;
        color: #2563eb;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .borrow-form-footer {
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px dashed #e5e7eb;
    }

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

    {{-- ✅ SweetAlert แจ้งเตือน --}}
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: "{{ session('success') }}",
            confirmButtonText: 'ตกลง'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'ไม่สำเร็จ',
            text: "{{ session('error') }}",
            confirmButtonText: 'ตกลง'
        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'กรอกข้อมูลไม่ครบ',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonText: 'ตกลง'
        });
    </script>
    @endif


    {{-- HERO --}}
    <div class="hero">
        <div class="hero-title">
            <i class="bi bi-printer"></i>
            <span>ยืมเครื่องปริ้น</span>
        </div>
        <div class="hero-subtitle">
            กรุณาเลือกเครื่องปริ้นที่พร้อมให้ยืม และกรอกข้อมูลเพื่อทำรายการยืม (คืนไม่เกิน 7 วัน)
        </div>
    </div>

    {{-- PRINTER GRID --}}
    <div class="row g-4">
        @foreach($printers as $pr)
        <div class="col-xl-4 col-md-6">
            <div class="nb-card">

                {{-- STATUS --}}
                @if($pr->status === 'available')
                <div class="nb-status status-free">✔ พร้อมให้ยืม</div>
                @elseif($pr->status === 'broken')
                <div class="nb-status status-broken">🔧 เสีย/ซ่อม</div>
                @else
                <div class="nb-status status-busy">✖ ไม่พร้อมให้ยืม</div>
                @endif

                {{-- IMAGE --}}
                <div class="nb-image text-center">
                    <img src="{{ $pr->image ? asset('storage/'.$pr->image) : asset('images/no-image.png') }}">
                </div>

                {{-- INFO --}}
                <div class="p-4 text-center">
                    <h5 class="fw-semibold mb-1">
                        {{ $pr->brand }} {{ $pr->model }}
                    </h5>

                    <div class="text-muted small mb-3">
                        Asset: {{ $pr->asset_code }}
                    </div>

                    @if($pr->status === 'available')
                    <button class="btn btn-primary rounded-pill px-4"
                        onclick="selectPrinter(
                            '{{ $pr->id }}',
                            '{{ $pr->brand }} {{ $pr->model }}',
                            '{{ $pr->asset_code }}'
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
        <h4 class="fw-semibold mb-3">📝 แบบฟอร์มยืมเครื่องปริ้น</h4>

        <form method="POST" action="{{ route('user.printers.borrow') }}" id="borrowSubmitForm">
            @csrf

            <input type="hidden" name="printer_id" id="printer_id">

            <p class="mb-3">
                <b>เครื่องที่เลือก:</b>
                <span id="printer_name" class="text-primary"></span>
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
                        <input type="text"
                            class="form-control form-control-sm"
                            value="{{ auth()->user()->first_name }}"
                            disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">นามสกุล</label>
                        <input type="text"
                            class="form-control form-control-sm"
                            value="{{ auth()->user()->last_name }}"
                            disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">สำนัก / กอง / ศูนย์</label>
                        <input type="text"
                            class="form-control form-control-sm"
                            value="{{ auth()->user()->department }}"
                            disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">กลุ่มงาน</label>
                        <input type="text"
                            class="form-control form-control-sm"
                            value="{{ auth()->user()->workgroup }}"
                            disabled>
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
                            value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                            readonly
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">วันที่คืน</label>
                        <input type="date"
                            name="return_date"
                            id="return_date"
                            class="form-control"
                            required>
                    </div>

                </div>
            </div>
            {{-- ✅ Accessories --}}
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
                    <b>หมายเหตุ:</b> สามารถยืมเครื่องปริ้นได้ไม่เกิน <b>7 วัน</b>
                    และต้องคืนภายในระยะเวลาที่กำหนด
                </div>
            </div>

            <div class="borrow-form-footer">
                <button type="button"
                    class="btn btn-primary w-100 rounded-pill"
                    onclick="confirmBorrow()">
                    ยืนยันการยืมเครื่องปริ้น
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    function selectPrinter(id, name, asset) {
        borrowForm.classList.add('show');
        printer_id.value = id;
        printer_name.innerText = name + ' (' + asset + ')';

        // ✅ เซ็ตวันยืม/วันคืนเหมือน notebook
        setBorrowTodayAndReturnLimit();

        borrowForm.scrollIntoView({
            behavior: 'smooth'
        });
    }

    function setBorrowTodayAndReturnLimit() {
        const today = new Date();
        const todayStr = today.toISOString().slice(0, 10);

        // ✅ วันที่ยืม = วันนี้เท่านั้น
        borrow_date.value = todayStr;

        // ✅ วันที่คืนเลือกได้ตั้งแต่วันนี้ถึงวันนี้+7
        const maxDate = new Date(today);
        maxDate.setDate(maxDate.getDate() + 7);
        const maxStr = maxDate.toISOString().slice(0, 10);

        return_date.min = todayStr;
        return_date.max = maxStr;

        // ✅ ถ้ายังไม่ได้เลือกวันคืน ให้ default เป็นวันนี้
        if (!return_date.value) {
            return_date.value = todayStr;
        }

        // ✅ ถ้าวันคืนหลุดเงื่อนไข ให้ reset
        if (return_date.value < todayStr) {
            return_date.value = todayStr;
        }
        if (return_date.value > maxStr) {
            return_date.value = maxStr;
        }
    }

    function confirmBorrow() {
        Swal.fire({
            title: 'ยืนยันการยืม',
            text: 'คุณสามารถเลือกวันคืนได้ไม่เกิน 7 วัน นับจากวันนี้',
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
        setBorrowTodayAndReturnLimit();
    });
</script>

@endsection