@extends('admin.layouts')

@section('title','จัดการโน้ตบุ๊ก')

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
        box-shadow: 0 10px 25px rgba(0,0,0,.06);
    }

    .card-title {
        font-size: 16px;
        font-weight: 600;
    }

    /* ===== Notebook List ===== */
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

    .status-borrowed {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-repair {
        background: #fef3c7;
        color: #92400e;
    }

    .status-pending {
        background: #e0f2fe;
        /* ฟ้าอ่อน */
        color: #0369a1;
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

    .action-btn {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        text-decoration: none;
    }
</style>

{{-- ===== Header ===== --}}
<div class="page-header">
    <h2><i class="bi bi-laptop me-1"></i> การจัดการโน้ตบุ๊ก</h2>
    <p>จัดการอุปกรณ์โน้ตบุ๊กภายในระบบ</p>
</div>
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
                    <i class="bi bi-box-seam"></i> รายการโน้ตบุ๊ก
                </div>

                @foreach($notebooks as $nb)
                <div class="nb-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $nb->asset_code }}</strong><br>
                        <span class="text-muted">
                            {{ $nb->brand }} {{ $nb->model }}
                        </span>
                    </div>

                    <span class="nb-status status-{{ $nb->status }}">
                        {{ $nb->status_text }}
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
                    {{ isset($notebook) ? 'แก้ไขโน้ตบุ๊ก' : 'เพิ่มโน้ตบุ๊ก' }}
                </div>

                <form method="POST"
                    action="{{ route('admin.notebooks.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    @if(isset($notebook))
                    <input type="hidden" name="id" value="{{ $notebook->id }}">
                    @endif

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">เลขครุภัณฑ์</label>
                            <input type="text" name="asset_code"
                                class="form-control"
                                value="{{ $notebook->asset_code ?? '' }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ยี่ห้อ</label>
                            <input type="text" name="brand"
                                class="form-control"
                                value="{{ $notebook->brand ?? '' }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">รุ่น</label>
                            <input type="text" name="model"
                                class="form-control"
                                value="{{ $notebook->model ?? '' }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">สถานะ</label>
                            <select name="status" class="form-select">
                                <option value="available" @selected(($notebook->status ?? '')=='available')>
                                    พร้อมใช้งาน
                                </option>
                                <option value="pending" @selected(($notebook->status ?? '')=='pending')>
                                    รออนุมัติ
                                </option>
                                <option value="borrowed" @selected(($notebook->status ?? '')=='borrowed')>
                                    ถูกยืม
                                </option>
                                <option value="repair" @selected(($notebook->status ?? '')=='repair')>
                                    ซ่อม
                                </option>

                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">หมายเหตุ</label>
                            <input type="text" name="note"
                                class="form-control"
                                value="{{ $notebook->note ?? '' }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">รูปโน้ตบุ๊ก</label>
                            <input type="file" name="image" class="form-control" id="imageInput">
                        </div>

                        <div class="col-12">
                            @if(isset($notebook) && $notebook->image)
                            {{-- หน้าแก้ไข + มีรูปเดิม --}}
                            <img id="previewImage"
                                src="{{ asset('storage/'.$notebook->image) }}"
                                style="width:160px;border-radius:12px;margin-top:8px;">
                            @else
                            {{-- หน้าเพิ่มใหม่ หรือยังไม่มีรูป --}}
                            <img id="previewImage"
                                style="width:160px;border-radius:12px;margin-top:8px; display:none;">
                            @endif
                        </div>

                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-primary btn-save">
                            {{ isset($notebook) ? 'อัปเดตข้อมูล' : 'บันทึกข้อมูล' }}
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
            <i class="bi bi-table"></i> รายการโน้ตบุ๊กทั้งหมด
        </div>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>รูป</th>
                    <th>เลขครุภัณฑ์</th>
                    <th>ยี่ห้อ</th>
                    <th>รุ่น</th>
                    <th>สถานะ</th>
                    <th class="text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notebooks as $nb)
                <tr>
                    {{-- รูป --}}
                    <td>
                        @if($nb->image)
                        <img src="{{ asset('storage/'.$nb->image) }}"
                            style="width:70px;height:50px;object-fit:cover;border-radius:8px;">
                        @else
                        <span class="text-muted">ไม่มีรูป</span>
                        @endif
                    </td>

                    {{-- เลขครุภัณฑ์ --}}
                    <td>{{ $nb->asset_code }}</td>

                    {{-- ยี่ห้อ --}}
                    <td>{{ $nb->brand }}</td>

                    {{-- รุ่น --}}
                    <td>{{ $nb->model }}</td>

                    {{-- สถานะ --}}
                    <td>
                        <span class="nb-status status-{{ $nb->status }}">
                            {{ $nb->status_text }}
                        </span>
                    </td>

                    {{-- จัดการ --}}
                    <td class="text-center">
                        <a href="{{ route('admin.notebooks.edit',$nb->id) }}"
                            class="btn btn-sm btn-outline-primary">
                            แก้ไข
                        </a>

                        <form method="POST"
                            action="{{ route('admin.notebooks.delete',$nb->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="btn btn-sm btn-outline-danger btn-delete">
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
            text: 'คุณต้องการบันทึกข้อมูลโน้ตบุ๊กนี้หรือไม่?',
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
</script>
<script>
    document.getElementById('imageInput')?.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('previewImage');
            img.src = e.target.result;
            img.style.display = 'block'; // ✅ สำคัญ
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection