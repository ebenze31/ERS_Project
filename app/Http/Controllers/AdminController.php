<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $data_admin = Auth::user();
        $user_province = Auth::user()->province ;
        $data_provinces = Province::where('name_province' , $user_province)->first();
        $province_id = $data_provinces->id ;
        
        return view('admin.dashboard', compact('data_admin','province_id'));
    }

    function set_system(){
        $data_user = Auth::user();
        $province = $data_user->province ;

        return view('admin.set_system', compact('province'));
    }

    public function set_system_data(Request $request)
    {
        // รับข้อมูลทั้งหมดจาก request
        $requestData = $request->all();

        // อัปโหลดโลโก้
        if ($request->hasFile('logo')) {
            $filePath = $request->file('logo')->store('uploads', 'public');
            $requestData['logo'] = $filePath;
        }

        // อัปโหลดแบนเนอร์
        if ($request->hasFile('banner')) {
            $filePath = $request->file('banner')->store('uploads', 'public');
            $requestData['banner'] = $filePath;
        }

        // อัปโหลดแบนเนอร์สำหรับมือถือ
        if ($request->hasFile('banner_mobile')) {
            $filePath = $request->file('banner_mobile')->store('uploads', 'public');
            $requestData['banner_mobile'] = $filePath;
        }

        $provinceName = $request->input('province');  // รับค่าจาก request
        // ค้นหาข้อมูล Province ที่ตรงกับชื่อใน name_province
        $province = Province::where('name_province', $provinceName)->first();

        if ($province) {
            // ถ้ามีข้อมูลแล้ว ให้ทำการอัปเดตคอลัมน์ที่เลือก
            if ($requestData['color_1']) {
                $province->color_1 = $requestData['color_1'];
            }
            if ($requestData['color_2']) {
                $province->color_2 = $requestData['color_2'];
            }
            if ($requestData['color_3']) {
                $province->color_3 = $requestData['color_3'];
            }
            if ($requestData['banner_mobile']) {
                $province->banner_mobile = $requestData['banner_mobile'];
            }
            if ($requestData['banner']) {
                $province->banner = $requestData['banner'];
            }
            if ($requestData['logo']) {
                $province->logo = $requestData['logo'];
            }
            // บันทึกการอัปเดต
            $province->save();
        }

        return redirect('set_system')->with('flash_message', 'อัพเดตข้อมูลเรียบร้อย');
    }



    // function admin_set_systemAPI(){
    //     $data = '';
    //     return $data;
    // }
}
