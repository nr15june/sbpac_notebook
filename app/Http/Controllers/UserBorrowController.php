<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Notebook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PrinterBorrowing;
use App\Models\Accessory;


class UserBorrowController extends Controller
{
    public function index()
    {
        $notebooks = Notebook::where('status', '!=', 'disabled')
            ->with('borrowings')
            ->orderBy('id', 'desc')
            ->get();
        $accessories = Accessory::where('type', 'notebook')->get();

        return view('user.notebook_request', compact('notebooks', 'accessories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'notebook_id' => 'required|exists:notebooks,id',
            'phone' => 'required|string|min:9|max:20',

            'borrow_date' => [
                'required',
                'date',
                'after_or_equal:' . Carbon::today()->toDateString(),
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
                'borrower_first_name' => $request->first_name,
                'borrower_last_name'  => $request->last_name,
                'borrower_phone'      => $request->phone,

                'department' => Auth::user()->department,
                'workgroup'  => Auth::user()->workgroup,

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
        // ✅ โน้ตบุ๊ก (ดึง accessories ด้วย)
        $notebookBorrowings = Borrowing::with(['notebook', 'accessories'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'borrowed'])
            ->orderBy('created_at', 'desc')
            ->get();

        // ✅ เครื่องปริ้น (ดึง accessories ด้วย)
        $printerBorrowings = \App\Models\PrinterBorrowing::with(['printer', 'accessories'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'borrowed'])
            ->orderBy('created_at', 'desc')
            ->get();

        // ✅ รวมข้อมูลให้อยู่ format เดียวกัน
        $borrowings = collect();

        foreach ($notebookBorrowings as $b) {

            $borrowDate = Carbon::parse($b->borrow_date)->startOfDay();
            $returnDate = Carbon::parse($b->return_date)->startOfDay();
            $today = now()->startOfDay();

            if ($today->lt($borrowDate)) {
                // ยังไม่ถึงวันรับของ → นับช่วงยืมทั้งหมด
                $daysLeft = $borrowDate->diffInDays($returnDate);
            } else {
                // ถึงวันรับแล้ว → นับวันที่เหลือจริง
                $daysLeft = $today->diffInDays($returnDate, false);
                if ($daysLeft < 0) $daysLeft = 0;
            }

            $isOverdue = $today->gt($returnDate);

            $borrowings->push([
                'type' => 'notebook',
                'borrower_name' => $b->borrower_first_name . ' ' . $b->borrower_last_name,
                'name' => $b->notebook->brand . ' ' . $b->notebook->model,
                'asset_code' => $b->notebook->asset_code,
                'borrow_date' => $b->borrow_date,
                'return_date' => $b->return_date,
                'status' => $b->status,
                'accessories' => $b->accessories ?? collect(),
                'is_overdue' => $isOverdue,
                'days_left' => $daysLeft,
            ]);
        }

        foreach ($printerBorrowings as $p) {

            $borrowDate = Carbon::parse($p->borrow_date)->startOfDay();
            $returnDate = Carbon::parse($p->return_date)->startOfDay();
            $today = now()->startOfDay();

            if ($today->lt($borrowDate)) {
                $daysLeft = $borrowDate->diffInDays($returnDate);
            } else {
                $daysLeft = $today->diffInDays($returnDate, false);
                if ($daysLeft < 0) $daysLeft = 0;
            }

            $isOverdue = $today->gt($returnDate);

            $borrowings->push([
                'type' => 'printer',
                'borrower_name' => $p->borrower_first_name . ' ' . $p->borrower_last_name,
                'name' => $p->printer->brand . ' ' . $p->printer->model,
                'asset_code' => $p->printer->asset_code,
                'borrow_date' => $p->borrow_date,
                'return_date' => $p->return_date,
                'status' => $p->status,
                'accessories' => $p->accessories ?? collect(),
                'is_overdue' => $isOverdue,
                'days_left' => $daysLeft,
            ]);
        }

        // ✅ เรียงใหม่ (ล่าสุดขึ้นก่อน)
        $borrowings = $borrowings->sortByDesc('borrow_date')->values();

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
        // ✅ โน้ตบุ๊ก
        $notebookBorrowings = Borrowing::with('notebook')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($b) {
                return [
                    'type' => 'notebook',
                    'name' => $b->notebook->brand . ' ' . $b->notebook->model,
                    'asset_code' => $b->notebook->asset_code,
                    'borrow_date' => $b->borrow_date,
                    'return_date' => $b->return_date,
                    'status'        => $b->status ?? 'returned',
                    'reject_reason' => $b->reject_reason,
                    'rejected_at'   => $b->rejected_at,
                    'borrower_name' => $b->borrower_first_name . ' ' . $b->borrower_last_name,
                ];
            });

        // ✅ เครื่องปริ้น
        $printerBorrowings = PrinterBorrowing::with('printer')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($p) {
                return [
                    'type' => 'printer',
                    'name' => ($p->printer->brand ?? '-') . ' ' . ($p->printer->model ?? '-'),
                    'asset_code' => $p->printer->asset_code ?? '-',
                    'borrow_date' => $p->borrow_date,
                    'return_date' => $p->return_date,
                    'status' => $p->status ?? 'borrowed',
                    'reject_reason' => $p->reject_reason,
                    'rejected_at'   => $p->rejected_at,
                    'borrower_name' => $p->borrower_first_name . ' ' . $p->borrower_last_name,
                ];
            });

        // ✅ รวม + เรียงจากล่าสุด
        $borrowings = $notebookBorrowings
            ->merge($printerBorrowings)
            ->sortByDesc('borrow_date')
            ->values();

        return view('user.borrow_history', compact('borrowings'));
    }

    public function currentNotebook($id)
    {
        $notebook = \App\Models\Notebook::findOrFail($id);

        $borrowing = \App\Models\Borrowing::where('notebook_id', $id)
            ->whereIn('status', ['pending', 'borrowed'])
            ->latest()
            ->first();

        return view('user.current_notebook', compact('notebook', 'borrowing'));
    }
}
