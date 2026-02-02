<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Notebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBorrowController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'notebook', 'accessories'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.borrow_management', compact('borrowings'));
    }

    public function approve($id)
    {
        DB::transaction(function () use ($id) {

            $borrow = Borrowing::lockForUpdate()->findOrFail($id);

            if ($borrow->status !== 'pending') {
                throw new \Exception('รายการนี้ถูกจัดการไปแล้ว');
            }

            $borrow->update(['status' => 'borrowed']);
            $borrow->notebook->update(['status' => 'borrowed']);
        });

        return back()->with('success', 'อนุมัติเรียบร้อย');
    }

    public function reject($id)
    {
        DB::transaction(function () use ($id) {

            $borrow = Borrowing::lockForUpdate()->findOrFail($id);

            if ($borrow->status !== 'pending') {
                throw new \Exception('รายการนี้ถูกจัดการไปแล้ว');
            }

            $borrow->notebook->update(['status' => 'available']);
            $borrow->update(['status' => 'rejected']);
        });

        return back()->with('success', 'ปฏิเสธแล้ว');
    }

    public function history(Request $request)
    {
        $q = $request->q;

        $borrowings = Borrowing::with(['user', 'notebook', 'accessories'])
            ->when($q, function ($query) use ($q) {
                $query->whereHas('user', function ($u) use ($q) {
                    $u->where('first_name', 'like', "%$q%")
                        ->orWhere('last_name', 'like', "%$q%");
                })
                    ->orWhereHas('notebook', function ($n) use ($q) {
                        $n->where('brand', 'like', "%$q%")
                            ->orWhere('model', 'like', "%$q%")
                            ->orWhere('asset_code', 'like', "%$q%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.borrow_history', compact('borrowings', 'q'));
    }

    public function returnList()
    {
        $borrowings = Borrowing::with(['notebook', 'user', 'accessories'])
            ->where('status', 'borrowed')
            ->orderBy('return_date', 'asc')
            ->get();

        return view('admin.return_management', compact('borrowings'));
    }

    public function confirmReturn(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $borrow = Borrowing::with(['notebook', 'accessories'])
                ->where('id', $id)
                ->where('status', 'borrowed')
                ->firstOrFail();

            $returned = $request->input('returned_accessories', []);
            $note = $request->input('note');

            // ✅ update pivot ของอุปกรณ์แต่ละชิ้น
            foreach ($borrow->accessories as $acc) {

                $isReturned = in_array($acc->id, $returned);

                $borrow->accessories()->updateExistingPivot($acc->id, [
                    'is_returned' => $isReturned ? 1 : 0,
                    'note' => $note
                ]);
            }

            // ✅ คืนสถานะเครื่อง
            $borrow->notebook->update([
                'status' => 'available'
            ]);

            // ✅ ปิดรายการยืม
            $borrow->update([
                'status'      => 'returned',
                'return_date' => now()
            ]);

        });

        return redirect()->route('admin.return_management')
            ->with('success', 'คืนเครื่องเรียบร้อยแล้ว ✅');
    }
}
