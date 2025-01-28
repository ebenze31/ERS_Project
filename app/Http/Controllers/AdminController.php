<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Electorate;
use App\Models\Polling_unit;
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

    function manage_user(Request $request){
        // รับข้อมูลจากฟอร์มและจัดกลุ่มในอาเรย์
        $data_search = [
            'search_district' => $request->input('search_district'),
            'search_electorate' => $request->input('search_electorate'),
            'search_polling_unit' => $request->input('search_polling_unit')
        ];

        $data_user = Auth::user();
        $province = $data_user->province ;

        $data_province = Province::where('name_province' , $province)->first();

        $data_district = District::where('province_id' , $data_province->id)->get();

        return view('admin.manage_user', compact('province','data_province', 'data_search','data_district'));
    }

    public function get_manage_user_dataAPI(Request $request)
    {
        $requestData = $request->all();

        // เริ่มต้น query
        $query = DB::table('users')
            ->leftjoin('provinces', 'users.province_id', '=', 'provinces.id')
            ->leftjoin('districts', 'users.district_id', '=', 'districts.id')
            ->leftjoin('electorates', 'users.electorate_id', '=', 'electorates.id')
            ->leftjoin('sub_districts', 'users.sub_district_id', '=', 'sub_districts.id')
            ->leftjoin('polling_units', 'users.polling_unit_id', '=', 'polling_units.id')
            ->where('users.province', '=', $requestData['userProvince'])
            ->where('users.role', '=', 'officer')
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
            );

        if (!empty($requestData['search_district'])) {
            $query->where('districts.id',$requestData['search_district']);
        }

        if (!empty($requestData['search_electorate'])) {
            $query->where('electorates.id',$requestData['search_electorate']);
        }

        if (!empty($requestData['search_polling_unit'])) {
            $searchTerm = $requestData['search_polling_unit'];

            $query->whereRaw("SUBSTRING_INDEX(polling_units.name_polling_unit, ' ', 1) = ?", [$searchTerm]);
        }

        // if (!empty($requestData['search_polling_unit'])) {
        //     $query->where('polling_units.name_polling_unit', $requestData['search_polling_unit']);
        // }

        // ดึงข้อมูลจากฐานข้อมูล
        $data['users'] = $query->get();

        // นับจำนวนข้อมูลที่ได้
        $data['count'] = count($data['users']);

        return $data;
    }


    public function update_user_dataAPI(Request $request)
    {
        // รับข้อมูลทั้งหมดจาก request
        $requestData = $request->all();

        // ค้นหา User ตาม user_id
        $user = User::where('id', $requestData['user_id'])->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'ไม่พบไอดีของข้อมูลใน table users']);
        }

        // ตรวจสอบสถานะ toggle_status และอัปเดตข้อมูล
        if ($requestData['toggle_status'] === "delete") {
            // ลบข้อมูล status, name, phone_1 และ phone_2
            $user->update([
                'status' => $requestData['status'],
                'name' => "กรุณาเพิ่มชื่อของคุณ",
                'phone_1' => null,
                'phone_2' => null,
            ]);
        } else {
            // อัปเดตเฉพาะสถานะ status
            $user->update([
                'status' => $requestData['status'],
            ]);
        }

        $data_user_update = DB::table('users')
        ->leftjoin('provinces', 'users.province_id', '=', 'provinces.id')
        ->leftjoin('districts', 'users.district_id', '=', 'districts.id')
        ->leftjoin('electorates', 'users.electorate_id', '=', 'electorates.id')
        ->leftjoin('sub_districts', 'users.sub_district_id', '=', 'sub_districts.id')
        ->leftjoin('polling_units', 'users.polling_unit_id', '=', 'polling_units.id')
        ->where('users.id', '=' ,$requestData['user_id'])
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
        ->first();

        // ส่งข้อมูลผู้ใช้งานที่อัปเดตกลับมา
        return response()->json(['success' => true, 'data' => $data_user_update]);
    }

    public function multi_update_user_dataAPI(Request $request)
    {
        // รับข้อมูลทั้งหมดจาก request
        $requestData = $request->all();

        // รับ array ของ user_id จาก request
        $userIds = $requestData['user_ids']; // user_ids ควรเป็น array ของ user_id ที่ต้องการอัปเดต

        // ค้นหาผู้ใช้หลายๆ คนด้วย user_id จาก array
        $users = User::whereIn('id', $userIds)->get();

        if ($users->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'ไม่พบข้อมูลผู้ใช้ใน table users']);
        }

        // อัปเดตข้อมูลในแต่ละ user
        foreach ($users as $user) {
            if ($requestData['toggle_status'] === "delete") {
                // ถ้าต้องการลบข้อมูล
                $user->update([
                    'status' => $requestData['status'],
                    'name' => "กรุณาเพิ่มชื่อของคุณ",
                    'phone_1' => null,
                    'phone_2' => null,
                ]);
            } else {
                // อัปเดตเฉพาะสถานะ
                $user->update([
                    'status' => $requestData['status'],
                ]);
            }
        }

        // ดึงข้อมูลผู้ใช้งานที่อัปเดตทั้งหมด
        $updatedUsers = DB::table('users')
            ->leftjoin('provinces', 'users.province_id', '=', 'provinces.id')
            ->leftjoin('districts', 'users.district_id', '=', 'districts.id')
            ->leftjoin('electorates', 'users.electorate_id', '=', 'electorates.id')
            ->leftjoin('sub_districts', 'users.sub_district_id', '=', 'sub_districts.id')
            ->leftjoin('polling_units', 'users.polling_unit_id', '=', 'polling_units.id')
            ->whereIn('users.id', $userIds) // ใช้ whereIn เพื่อดึงข้อมูลหลายๆ ไอดี
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
                'users.phone_2 as phone_2_user'
            )
            ->get();

        // ส่งข้อมูลผู้ใช้งานที่อัปเดตกลับมา
        return response()->json(['success' => true, 'data' => $updatedUsers]);
    }

    public function get_district_dataAPI(Request $request)
    {
        $electorates = Electorate::where('province_id', $request->province_id)
                            ->where('district_id', $request->district_id)
                            ->get();

        return response()->json(['electorates' => $electorates]);
    }

    public function get_polling_unit_dataAPI(Request $request)
    {
        $polling_units = Polling_unit::where('province_id', $request->province_id)
                            ->where('district_id', $request->district_id)
                            ->where('electorate_id', $request->electorate_id)
                            ->get();

        return response()->json(['polling_units' => $polling_units]);
    }



}
