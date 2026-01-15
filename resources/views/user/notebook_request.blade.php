@extends('user.layouts')

@section('title','ยืมโน้ตบุ๊ค')

@section('content')

<style>
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        background: #fff;
        text-align: center;
    }

    .card img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 6px;
    }

    .free {
        color: green;
        font-weight: 600;
    }

    .busy {
        color: red;
        font-weight: 600;
    }

    .btn {
        margin-top: 10px;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
    }

    .btn-free {
        background: #28a745;
        color: #fff;
        cursor: pointer;
    }

    .btn-busy {
        background: #aaa;
        color: #fff;
        cursor: not-allowed;
    }

    .form-area {
        max-width: 700px;
        margin-top: 40px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #fff;
        visibility: hidden;
    }

    .form-area.show {
        visibility: visible;
    }

    .form-area input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .borrow-note {
        margin: 15px 0;
        padding: 12px;
        background: #f8f9fa;
        border-left: 5px solid #3498db;
        border-radius: 6px;
    }
</style>

<h2>เลือกโน้ตบุ๊คเพื่อยืม</h2>

<div class="grid">
    @foreach($notebooks as $nb)
    <div class="card">
        <img src="{{ $nb->image ? asset('storage/'.$nb->image) : asset('images/no-image.png') }}">
        <h4>{{ $nb->brand }} {{ $nb->model }}</h4>
        <div>Asset: {{ $nb->asset_code }}</div>

        @if($nb->status === 'borrowed')
        <div class="busy">❌ กำลังถูกยืม</div>
        <button class="btn btn-busy" disabled>กำลังถูกยืม</button>

        @elseif($nb->status === 'pending')
        <div class="busy">⏳ รออนุมัติ</div>
        <button class="btn btn-busy" disabled>รออนุมัติ</button>

        @elseif($nb->status === 'repair')
        <div class="busy">🛠 อยู่ระหว่างซ่อม</div>
        <button class="btn btn-busy" disabled>ซ่อม</button>

        @else
        <div class="free">✔ พร้อมให้ยืม</div>
        <button class="btn btn-free"
            onclick="selectNotebook('{{ $nb->id }}',
                 '{{ $nb->brand }} {{ $nb->model }}',
                 '{{ $nb->asset_code }}')">
            ยืมเครื่องนี้
        </button>
        @endif

    </div>
    @endforeach
</div>

{{-- ===== FORM ===== --}}
<div id="borrowForm" class="form-area">

    <h3>📝 แบบฟอร์มขอยืมโน้ตบุ๊ค</h3>

    <div class="borrow-note">
        ⏳ สามารถยืมได้ <b>ไม่เกิน 15 วัน</b> ต่อครั้ง
    </div>

    <form method="POST" action="{{ route('user.borrow.store') }}" onsubmit="return confirmBorrow()">
        @csrf
        <input type="hidden" name="notebook_id" id="notebook_id">

        <b>เครื่องที่เลือก:</b> <span id="notebook_name"></span>
        <hr>

        <label>ชื่อ</label>
        <input value="{{ auth()->user()->first_name }}" readonly>

        <label>นามสกุล</label>
        <input value="{{ auth()->user()->last_name }}" readonly>

        <label>สำนัก / กอง / ศูนย์</label>
        <input value="{{ auth()->user()->department }}" readonly>

        <label>กลุ่มงาน</label>
        <input value="{{ auth()->user()->workgroup }}" readonly>

        <label>เบอร์ติดต่อ</label>
        <input value="{{ auth()->user()->phone }}" readonly>

        <label>วันที่ยืม</label>
        <input type="date" name="borrow_date" id="borrow_date"
            min="{{ now()->toDateString() }}"
            onchange="setReturnLimit()" required>

        <label>วันที่คืน</label>
        <input type="date" name="return_date" id="return_date" required>

        <button class="btn btn-free">ยืนยันการยืม</button>
    </form>
</div>

<script>
    function selectNotebook(id, name, asset) {
        document.getElementById('borrowForm').classList.add('show');
        document.getElementById('notebook_id').value = id;
        document.getElementById('notebook_name').innerText = name + ' (' + asset + ')';
        borrowForm.scrollIntoView({
            behavior: 'smooth'
        });
    }

    function setReturnLimit() {
        let b = new Date(borrow_date.value);
        let max = new Date(b);
        max.setDate(max.getDate() + 15);

        return_date.min = borrow_date.value;
        return_date.max = max.toISOString().slice(0, 10);
    }

    function confirmBorrow() {
        return confirm("คุณต้องการยืนยันการยืมโน้ตบุ๊คเครื่องนี้ใช่หรือไม่?");
    }
</script>

@endsection