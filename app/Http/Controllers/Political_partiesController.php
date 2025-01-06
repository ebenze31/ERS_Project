<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Political_party;
use Illuminate\Http\Request;

class Political_partiesController extends Controller
{

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $political_parties = Political_party::where('name', 'LIKE', "%$keyword%")
                ->orWhere('logo', 'LIKE', "%$keyword%")
                ->orWhere('color', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $political_parties = Political_party::latest()->paginate($perPage);
        }

        return view('political_parties.index', compact('political_parties'));
    }


    public function create()
    {
        return view('political_parties.create');
    }


    public function store(Request $request)
    {
        // การ validate ข้อมูลจากฟอร์ม
        $request->validate([
            'name' => 'required|string|max:255', // ชื่อพรรค ต้องไม่ว่าง และต้องเป็น string สูงสุด 255 ตัวอักษร
            'logo' => 'required|mimes:jpg,jpeg,png,gif|max:10240', // โลโก้ ต้องไม่ว่าง และต้องเป็นไฟล์ประเภทภาพ (jpg, jpeg, png, gif) ขนาดไม่เกิน 10MB
            'color' => 'required|string|max:7', // สีของธีม ต้องไม่ว่าง และต้องเป็น string (ปกติจะใช้ hex color code ที่มีความยาวไม่เกิน 7 ตัวอักษร)
        ], [
            'name.required' => 'กรุณากรอกชื่อพรรค', // ข้อความข้อผิดพลาดถ้าผู้ใช้ไม่กรอกชื่อพรรค
            'name.string' => 'ชื่อพรรคต้องเป็นตัวอักษรเท่านั้น', // ข้อความข้อผิดพลาดถ้าผู้ใช้กรอกข้อมูลไม่ใช่ตัวอักษร
            'name.max' => 'ชื่อพรรคต้องมีความยาวไม่เกิน 255 ตัวอักษร', // ข้อความข้อผิดพลาดถ้าชื่อพรรคยาวเกิน 255 ตัวอักษร

            'logo.required' => 'กรุณาเลือกโลโก้พรรค', // ข้อความข้อผิดพลาดถ้าผู้ใช้ไม่เลือกไฟล์
            'logo.mimes' => 'โลโก้พรรคต้องเป็นไฟล์ภาพประเภท jpg, jpeg, png หรือ gif เท่านั้น', // ข้อความข้อผิดพลาดถ้าผู้ใช้เลือกไฟล์ที่ไม่ใช่ภาพ
            'logo.max' => 'ขนาดไฟล์โลโก้พรรคต้องไม่เกิน 10MB', // ข้อความข้อผิดพลาดถ้าขนาดไฟล์เกิน 10MB

            'color.required' => 'กรุณากรอกสีของธีม', // ข้อความข้อผิดพลาดถ้าผู้ใช้ไม่กรอกสี
            'color.string' => 'สีของธีมต้องเป็นตัวอักษรเท่านั้น', // ข้อความข้อผิดพลาดถ้าผู้ใช้กรอกข้อมูลที่ไม่ใช่ตัวอักษร
            'color.max' => 'สีของธีมต้องมีความยาวไม่เกิน 7 ตัวอักษร', // ข้อความข้อผิดพลาดถ้าค่าของสีเกิน 7 ตัวอักษร
        ]);

        // หลังจาก validate ผ่านแล้ว สามารถบันทึกข้อมูลได้
        $requestData = $request->all();

        // อัพโหลดโลโก้
        if ($request->hasFile('logo')) {
            $filePath = $request->file('logo')->store('uploads', 'public');
            $requestData['logo'] = $filePath;
        }

        Political_party::create($requestData); // บันทึกข้อมูลลงในฐานข้อมูล

        return redirect('political_parties')->with('flash_message', 'Political Party added!');
    }


    public function show($id)
    {
        $political_party = Political_party::findOrFail($id);

        return view('political_parties.show', compact('political_party'));
    }

    public function edit($id)
    {
        $political_party = Political_party::findOrFail($id);

        return view('political_parties.edit', compact('political_party'));
    }

    public function update(Request $request, $id)
    {

        $requestData = $request->all();
                if ($request->hasFile('logo')) {
            $requestData['logo'] = $request->file('logo')
                ->store('uploads', 'public');
        }

        $political_party = Political_party::findOrFail($id);
        $political_party->update($requestData);

        return redirect('political_parties')->with('flash_message', 'Political_party updated!');
    }


    public function destroy($id)
    {
        Political_party::destroy($id);

        return redirect('political_parties')->with('flash_message', 'Political_party deleted!');
    }
}
