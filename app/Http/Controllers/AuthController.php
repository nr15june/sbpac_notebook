<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // พยายาม login เป็น Admin ก่อน
        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return redirect()->route('admin.borrow_management');
        }

        // ถ้าไม่ใช่ admin → ลอง login เป็น user
        if (Auth::guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user'
        ])) {
            return redirect()->route('user.notebook_request');
        }

        return back()->with('error','Email หรือ Password ไม่ถูกต้อง');
    }
}
