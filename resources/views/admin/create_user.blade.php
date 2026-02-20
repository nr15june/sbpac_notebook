@extends('admin.layouts')

@section('title', 'เพิ่มพนักงาน')

@section('content')
<style>
    body {
        background: #f4f6f9;
        font-family: 'Sarabun', sans-serif;
    }

    /* ===== Page Header ===== */
    .page-header {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        border-radius: 14px;
        padding: 14px 20px;
        margin-bottom: 18px;
    }

    .page-header h4 {
        font-size: 20px;
        margin: 0;
        font-weight: 600;
    }

    /* ===== Form Wrapper ===== */
    .form-wrapper {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px 26px;
        box-shadow: 0 8px 22px rgba(0, 0, 0, .08);
    }

    /* ===== Section ===== */
    .section-card {
        position: relative;
        padding: 18px 20px 18px 28px;
        margin-bottom: 16px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
    }

    .section-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #111827;
    }

    /* ===== Form ===== */
    .form-label {
        font-size: 13.5px;
        font-weight: 500;
        color: #374151;
    }

    .form-control,
    .form-select {
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, .15);
    }

    /* ===== Buttons ===== */
    .btn-primary {
        background: #2563eb;
        border: none;
        border-radius: 8px;
        padding: 8px 22px;
        font-size: 14px;
    }

    .btn-light {
        border-radius: 8px;
        padding: 8px 20px;
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

{{-- ===== FORM START ===== --}}
<form method="POST"
    action="{{ isset($user) ? route('admin.user.update', $user->id) : route('admin.user.store') }}"
    id="userForm">

    @csrf
    @if(isset($user))
    @method('PUT')
    @endif

    {{-- Header --}}
    <div class="page-header d-flex align-items-center gap-3">
        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center"
            style="width:48px;height:48px;font-size:22px;">
            <i class="bi bi-person-plus"></i>
        </div>
        <div>
            <h4>เพิ่มพนักงาน</h4>
            <small class="opacity-75">กรอกข้อมูลพนักงานเพื่อเพิ่มเข้าสู่ระบบ</small>
        </div>
    </div>

    {{-- ✅ แจ้งเตือนเมื่อ Validation ผิด --}}
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'กรอกข้อมูลไม่ถูกต้อง',
                html: `
            <div style="text-align:left;font-size:14px;">
                {!! implode('<br>', $errors->all()) !!}
            </div>
        `,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#dc2626'
            });
        });
    </script>
    @endif


    <div class="form-wrapper">
        <div class="section-card">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control"
                    value="{{ old('username', $user->username ?? '') }}">
            </div>
            {{-- ===== ข้อมูลส่วนตัว ===== --}}
            <div class="section-title">👤 ข้อมูลส่วนตัว</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <input type="text" class="form-control"
                        name="first_name"
                        value="{{ old('first_name', $user->first_name ?? '') }}"
                        required>
                </div>


                <div class="col-md-6">
                    <input type="text" class="form-control"
                        name="last_name"
                        value="{{ old('last_name', $user->last_name ?? '') }}"
                        required>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">สำนัก / กอง / ศูนย์</label>
                    <select class="form-select"
                        name="department"
                        id="department"
                        required>
                        <option value="">-- เลือกหน่วยงาน --</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept }}"
                            {{ old('department', $user->department ?? '') == $dept ? 'selected' : '' }}>
                            {{ $dept }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">กลุ่มงาน</label>
                    <select class="form-select"
                        name="workgroup"
                        id="workgroup"
                        required>
                        <option value="">-- เลือกกลุ่มงาน --</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control"
                        name="phone"
                        value="{{ old('phone', $user->phone ?? '') }}"
                        maxlength="10"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">รหัสผ่าน</label>
                    <input type="password"
                        class="form-control"
                        name="password"
                        required>
                </div>
            </div>
        </div>
        {{-- Actions --}}
        <div class="d-flex justify-content-end gap-3 mt-4">
            <button type="button" class="btn btn-primary" id="btnConfirmSave"> บันทึกข้อมูล </button>
            <a href="{{ route('admin.user_management') }}" class="btn btn-light"> ยกเลิก </a>
        </div>
    </div>

</form>
{{-- ===== FORM END ===== --}}

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const oldDepartment = "{{ old('department', $user->department ?? '') }}";
        const oldWorkgroup = "{{ old('workgroup', $user->workgroup ?? '') }}";

        if (oldDepartment) {
            departmentSelect.value = oldDepartment;
            departmentSelect.dispatchEvent(new Event('change'));

            setTimeout(() => {
                workgroupSelect.value = oldWorkgroup;
            }, 100);
        }
    });


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

    document.getElementById('btnConfirmSave').addEventListener('click', function() {
        Swal.fire({
            title: 'ยืนยันการบันทึกข้อมูล',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#2563eb',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('userForm').submit();
            }
        });
    });
</script>

@endsection