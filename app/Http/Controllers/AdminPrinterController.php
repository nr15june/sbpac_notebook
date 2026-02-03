<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Printer;
use Illuminate\Support\Facades\Storage;

class AdminPrinterController extends Controller
{
    public function index()
    {
        $printers = Printer::latest()->get();
        return view('admin.printer_management', compact('printers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_code' => 'required|unique:printers,asset_code',
            'brand' => 'required',
            'model' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['asset_code','brand','model','status','note']);

        // ✅ upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('printers', 'public');
        }

        Printer::create($data);

        return redirect()->route('admin.printers.index')->with('success', 'เพิ่มเครื่องปริ้นสำเร็จ');
    }

    public function edit($id)
    {
        $printer = Printer::findOrFail($id);
        $printers = Printer::latest()->get();

        // ✅ ให้มันกลับไปหน้าเดียวกัน แต่มีข้อมูลแก้ไข
        return view('admin.printer_management', compact('printers', 'printer'));
    }

    public function update(Request $request, $id)
    {
        $printer = Printer::findOrFail($id);

        $request->validate([
            'asset_code' => 'required|unique:printers,asset_code,' . $printer->id,
            'brand' => 'required',
            'model' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['asset_code','brand','model','status','note']);

        // ✅ ถ้ามีอัปโหลดรูปใหม่
        if ($request->hasFile('image')) {

            // ลบรูปเก่าก่อน (ถ้ามี)
            if ($printer->image && Storage::disk('public')->exists($printer->image)) {
                Storage::disk('public')->delete($printer->image);
            }

            $data['image'] = $request->file('image')->store('printers', 'public');
        }

        $printer->update($data);

        return redirect()->route('admin.printers.index')->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    public function destroy($id)
    {
        $printer = Printer::findOrFail($id);

        // ✅ ลบรูปออกจาก storage ด้วย
        if ($printer->image && Storage::disk('public')->exists($printer->image)) {
            Storage::disk('public')->delete($printer->image);
        }

        $printer->delete();

        return redirect()->route('admin.printers.index')->with('success', 'ลบเครื่องปริ้นแล้ว');
    }
}
