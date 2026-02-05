@extends('admin.layouts')

@section('title','จัดการเครื่องปริ้น')

@section('content')

<style>
    /* ===== Header ===== */
    .page-header {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
    }

    .page-header h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
    }

    .page-header p {
        margin: 0;
        font-size: 13px;
        opacity: .75;
    }

    /* ===== Cards ===== */
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
    }

    .card-title {
        font-size: 16px;
        font-weight: 600;
    }

    /* ===== Printer List ===== */
    .nb-item {
        padding: 12px 10px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .nb-item:last-child {
        border-bottom: none;
    }

    .nb-status {
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .status-available {
        background: #dcfce7;
        color: #166534;
    }

    .status-pending {
        background: #e0f2fe;
        color: #075985;
    }

    .status-borrowed {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-repair {
        background: #fef3c7;
        color: #92400e;
    }

    /* ===== Form ===== */
    .form-label {
        font-size: 13px;
        font-weight: 500;
    }

    .form-control,
    .form-select {
        font-size: 14px;
        border-radius: 10px;
    }

    .btn-save {
        background: #2563eb;
        border: none;
        padding: 10px 24px;
        border-radius: 10px;
    }

    /* ===== Table ===== */
    .table th {
        font-size: 13px;
        background: #f8fafc;
    }

    .table td {
        font-size: 14px;
        vertical-align: middle;
    }
</style>

{{-- ===== Header ===== --}}
<div class="page-header">
    <h2><i class="bi bi-printer me-1"></i> การจัดการเครื่องปริ้น</h2>
    <p>จัดการอุปกรณ์เครื่องปริ้นภายในระบบ</p>
</div>

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

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'warning',
        title: 'เกิดข้อผิดพลาด',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonText: 'ตกลง'
    });
</script>
@endif


{{-- ===== Top Section ===== --}}
<div class="row g-4 mb-4">

    {{-- ===== Left : Summary List ===== --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title mb-3">
                    <i class="bi bi-box-seam"></i> รายการเครื่องปริ้น
                </div>

                @foreach($printers as $pr)
                <div class="nb-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $pr->asset_code }}</strong><br>
                        <span class="text-muted">
                            {{ $pr->brand }} {{ $pr->model }}
                        </span>
                    </div>

                    <span class="nb-status status-{{ $pr->status }}">
                        @switch($pr->status)
                        @case('available') พร้อมใช้งาน @break
                        @case('pending') รออนุมัติ @break
                        @case('borrowed') ถูกยืม @break
                        @case('repair') ซ่อม @break
                        @endswitch
                    </span>

                </div>
                @endforeach

            </div>
        </div>
    </div>

    {{-- ===== Right : Form ===== --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-3">
                    <i class="bi bi-plus-circle"></i>
                    {{ isset($printer) ? 'แก้ไขเครื่องปริ้น' : 'เพิ่มเครื่องปริ้น' }}
                </div>

                <form method="POST"
                    action="{{ isset($printer) ? route('admin.printers.update', $printer->id) : route('admin.printers.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    @if(isset($printer))
                    @method('PUT')
                    @endif

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">รหัสครุภัณฑ์</label>
                            <input type="text" name="asset_code"
                                class="form-control"
                                value="{{ old('asset_code', $printer->asset_code ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ยี่ห้อ</label>
                            <input type="text" name="brand"
                                class="form-control"
                                value="{{ old('brand', $printer->brand ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">รุ่น</label>
                            <input type="text" name="model"
                                class="form-control"
                                value="{{ old('model', $printer->model ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">สถานะ</label>
                            <select name="status" class="form-select">
                                <option value="available">พร้อมใช้งาน</option>
                                <option value="pending">รออนุมัติ</option>
                                <option value="borrowed">ถูกยืม</option>
                                <option value="repair">ซ่อม</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">หมายเหตุ</label>
                            <input type="text" name="note"
                                class="form-control"
                                value="{{ old('note', $printer->note ?? '') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">รูปเครื่องปริ้น</label>
                            <input type="file" name="image" class="form-control" id="imageInput">
                        </div>

                        @if(isset($printer) && $printer->image)
                        {{-- หน้าแก้ไข + มีรูปเดิม --}}
                        <img id="previewImage"
                            src="{{ asset('storage/'.$printer->image) }}"
                            style="width:160px;border-radius:12px;margin-top:8px;">
                        @else
                        {{-- หน้าเพิ่มใหม่ หรือยังไม่มีรูป --}}
                        <img id="previewImage"
                            style="width:160px;border-radius:12px;margin-top:8px; display:none;">
                        @endif
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-primary btn-save">
                            {{ isset($printer) ? 'อัปเดตข้อมูล' : 'บันทึกข้อมูล' }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>


{{-- ===== Table ===== --}}
<div class="card">
    <div class="card-body">
        <div class="card-title mb-3">
            <i class="bi bi-table"></i> รายการเครื่องปริ้นทั้งหมด
        </div>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>รูป</th>
                    <th>รหัสครุภัณฑ์</th>
                    <th>ยี่ห้อ</th>
                    <th>รุ่น</th>
                    <th>สถานะ</th>
                    <th class="text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($printers as $pr)
                <tr>
                    <td>
                        <img src="{{ $pr->image ? asset('storage/'.$pr->image) : asset('images/no-image.png') }}"
                            style="width:55px;height:55px;object-fit:cover;border-radius:10px;">
                    </td>
                    <td class="fw-semibold">{{ $pr->asset_code }}</td>
                    <td>{{ $pr->brand }}</td>
                    <td>{{ $pr->model }}</td>
                    <td>
                        <span class="nb-status status-{{ $pr->status }}">
                            {{ $pr->status == 'available' ? 'พร้อมใช้งาน' : ($pr->status == 'pending' ? 'รออนุมัติ' : ($pr->status == 'borrowed' ? 'ถูกยืม' : 'ซ่อม')) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.printers.edit',$pr->id) }}"
                            class="btn btn-sm btn-outline-primary">
                            แก้ไข
                        </a>

                        <form method="POST"
                            action="{{ route('admin.printers.destroy',$pr->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete">
                                ลบ
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<script>
    // ===== Save / Update =====
    document.querySelector('.btn-save')?.addEventListener('click', function() {
        const form = this.closest('form');

        Swal.fire({
            title: 'ยืนยันการบันทึกข้อมูล',
            text: 'คุณต้องการบันทึกข้อมูลเครื่องปริ้นนี้หรือไม่?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'บันทึก',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#d1d5db'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // ===== Delete =====
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');

            Swal.fire({
                title: 'ยืนยันการลบข้อมูล',
                text: 'ข้อมูลนี้จะไม่สามารถกู้คืนได้',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ลบ',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#d1d5db'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // ===== Preview Image =====
    document.getElementById('imageInput')?.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('previewImage');
            img.src = e.target.result;
            img.style.display = 'block'; // ✅ สำคัญมาก
        };
        reader.readAsDataURL(file);
    });
</script>

@endsection