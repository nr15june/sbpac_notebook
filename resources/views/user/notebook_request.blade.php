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
        min-height: 420px;
        visibility: hidden;
        /* 🔒 ล็อกพื้นที่ไว้ตลอด */
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

    .placeholder {
        color: #888;
        text-align: center;
        margin-top: 80px;
    }
</style>

<h2>เลือกโน้ตบุ๊คเพื่อยืม</h2>

<div class="grid">
    @foreach($notebooks as $nb)
    @php
    $inUse = $nb->borrowings->where('status','borrowed')->count() > 0;
    @endphp

    <div class="card">
        <img src="{{ $nb->image ? asset('storage/'.$nb->image) : asset('images/no-image.png') }}">
        <h4>{{ $nb->brand }} {{ $nb->model }}</h4>
        <div>Asset: {{ $nb->asset_code }}</div>

        @if($inUse)
        <div class="busy">❌ กำลังถูกยืม</div>
        <button class="btn btn-busy" disabled>ไม่ว่าง</button>
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

{{-- ================= FORM ================= --}}
<div id="borrowForm" class="form-area">

    <h3>📝 แบบฟอร์มขอยืมโน้ตบุ๊ค</h3>

    <div id="borrowContent" style="display:none">

        <form method="POST" action="{{ route('user.borrow.store') }}">
            @csrf
            <input type="hidden" name="notebook_id" id="notebook_id">

            <b>เครื่องที่เลือก:</b>
            <span id="notebook_name"></span> (<span id="notebook_asset"></span>)
            <br><br>

            <label>ชื่อ</label>
            <input value="{{ auth()->user()->first_name }}" readonly>

            <label>นามสกุล</label>
            <input value="{{ auth()->user()->last_name }}" readonly>

            <label>สำนัก/กอง/ศูนย์</label>
            <input value="{{ auth()->user()->department }}" readonly>

            <label>กลุ่มงาน</label>
            <input value="{{ auth()->user()->workgroup }}" readonly>

            <label>เบอร์ติดต่อ</label>
            <input value="{{ auth()->user()->phone }}" readonly>

            <label>วันที่ยืม</label>
            <input type="date" name="borrow_date" id="borrow_date"
                min="{{ now()->toDateString() }}"
                onchange="calcReturn()" required>

            <label>วันที่คืน</label>
            <input type="date" name="return_date" id="return_date" readonly>

            <br>
            <b>อุปกรณ์ที่ต้องการ</b><br>
            @foreach($accessories as $a)
            <label>
                <input type="checkbox" name="accessories[]" value="{{ $a->id }}">
                {{ $a->name }}
            </label><br>
            @endforeach

            <br>
            <button class="btn btn-free">ยืนยันการยืม</button>

        </form>
    </div>
</div>

<script>
    function selectNotebook(id, name, asset) {
        const form = document.getElementById('borrowForm');
        form.classList.add('show');

        document.getElementById('borrowContent').style.display = 'block';
        document.getElementById('notebook_id').value = id;
        document.getElementById('notebook_name').innerText = name;
        document.getElementById('notebook_asset').innerText = asset;

        form.scrollIntoView({
            behavior: 'smooth'
        });
    }


    function calcReturn() {
        const borrow = document.getElementById('borrow_date').value;
        if (!borrow) return;

        const d = new Date(borrow);
        d.setDate(d.getDate() + 15);

        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');

        document.getElementById('return_date').value = `${y}-${m}-${day}`;
    }
</script>

@endsection