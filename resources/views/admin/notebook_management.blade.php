@extends('admin.layouts')

@section('title', 'จัดการโน้ตบุ๊ค')

@section('content')

<style>
    .nb-card {
        background: #fff;
        border-radius: 10px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .06);
    }

    .nb-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .nb-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }

    .nb-box {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        background: #fafafa;
    }

    .nb-list div {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-group label {
        font-size: 13px;
        display: block;
        margin-bottom: 4px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-save {
        margin-top: 10px;
        padding: 10px 20px;
        background: #1e90ff;
        border: none;
        color: #fff;
        border-radius: 6px;
        cursor: pointer;
    }

    .nb-table {
        width: 100%;
        border-collapse: collapse;
    }

    .nb-table th {
        background: #f1f2f6;
        padding: 10px;
        text-align: left;
    }

    .nb-table td {
        padding: 10px;
        border-top: 1px solid #eee;
    }

    .btn-delete {
        padding: 4px 10px;
        border: 1px solid red;
        color: red;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<div class="nb-card">

    {{-- Header --}}
    <div class="nb-header">
        <div>
            <h2>การจัดการโน้ตบุ๊ค</h2>
            <p>จัดการอุปกรณ์โน้ตบุ๊คในระบบ</p>
        </div>
    </div>

    {{-- Top Layout --}}
    <div class="nb-layout">

        {{-- Left : Notebook List --}}
        <div class="nb-box">
            <h3>📦 รายการโน้ตบุ๊ค</h3>

            <div class="nb-list">
                @foreach($notebooks as $nb)
                <div>
                    {{ $nb->asset_code }} - {{ $nb->brand }} {{ $nb->model }}
                    ({{ $nb->status }})
                </div>
                @endforeach
            </div>
        </div>

        {{-- Right : Add Notebook --}}
        <div class="nb-box">
            <h3>
                {{ isset($notebook) ? '✏️ แก้ไขโน้ตบุ๊ค' : '➕ เพิ่มโน้ตบุ๊ค' }}
            </h3>

            <form method="POST" action="{{ route('admin.notebooks.store') }}" enctype="multipart/form-data">

                @csrf

                @if(isset($notebook))
                <input type="hidden" name="id" value="{{ $notebook->id }}">
                @endif

                <div class="form-group">
                    <label>เลขครุภัณฑ์</label>
                    <input type="text" name="asset_code"
                        value="{{ $notebook->asset_code ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>ยี่ห้อ</label>
                    <input type="text" name="brand"
                        value="{{ $notebook->brand ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>รุ่น</label>
                    <input type="text" name="model"
                        value="{{ $notebook->model ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>สถานะ</label>
                    <select name="status">
                        <option value="available" @selected(($notebook->status ?? '')=='available')>พร้อมใช้งาน</option>
                        <option value="borrowed" @selected(($notebook->status ?? '')=='borrowed')>ถูกยืม</option>
                        <option value="repair" @selected(($notebook->status ?? '')=='repair')>ซ่อม</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>หมายเหตุ</label>
                    <input type="text" name="note"
                        value="{{ $notebook->note ?? '' }}">
                </div>
                
                <div class="form-group">
                    <label>รูปโน้ตบุ๊ค</label>
                    <input type="file" name="image">
                </div>

                @if(isset($notebook) && $notebook->image)
                <div style="margin-top:10px;">
                    <img src="{{ asset('storage/notebooks/'.$notebook->image) }}"
                        style="width:150px;border-radius:8px;">
                </div>
                @endif
                <button class="btn-save">
                    {{ isset($notebook) ? 'อัปเดตข้อมูล' : 'บันทึก' }}
                </button>
            </form>

        </div>

    </div>

    {{-- Bottom Table --}}
    <h3>📋 รายการโน้ตบุ๊คทั้งหมด</h3>

    <table class="nb-table">
        <thead>
            <tr>
                <th>เลขครุภัณฑ์</th>
                <th>ยี่ห้อ</th>
                <th>รุ่น</th>
                <th>สถานะ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notebooks as $nb)
            <tr>
                <td>{{ $nb->asset_code }}</td>
                <td>{{ $nb->brand }}</td>
                <td>{{ $nb->model }}</td>
                <td>{{ $nb->status }}</td>
                <td>
                    <a href="{{ route('admin.notebooks.edit',$nb->id) }}"
                        style="padding:4px 10px;border:1px solid #1e90ff;color:#1e90ff;border-radius:4px;text-decoration:none;">
                        แก้ไข
                    </a>

                    <form method="POST" action="{{ route('admin.notebooks.delete',$nb->id) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn-delete">ลบ</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection