<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;

        $departments = [
            'สำนักงานเลขาธิการ',
            'กองบริหารยุทธศาสตร์การพัฒนาจังหวัดชายแดนภาคใต้',
            'กองส่งเสริมและสนับสนุนงานพัฒนาฝ่ายพลเรือน',
            'กองส่งเสริมและสนับสนุนงานพัฒนาเพื่อความมั่นคง',
            'กองประสานและเร่งรัดการพัฒนาพื้นที่พิเศษจังหวัดชายแดนภาคใต้',
            'กองประสานงานโครงการอันเนื่องมาจากพระราชดำริและกิจการพิเศษ',
            'สถาบันพัฒนาเจ้าหน้าที่ของรัฐฝ่ายพลเรือนจังหวัดชายแดนภาคใต้',
            'ศูนย์ปฎิบัติการต่อต้านการทุจริต',
            'กลุ่มตรวจสอบภายใน',
            'กลุ่มงานพัฒนาระบบริหาร',
            'กลุ่มประสานงานคณะรัฐมนตรีและราชการส่วนกลาง',
        ];

        // query ผู้ใช้
        $usersQuery = User::query();

        if ($search) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('id_card', 'like', "%$search%");
            });
        }

        $users = $usersQuery->get();

        // Group: department -> workgroup
        $usersGrouped = $users
            ->groupBy('department')
            ->map(function ($deptUsers) {
                return $deptUsers->groupBy('workgroup');
            });

        // เตรียม array ให้ครบทุกหน่วยงาน
        $usersByDepartment = [];

        foreach ($departments as $dept) {
            $usersByDepartment[$dept] = $usersGrouped[$dept] ?? collect();
        }

        return view('admin.user_management', [
            'usersByDepartment' => $usersByDepartment,
            'totalDepartments' => count($departments),
            'search' => $search
        ]);
    }

    public function create()
    {
        $departments = [
            'สำนักงานเลขาธิการ',
            'กองบริหารยุทธศาสตร์การพัฒนาจังหวัดชายแดนภาคใต้',
            'กองส่งเสริมและสนับสนุนงานพัฒนาฝ่ายพลเรือน',
            'กองส่งเสริมและสนับสนุนงานพัฒนาเพื่อความมั่นคง',
            'กองประสานและเร่งรัดการพัฒนาพื้นที่พิเศษจังหวัดชายแดนภาคใต้',
            'กองประสานงานโครงการอันเนื่องมาจากพระราชดำริและกิจการพิเศษ',
            'สถาบันพัฒนาเจ้าหน้าที่ของรัฐฝ่ายพลเรือนจังหวัดชายแดนภาคใต้',
            'ศูนย์ปฎิบัติการต่อต้านการทุจริต',
            'กลุ่มตรวจสอบภายใน',
            'กลุ่มงานพัฒนาระบบริหาร',
            'กลุ่มประสานงานคณะรัฐมนตรีและราชการส่วนกลาง',
        ];

        return view('admin.create_user', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_card' => 'required|unique:users,id_card',
            'first_name' => 'required',
            'last_name'  => 'required',
            'phone'      => 'required',
            'department' => 'required|string',
            'workgroup'  => 'required|string',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
        ]);

        User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'id_card' => $request->id_card,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'department' => $request->department,
            'workgroup'  => $request->workgroup,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->route('admin.user_management')
            ->with('success', 'เพิ่มพนักงานเรียบร้อยแล้ว');
    }
}
