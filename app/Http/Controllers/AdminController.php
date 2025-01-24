<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $data_province = Province::where('name_province' , $province)->first();

        return view('admin.set_system', compact('province','data_province'));
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
            // ตรวจสอบและอัปเดตเฉพาะค่าที่ไม่ว่าง
            if (!empty($requestData['color_1'])) {
                $province->color_1 = $requestData['color_1'];
            }
            if (!empty($requestData['color_2'])) {
                $province->color_2 = $requestData['color_2'];
            }
            if (!empty($requestData['color_3'])) {
                $province->color_3 = $requestData['color_3'];
            }
            if (!empty($requestData['banner_mobile'])) {
                $province->banner_mobile = $requestData['banner_mobile'];
            }
            if (!empty($requestData['banner'])) {
                $province->banner = $requestData['banner'];
            }
            if (!empty($requestData['logo'])) {
                $province->logo = $requestData['logo'];
            }
            // บันทึกการอัปเดต
            $province->save();
        }

        return redirect('set_system')->with('flash_message', 'อัพเดตข้อมูลเรียบร้อย');
    }

    function manage_user(){
        $data_user = Auth::user();
        $province = $data_user->province ;

        $data_province = Province::where('name_province' , $province)->first();

        return view('admin.manage_user', compact('province','data_province'));
    }

    function get_manage_user_dataAPI(Request $request){
        $requestData = $request->all();
        // $polling_units = Polling_unit::get();
        $data = [];
        $data['users'] = DB::table('users')
            ->leftjoin('provinces', 'users.province_id', '=', 'provinces.id')
            ->leftjoin('districts', 'users.district_id', '=', 'districts.id')
            ->leftjoin('electorates', 'users.electorate_id', '=', 'electorates.id')
            ->leftjoin('sub_districts', 'users.sub_district_id', '=', 'sub_districts.id')
            ->leftjoin('polling_units', 'users.polling_unit_id', '=', 'polling_units.id')
            ->where('users.province', '=' ,$requestData['userProvince'])
            ->where('users.role', '=' ,'officer')
            ->select(
                    'polling_units.name_polling_unit as name_polling_unit',
                    'provinces.name_province as name_province',
                    'districts.name_district as name_district',
                    'electorates.name_electorate as name_electorate',
                    'sub_districts.name_sub_districts as name_sub_districts',
                    'users.id as user_id',
                    'users.name as name_user',
                    'users.status as status_user',
                    'users.phone_1 as phone_1_user',
                    'users.phone_2 as phone_2_user',
                )
            ->get();

        $data['count'] = count($data['users']);

        return $data;
    }

    function update_user_dataAPI(Request $request){
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'ไม่พบไอดีของข้อมูลใน years']);
        }

        // ถ้าต้องการเปลี่ยน status
        if ($request->has('status')) {
            $status = $request->status;
            // ตั้งค่า status ของปีที่เลือก
            $user->status = $status;
        }
        // บันทึกการเปลี่ยนแปลง
        $user->save();

        // ดึงข้อมูลปีที่อัพเดต
        $user_after_update = User::where('province',$request->userProvince)->first();

        return response()->json(['success' => true, 'data' => $user_after_update]);
    }

}
