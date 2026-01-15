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
        $borrowings = Borrowing::with(['user', 'notebook'])
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

        $borrowings = Borrowing::with(['user', 'notebook'])
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
}
