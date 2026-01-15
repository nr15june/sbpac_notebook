<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Notebook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserBorrowController extends Controller
{
    public function index()
    {
        $notebooks = Notebook::with('borrowings')->get();
        $accessories = \App\Models\Accessory::all();

        return view('user.notebook_request', compact('notebooks', 'accessories'));
    }

    public function store(Request $request)
    {
        // 🔐 VALIDATE + กฎ 15 วัน
        $request->validate([
            'notebook_id' => 'required|exists:notebooks,id',
            'borrow_date' => 'required|date',
            'return_date' => [
                'required',
                'date',
                'after_or_equal:borrow_date',
                function ($attr, $value, $fail) use ($request) {
                    $days = Carbon::parse($request->borrow_date)
                        ->diffInDays(Carbon::parse($value));

                    if ($days > 15) {
                        $fail('ไม่สามารถยืมเกิน 15 วัน');
                    }
                }
            ],
        ]);

        DB::transaction(function () use ($request) {

            // 🔒 ล็อกเครื่อง
            $notebook = Notebook::lockForUpdate()->findOrFail($request->notebook_id);

            if ($notebook->status !== 'available') {
                throw new \Exception('เครื่องนี้ไม่พร้อมให้ยืม');
            }

            // 🔐 เปลี่ยนเป็น pending
            $notebook->update([
                'status' => 'pending'
            ]);

            // 📝 สร้างรายการยืม
            $borrowing = Borrowing::create([
                'user_id'     => Auth::id(),
                'notebook_id' => $notebook->id,
                'borrow_date' => $request->borrow_date,
                'return_date' => $request->return_date,
                'status'      => 'pending',
            ]);

            // 🎒 อุปกรณ์เสริม
            if ($request->accessories) {
                $borrowing->accessories()->sync($request->accessories);
            }
        });

        return redirect()->route('user.borrow_list')
            ->with('success', 'ส่งคำขอยืมแล้ว รอแอดมินอนุมัติ');
    }

    public function borrowList()
    {
        $borrowings = Borrowing::with('notebook')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'borrowed'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.borrow_list', compact('borrowings'));
    }

    public function returnNotebook($id)
    {
        DB::transaction(function () use ($id) {

            $borrow = Borrowing::with('notebook')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->where('status', 'borrowed')
                ->firstOrFail();

            // คืนสถานะเครื่อง
            $borrow->notebook->update([
                'status' => 'available'
            ]);

            // ปิดรายการยืม
            $borrow->update([
                'status'      => 'returned',
                'return_date' => now()
            ]);
        });

        return redirect()->route('user.borrow_history')
            ->with('success', 'คืนเครื่องเรียบร้อยแล้ว');
    }

    public function borrowHistory()
    {
        $borrowings = Borrowing::with('notebook')
            ->where('user_id', Auth::id())
            ->where('status', 'returned')
            ->orderBy('return_date', 'desc')
            ->get();

        return view('user.borrow_history', compact('borrowings'));
    }
}
