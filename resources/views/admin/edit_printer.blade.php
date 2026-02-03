@extends('admin.layouts')

@section('title','แก้ไขเครื่องปริ้น')

@section('content')

<div class="page-header mb-4">
    <h2 class="fw-bold mb-1">แก้ไขเครื่องปริ้น</h2>
    <p class="text-muted mb-0">ปรับปรุงข้อมูลเครื่องปริ้นในระบบ</p>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">

        <form action="{{ route('admin.printers.update', $printer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">รหัสครุภัณฑ์</label>
                    <input type="text"
                        name="asset_code"
                        class="form-control @error('asset_code') is-invalid @enderror"
                        value="{{ old('asset_code', $printer->asset_code) }}"
                        required>

                    @error('asset_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">สถานะ</label>
                    <select name="status" class="form-select" required>
                        <option value="available" {{ old('status', $printer->status) == 'available' ? 'selected' : '' }}>ว่าง</option>
                        <option value="borrowed" {{ old('status', $printer->status) == 'borrowed' ? 'selected' : '' }}>ถูกยืม</option>
                        <option value="broken" {{ old('status', $printer->status) == 'broken' ? 'selected' : '' }}>เสีย/ซ่อม</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">ยี่ห้อ</label>
                    <input type="text"
                        name="brand"
                        class="form-control"
                        value="{{ old('brand', $printer->brand) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">รุ่น</label>
                    <input type="text"
                        name="model"
                        class="form-control"
                        value="{{ old('model', $printer->model) }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">หมายเหตุ</label>
                    <textarea name="note" class="form-control" rows="3">{{ old('note', $printer->note) }}</textarea>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save2"></i> บันทึกการแก้ไข
                    </button>

                    <a href="{{ route('admin.printers.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> ย้อนกลับ
                    </a>
                </div>

            </div>
        </form>

    </div>
</div>

@endsection
