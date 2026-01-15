@extends('admin.layouts')

@section('title', 'เพิ่มพนักงาน')

@section('content')

<style>
    .form-card {
        background: #ffffff;
        border-radius: 10px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        font-weight: 500;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }

    .form-actions {
        margin-top: 24px;
        display: flex;
        gap: 12px;
    }

    .btn-save {
        background: #1e90ff;
        color: #fff;
        border: none;
        padding: 12px 28px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-save:hover {
        background: #1b7fd8;
    }

    .btn-cancel {
        background: #ccc;
        color: #000;
        padding: 12px 28px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
    }
</style>

{{-- ================= JS: Department -> Workgroup ================= --}}
<script>
    const departmentWorkgroups = {
        "สำนักงานเลขาธิการ": [
            "กลุ่มงานบริหารทรัพยากรบุคคล",
            "กลุ่มงานคลัง",
            "กลุ่มงานพัสดุ",
            "กลุ่มงานวินัยและนิติการ",
            "กลุ่มงานอำนวยการและบริหาร"
        ],
        "กองบริหารยุทธศาสตร์การพัฒนาจังหวัดชายแดนภาคใต้": [
            "กลุ่มงานบริหารยุทธศาสตร์การพัฒนาจังหวัดชายแดนภาคใต้",
            "กลุ่มงานบริหารงบประมาณ",
            "กลุ่มงานอํานวยการและบริหาร",
            "กลุ่มงานบริหารยุทธศาสตร์การสื่อสารสร้างความเข้าใจที่ดี"
        ],
        "กองส่งเสริมและสนับสนุนงานพัฒนาฝ่ายพลเรือน": [
            "กลุ่มงานพัฒนาเศรษฐกิจ",
            "กลุ่มงานส่งเสริมการศึกษาและส่งเสริมโอกาสทางสังคม",
            "กลุ่มงานศาสนาและพหุวัฒนธรรม",
            "กลุ่มงานอํานวยการและบริหาร"
        ],
        "กองส่งเสริมและสนับสนุนงานพัฒนาเพื่อความมั่นคง": [
            "กลุ่มงานบริหารงานยุติธรรมและอํานวยความเป็นธรรม",
            "กลุ่มงานสังคมจิตวิทยาเพื่อความมั่นคง",
            "กลุ่มงานเยียวยา",
            "กลุ่มงานส่งเสริมการมีส่วนร่วมภาคประชาสังคม",
            "กลุ่มงานอํานวยการและบริหาร",
            "ศูนย์ส่งเสริมการแก้ไขปัญหายาเสพติด"
        ],
        "กองประสานและเร่งรัดการพัฒนาพื้นที่พิเศษจังหวัดชายแดนภาคใต้": [
            "กลุ่มงานประสานและเร่งรัดการพัฒนา",
            "กลุ่มงานอํานวยการและบริหาร",
            "กลุ่มงานติดตามและประเมินผล"
        ],
        "กองประสานงานโครงการอันเนื่องมาจากพระราชดำริและกิจการพิเศษ": [
            "กลุ่มงานวิจัย วิชาการ และกิจการพิเศษ",
            "กลุ่มงานขยายผลโครงการอันเนื่องมาจากพระราชดําริจังหวัดชายแดนภาคใต้",
            "กลุ่มอํานวยการและบริหาร"
        ],
        "สถาบันพัฒนาเจ้าหน้าที่ของรัฐฝ่ายพลเรือนจังหวัดชายแดนภาคใต้": [
            "กลุ่มงานยุทธศาสตร์ วิจัย ติดตามและประเมินผล การพัฒนาเจ้าหน้าที่รัฐ",
            "วิทยาลัยพัฒนาเจ้าหน้าที่ของรัฐฝ่ายพลเรือนจังหวัดชายแดนภาคใต้",
            "กลุ่มอํานวยการและบริหาร"
        ],
        "ศูนย์ปฎิบัติการต่อต้านการทุจริต": [],
        "กลุ่มตรวจสอบภายใน": [],
        "กลุ่มงานพัฒนาระบบริหาร": [],
        "กลุ่มประสานงานคณะรัฐมนตรีและราชการส่วนกลาง": [],
    };
</script>

<div class="form-card">
    <h2>เพิ่มพนักงาน</h2>
    <p>กรอกข้อมูลพนักงาน</p>

    <form method="POST" action="{{ route('admin.user.store') }}" id="userForm">
        @csrf

        <div class="form-group">
            <label>เลขบัตรประชาชน</label>
            <input type="text"
                name="id_card"
                id="id_card"
                maxlength="13"
                oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                required>
        </div>

        <div class="form-group">
            <label>ชื่อ</label>
            <input type="text" name="first_name" required>
        </div>

        <div class="form-group">
            <label>นามสกุล</label>
            <input type="text" name="last_name" required>
        </div>

        <div class="form-group">
            <label>เบอร์โทรศัพท์</label>
            <input type="text"
                name="phone"
                id="phone"
                maxlength="10"
                oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                required>
        </div>

        <div class="form-group">
            <label>สำนัก / กอง / ศูนย์</label>
            <select name="department" id="department" required>
                <option value="">-- เลือกหน่วยงาน --</option>
                @foreach ($departments as $dept)
                <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>กลุ่มงาน</label>
            <select name="workgroup" id="workgroup" required>
                <option value="">-- เลือกกลุ่มงาน --</option>
            </select>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>รหัสผ่าน</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-actions">
            <button type="button" class="btn-save" onclick="confirmSave()">บันทึก</button>
            <a href="{{ route('admin.user_management') }}" class="btn-cancel">ยกเลิก</a>
        </div>
    </form>
</div>

<script>
    const departmentSelect = document.getElementById('department');
    const workgroupSelect = document.getElementById('workgroup');

    departmentSelect.addEventListener('change', function() {
        const selectedDept = this.value;
        workgroupSelect.innerHTML = '<option value="">-- เลือกกลุ่มงาน --</option>';

        if (departmentWorkgroups[selectedDept]) {
            departmentWorkgroups[selectedDept].forEach(group => {
                const option = document.createElement('option');
                option.value = group;
                option.textContent = group;
                workgroupSelect.appendChild(option);
            });
        }
    });

    // ยืนยันก่อนบันทึก
    function confirmSave() {
        const idCard = document.getElementById('id_card').value.trim();
        const phone = document.getElementById('phone').value.trim();

        if (idCard.length !== 13 || !/^\d+$/.test(idCard)) {
            alert("❌ เลขบัตรประชาชนต้องเป็นตัวเลข 13 หลัก");
            return;
        }

        if (phone.length !== 10 || !/^\d+$/.test(phone)) {
            alert("❌ เบอร์โทรต้องเป็นตัวเลข 10 หลัก");
            return;
        }

        if (confirm("คุณต้องการยืนยันการบันทึกข้อมูลพนักงานหรือไม่?")) {
            document.getElementById('userForm').submit();
        }
    }
</script>

@endsection