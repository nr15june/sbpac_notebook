@extends('admin.layouts')

@section('title', 'เพิ่มพนักงาน')

@section('content')

<style>
    .form-card {
        background: #fff;
        border-radius: 12px;
        padding: 28px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, .06);
        max-width: 720px;
        margin: auto;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 6px;
        display: block;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
    }

    .form-actions {
        margin-top: 24px;
        display: flex;
        gap: 12px;
    }

    .btn-save {
        background: #2563eb;
        color: #fff;
        border: none;
        padding: 12px 28px;
        border-radius: 8px;
    }

    .btn-cancel {
        background: #e5e7eb;
        padding: 12px 28px;
        border-radius: 8px;
        text-decoration: none;
        color: #111;
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
    <h2>{{ isset($user) ? '✏️ แก้ไขพนักงาน' : '➕ เพิ่มพนักงาน' }}</h2>
    <p>กรอกข้อมูลพนักงาน</p>

    <form method="POST"
        action="{{ isset($user)
            ? route('admin.user.update',$user->id)
            : route('admin.user.store') }}"
        id="userForm">

        @csrf
        @if(isset($user)) @method('PUT') @endif

        <div class="form-group">
            <label>เลขบัตรประชาชน</label>
            <input type="text"
                name="id_card"
                maxlength="13"
                value="{{ old('id_card', $user->id_card ?? '') }}"
                required>
        </div>

        <div class="form-group">
            <label>ชื่อ</label>
            <input type="text"
                name="first_name"
                value="{{ old('first_name', $user->first_name ?? '') }}"
                required>
        </div>

        <div class="form-group">
            <label>นามสกุล</label>
            <input type="text"
                name="last_name"
                value="{{ old('last_name', $user->last_name ?? '') }}"
                required>
        </div>

        <div class="form-group">
            <label>เบอร์โทรศัพท์</label>
            <input type="text"
                name="phone"
                maxlength="10"
                value="{{ old('phone', $user->phone ?? '') }}"
                required>
        </div>

        <div class="form-group">
            <label>สำนัก / กอง / ศูนย์</label>
            <select name="department" id="department" required>
                <option value="">-- เลือกหน่วยงาน --</option>
                @foreach($departments as $dept)
                <option value="{{ $dept }}"
                    @selected(old('department', $user->department ?? '')==$dept)>
                    {{ $dept }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>กลุ่มงาน</label>
            <select name="workgroup" id="workgroup" required>
                @if(isset($user))
                <option value="{{ $user->workgroup }}" selected>
                    {{ $user->workgroup }}
                </option>
                @else
                <option value="">-- เลือกกลุ่มงาน --</option>
                @endif
            </select>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email"
                name="email"
                value="{{ old('email', $user->email ?? '') }}"
                required>
        </div>

        @if(!isset($user))
        <div class="form-group">
            <label>รหัสผ่าน</label>
            <input type="password" name="password" required>
        </div>
        @endif

        <div class="form-actions">
            <button type="button" class="btn-save" id="btnConfirmSave">
                {{ isset($user) ? 'อัปเดตข้อมูล' : 'บันทึกข้อมูล' }}
            </button>
            <a href="{{ route('admin.user_management') }}" class="btn-cancel">
                ยกเลิก
            </a>
        </div>
    </form>
</div>
<script>
    const departmentSelect = document.getElementById('department');
    const workgroupSelect = document.getElementById('workgroup');

    departmentSelect.addEventListener('change', function () {
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

    // ===== ยืนยันก่อนบันทึก / อัปเดต =====
    document.getElementById('btnConfirmSave').addEventListener('click', function () {

        const idCard = document.querySelector('[name="id_card"]').value.trim();
        const phone = document.querySelector('[name="phone"]').value.trim();

        if (idCard.length !== 13 || !/^\d+$/.test(idCard)) {
            Swal.fire('ผิดพลาด', 'เลขบัตรประชาชนต้องเป็นตัวเลข 13 หลัก', 'error');
            return;
        }

        if (phone.length !== 10 || !/^\d+$/.test(phone)) {
            Swal.fire('ผิดพลาด', 'เบอร์โทรต้องเป็นตัวเลข 10 หลัก', 'error');
            return;
        }

        Swal.fire({
            title: '{{ isset($user) ? "ยืนยันการแก้ไขข้อมูล" : "ยืนยันการบันทึกข้อมูล" }}',
            text: 'คุณต้องการ{{ isset($user) ? "แก้ไข" : "บันทึก" }}ข้อมูลพนักงานนี้หรือไม่?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#9ca3af'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('userForm').submit();
            }
        });
    });
</script>


@endsection