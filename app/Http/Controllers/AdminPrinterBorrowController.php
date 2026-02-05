<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrinterBorrowing;
use Illuminate\Support\Facades\DB;

class AdminPrinterBorrowController extends Controller
{
    // ✅ หน้าแอดมิน: แสดงรายการ "รออนุมัติ" เครื่องปริ้น
    public function index()
    {
        $printerBorrowings = PrinterBorrowing::with(['user', 'printer', 'accessories'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.printer_borrow_management', compact('printerBorrowings'));
    }

    // ✅ อนุมัติ
    public function approve($id)
    {
        DB::transaction(function () use ($id) {

            $borrow = PrinterBorrowing::lockForUpdate()->findOrFail($id);

            if ($borrow->status !== 'pending') {
                throw new \Exception('รายการนี้ถูกจัดการไปแล้ว');
            }

            $borrow->update(['status' => 'borrowed']);
            $borrow->printer->update(['status' => 'borrowed']);
        });

        return back()->with('success', 'อนุมัติการยืมเครื่องปริ้นเรียบร้อย ✅');
    }

    // ✅ ปฏิเสธ
    public function reject($id)
    {
        DB::transaction(function () use ($id) {

            $borrow = PrinterBorrowing::lockForUpdate()->findOrFail($id);

            if ($borrow->status !== 'pending') {
                throw new \Exception('รายการนี้ถูกจัดการไปแล้ว');
            }

            $borrow->printer->update(['status' => 'available']);
            $borrow->update(['status' => 'rejected']);
        });

        return back()->with('success', 'ปฏิเสธการยืมเครื่องปริ้นแล้ว ✅');
    }
    public function confirmReturn(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $borrow = PrinterBorrowing::with(['printer', 'accessories'])
                ->where('id', $id)
                ->where('status', 'borrowed')
                ->firstOrFail();

            foreach ($borrow->accessories as $acc) {
                $borrow->accessories()->updateExistingPivot($acc->id, [
                    'is_returned' => in_array($acc->id, $request->returned_accessories ?? []),
                    'note' => $request->note
                ]);
            }

            $borrow->printer->update(['status' => 'available']);

            $borrow->update([
                'status' => 'returned',
                'return_date' => now()
            ]);
        });

        return back()->with('success', 'คืนเครื่องปริ้นเรียบร้อย ✅');
    }
}
