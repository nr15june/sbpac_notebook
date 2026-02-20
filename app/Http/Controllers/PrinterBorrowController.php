<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Printer;
use App\Models\PrinterBorrowing;
use Illuminate\Support\Facades\Auth;
use App\Models\Accessory;

class PrinterBorrowController extends Controller
{
    // ✅ หน้าแสดงรายการเครื่องปริ้นให้ผู้ใช้ยืม
    public function index()
    {
        $printers = Printer::orderBy('id', 'desc')->get();
        $accessories = Accessory::where('type', 'printer')->get();

        return view('user.printer_request', compact('printers', 'accessories'));
    }


    // ✅ บันทึกการยืมเครื่องปริ้น
    public function borrow(Request $request)
    {
        $request->validate([
            'printer_id'  => 'required|exists:printers,id',
            'borrower_first_name' => 'required|string|max:100',
            'borrower_last_name'  => 'required|string|max:100',
            'borrower_phone'      => 'nullable|string|max:20',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'phone'       => 'nullable|string|max:20',
            'accessories'   => 'nullable|array',
            'accessories.*' => 'exists:accessories,id',
        ]);

        $printer = Printer::findOrFail($request->printer_id);

        // ถ้าเครื่องปริ้นถูกยืมอยู่แล้ว ให้แจ้งเตือน
        if ($printer->status !== 'available') {
            return back()->with('error', 'เครื่องปริ้นนี้ไม่ว่าง ไม่สามารถยืมได้');
        }

        // ✅ สร้างรายการยืม
        $borrowing = PrinterBorrowing::create([
            'user_id'     => Auth::id(),
            'borrower_first_name'  => $request->borrower_first_name,
            'borrower_last_name'   => $request->borrower_last_name,
            'borrower_phone'       => $request->borrower_phone,
            'printer_id'  => $printer->id,
            'phone'       => $request->phone,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'status'      => 'pending',

        ]);

        // ✅ บันทึกอุปกรณ์เสริม
        if ($request->accessories) {
            $borrowing->accessories()->sync($request->accessories);
        }

        // ✅ อัปเดตสถานะเครื่องปริ้น
        $printer->update([
            'status' => 'pending'
        ]);

        return redirect()->route('user.borrow_list')
            ->with('success', 'ส่งคำขอยืมแล้ว รอแอดมินอนุมัติ');
    }


    // ✅ ประวัติการยืมของ user
    public function history()
    {
        $borrowings = PrinterBorrowing::with(['printer', 'accessories'])
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();


        return view('user.printer_borrow_history', compact('borrowings'));
    }
}
