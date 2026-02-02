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
        $request->validate([
            'notebook_id' => 'required|exists:notebooks,id',
            'phone' => 'required|string|min:9|max:20',

            // ✅ วันที่ยืม = ต้องเป็นวันนี้เท่านั้น
            'borrow_date' => [
                'required',
                'date',
                function ($attr, $value, $fail) {
                    $today = Carbon::today()->toDateString();
                    if (Carbon::parse($value)->toDateString() !== $today) {
                        $fail('วันที่ยืมต้องเป็นวันที่ปัจจุบันเท่านั้น');
                    }
                }
            ],

            // ✅ วันที่คืน = ต้องหลังวันยืม + ไม่เกิน 7 วัน
            'return_date' => [
                'required',
                'date',
                'after_or_equal:borrow_date',
                function ($attr, $value, $fail) use ($request) {

                    $borrowDate = Carbon::parse($request->borrow_date)->startOfDay();
                    $returnDate = Carbon::parse($value)->startOfDay();

                    // ห้ามคืนย้อนหลัง
                    if ($returnDate->lt($borrowDate)) {
                        $fail('วันที่คืนต้องไม่น้อยกว่าวันที่ยืม');
                        return;
                    }

                    // ✅ นับจำนวนวันห่าง (0-7)
                    $days = $borrowDate->diffInDays($returnDate);

                    if ($days > 7) {
                        $fail('ไม่สามารถยืมเกิน 7 วัน');
                    }
                }
            ],
        ]);

        DB::transaction(function () use ($request) {

            $notebook = Notebook::lockForUpdate()->findOrFail($request->notebook_id);

            if ($notebook->status !== 'available') {
                throw new \Exception('เครื่องนี้ไม่พร้อมให้ยืม');
            }

            $notebook->update(['status' => 'pending']);

            $borrowing = Borrowing::create([
                'user_id'     => Auth::id(),
                'phone'       => $request->phone,
                'notebook_id' => $notebook->id,
                'borrow_date' => $request->borrow_date,
                'return_date' => $request->return_date,
                'status'      => 'pending',
            ]);

            if ($request->accessories) {
                $borrowing->accessories()->sync($request->accessories);
            }
        });

        return redirect()->route('user.borrow_list')
            ->with('success', 'ส่งคำขอยืมแล้ว รอแอดมินอนุมัติ');
    }


    public function borrowList()
    {
        $borrowings = Borrowing::with(['notebook', 'accessories'])
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
        $borrowings = Borrowing::with(['notebook', 'accessories'])
            ->where('user_id', Auth::id())
            ->where('status', 'returned')
            ->orderBy('return_date', 'desc')
            ->get();

        return view('user.borrow_history', compact('borrowings'));
    }
}
