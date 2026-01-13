<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notebook;
use Illuminate\Support\Facades\Storage;

class NotebookController extends Controller
{
    public function index()
    {
        $notebooks = Notebook::orderBy('created_at', 'desc')->get();
        return view('admin.notebook_management', compact('notebooks'));
    }

    public function store(Request $request)
    {
        // ================= UPDATE =================
        if ($request->id) {
            $nb = Notebook::findOrFail($request->id);

            $request->validate([
                'asset_code' => 'required|unique:notebooks,asset_code,' . $nb->id,
                'brand' => 'required',
                'model' => 'required',
                'status' => 'required',
            ]);

            // อัปเดตข้อมูลปกติ
            $nb->update($request->only('asset_code', 'brand', 'model', 'status', 'note'));

            // ✅ ถ้ามีการอัปโหลดรูปใหม่
            if ($request->hasFile('image')) {

                // ลบรูปเก่าจริง (path แบบ notebooks/xxx.jpg)
                if ($nb->image) {
                    Storage::disk('public')->delete($nb->image);
                }

                // บันทึกรูปใหม่ และเก็บ path เต็ม
                $path = $request->file('image')->store('notebooks', 'public');
                $nb->image = $path;
                $nb->save();
            }

            return redirect()->route('admin.notebook_management')
                ->with('success', 'แก้ไขเรียบร้อยแล้ว');
        }

        // ================= CREATE =================
        $request->validate([
            'asset_code' => 'required|unique:notebooks,asset_code',
            'brand'      => 'required',
            'model'      => 'required',
            'status'     => 'required',
        ]);

        $data = $request->only('asset_code', 'brand', 'model', 'status', 'note');

        // ✅ ถ้ามีอัปโหลดรูป
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('notebooks', 'public');
            $data['image'] = $path;   // notebooks/xxx.jpg
        }

        Notebook::create($data);

        return redirect()->back()->with('success', 'เพิ่มโน้ตบุ๊คแล้ว');
    }

    public function edit($id)
    {
        $notebook = Notebook::findOrFail($id);
        $notebooks = Notebook::orderBy('created_at', 'desc')->get();

        return view('admin.notebook_management', compact('notebooks', 'notebook'));
    }

    public function destroy($id)
    {
        $nb = Notebook::findOrFail($id);

        // ลบรูปด้วย
        if ($nb->image) {
            Storage::disk('public')->delete($nb->image);
        }

        $nb->delete();

        return redirect()->back()->with('success', 'ลบแล้ว');
    }
}