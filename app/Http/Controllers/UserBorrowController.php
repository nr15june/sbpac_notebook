<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Notebook;
use Illuminate\Support\Facades\Auth;

class UserBorrowController extends Controller
{
    public function index()
    {
        $notebooks = Notebook::with('borrowings')->get();
        $accessories = \App\Models\Accessory::all();

        return view('user.notebook_request', compact('notebooks','accessories'));
    }

    public function store(Request $request)
    {
        // 1. ตรวจว่าโน้ตบุ๊คนี้มีคนยืมอยู่หรือยัง
        $alreadyBorrowed = Borrowing::where('notebook_id', $request->notebook_id)
            ->where('status', 'borrowed')
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'โน้ตบุ๊คนี้ถูกยืมไปแล้ว');
        }

        // 2. บันทึกการยืม
        $borrowing = Borrowing::create([
            'user_id'     => Auth::id(),
            'notebook_id' => $request->notebook_id,
            'borrow_date'=> now(),
            'return_date'=> now()->addDays(15),
            'status'     => 'borrowed', // ⭐ สำคัญมาก
        ]);

        // 3. บันทึกอุปกรณ์เสริม
        if ($request->accessories) {
            $borrowing->accessories()->sync($request->accessories);
        }

        return redirect()->route('user.borrow_list')
            ->with('success','ยืมโน้ตบุ๊คเรียบร้อยแล้ว');
    }
}
