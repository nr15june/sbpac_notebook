<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        // 🔐 Login Admin
        if (Auth::guard('admin')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {
            return redirect()->route('admin.borrow_management');
        }

        // 🔐 Login User
        if (Auth::guard('web')->attempt([
            'username' => $request->username,
            'password' => $request->password,
            'role' => 'user'
        ])) {
            return redirect()->route('user.notebook_request');
        }


        return back()->with('error', 'Username หรือ Password ไม่ถูกต้อง');
    }
}
