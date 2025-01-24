<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\User;
use App\Models\Electorate;
use App\Models\Polling_unit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Province;
use App\Models\District;
use App\Models\Sub_district;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Polling_unitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data_user = Auth::user();
        $province = $data_user->province;
        // $polling_units = Polling_unit::get();
        $polling_units = DB::table('polling_units')
            ->leftjoin('provinces', 'polling_units.province_id', '=', 'provinces.id')
            ->leftjoin('districts', 'polling_units.district_id', '=', 'districts.id')
            ->leftjoin('electorates', 'polling_units.electorate_id', '=', 'electorates.id')
            ->leftjoin('sub_districts', 'polling_units.sub_district_id', '=', 'sub_districts.id')
            ->leftjoin('users', 'polling_units.user_id', '=', 'users.id')
            ->where('provinces.name_province', '=', $province)
            ->where('polling_units.province_id', '=', $data_user->province_id)
            ->select(
                'polling_units.*',
                'polling_units.id as unit_id',
                'provinces.*',
                'districts.*',
                'electorates.*',
                'sub_districts.*',
                'users.name as name_user',
                'users.phone_1 as phone_1_user',
                'users.phone_2 as phone_2_user',
            )
            ->get();

        $count_units = count($polling_units);

        // echo "<pre>";
        // print_r($polling_units);
        // echo "<pre>";

        return view('polling_units.index', compact('polling_units', 'count_units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('polling_units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $requestData = $request->all();

        Polling_unit::create($requestData);

        return redirect('polling_units')->with('flash_message', 'Polling_unit added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $polling_unit = Polling_unit::findOrFail($id);

        return view('polling_units.show', compact('polling_unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $polling_unit = Polling_unit::findOrFail($id);

        return view('polling_units.edit', compact('polling_unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $polling_unit = Polling_unit::findOrFail($id);
        $polling_unit->update($requestData);

        return redirect('polling_units')->with('flash_message', 'Polling_unit updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Polling_unit::destroy($id);

        return redirect('polling_units')->with('flash_message', 'Polling_unit deleted!');
    }

    function excel_add_polling_units(Request $request)
    {
        // ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        // รับไฟล์และเก็บใน storage
        $file = $request->file('file');
        $path = $file->store('uploads');  // หรือกำหนดตำแหน่งการเก็บตามต้องการ

        // อ่านข้อมูลจากไฟล์ Excel
        $data = Excel::toArray([], $file);

        // ข้ามแถวแรก (header) โดยใช้ array_slice()
        $rows = array_slice($data[0], 1);

        $old_P = "";
        $old_A = "";
        $old_electorate_A = "";
        $old_name_electorate = "";

        foreach ($rows as $row) {
            // จังหวัด
            $province = $row[0];
            // อำเภอ
            $district = $row[1];
            // เขตเลือกตั้งที่
            $name_electorate = $row[2];
            // ชื่อหน่วยเลือกตั้ง(ตำบล)
            $name_polling_unit = $row[3];
            // หน่วยเลือกตั้งที่
            $number_polling_unit = $row[4];
            // ชื่อหน่วย
            $name_unit = $name_polling_unit . " หน่วยที่ " . $number_polling_unit;
            // จำนวนผู้มีสิทธิ
            $eligible_voters = $row[5];

            if ($old_P != $province) {
                $data_P = Province::where('name_province', $province)->first();
                $old_P = $province;
            }

            if ($old_A != $district) {
                $data_A = District::where('name_district', $district)
                    ->where('province_id', $data_P->id)
                    ->first();
                $old_A = $district;
            }

            if ($old_electorate_A == $district && $old_name_electorate == $name_electorate) {
                // เหมือนกันทั้งอำเภอและเขต ข้าม
            } else {
                // เพิ่มใน Electorates (เขตเลือกตั้ง)
                $data_Electorates = [];
                $data_Electorates['name_electorate'] = $name_electorate;
                $data_Electorates['province_id'] = $data_P->id;
                $data_Electorates['district_id'] = $data_A->id;
                $create_electorate = Electorate::create($data_Electorates);

                $old_electorate_A = $district;
                $old_name_electorate = $name_electorate;
            }

            // เพิ่มใน Polling_units (หน่วยลงคะแนนเสียง)
            $data_Polling_unit = [];
            $data_Polling_unit['name_polling_unit'] = $name_unit;
            $data_Polling_unit['province_id'] = $data_P->id;
            $data_Polling_unit['district_id'] = $data_A->id;
            $data_Polling_unit['electorate_id'] = $create_electorate->id;
            $data_Polling_unit['eligible_voters'] = $eligible_voters;
            // $data_Polling_unit['sub_district_id'] = xxx ;
            // $data_Polling_unit['moo'] = xxx ;
            // $data_Polling_unit['amount_home'] = xxx ;
            Polling_unit::create($data_Polling_unit);
        }

        return "SUCCESS";
    }

    function create_user_units($province)
    {

        $polling_units = DB::table('polling_units')
            ->leftjoin('provinces', 'polling_units.province_id', '=', 'provinces.id')
            ->leftjoin('districts', 'polling_units.district_id', '=', 'districts.id')
            ->leftjoin('electorates', 'polling_units.electorate_id', '=', 'electorates.id')
            ->leftjoin('sub_districts', 'polling_units.sub_district_id', '=', 'sub_districts.id')
            ->where('provinces.name_province', $province)
            ->where('polling_units.user_id', null)
            ->select(
                'polling_units.*',
                'districts.name_district',
                'electorates.name_electorate',
            )
            ->get();

        if ($polling_units->isEmpty()) {
            // หากไม่มีข้อมูล polling_units ให้หยุดการทำงาน
            $data_return['status'] = "Empty polling units";
            return $data_return;
        }

        $usedPasswords = [];
        $usersData = [];

        foreach ($polling_units as $item) {

            do {
                // สร้างรหัสผ่านตัวเลข 6 หลักที่ไม่ซ้ำ
                $password = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (in_array($password, $usedPasswords));

            $usedPasswords[] = $password; // เก็บรหัสผ่านที่ใช้แล้ว
            $username = "officer" . ($item->province_id ?? "0") . "-" . ($item->id ?? "0");

            $user = new User();
            $user->name = "กรุณาเพิ่มชื่อของคุณ";
            $user->email = "-";
            $user->username = $username;
            $user->password = Hash::make($password);
            $user->role = "officer";
            $user->status = "active";
            $user->province = $province;

            $user->province_id = $item->province_id;
            $user->district_id = $item->district_id;
            $user->electorate_id = $item->electorate_id;
            $user->sub_district_id = $item->sub_district_id;
            $user->polling_unit_id = $item->id;

            $user->save();

            DB::table('polling_units')
                ->where('id', $item->id)
                ->update(
                    ['user_id' => $user->id]
                );

            $usersData[] = [
                'district' => $item->name_district,
                'electorate' => $item->name_electorate,
                'polling_unit' => $item->name_polling_unit,
                'username' => $username,
                'password' => $password,
            ];
        }

        return $usersData;
    }

    function after_login()
    {

        $data_user = Auth::user();
        $user_id = $data_user->id;
        $province = $data_user->province;

        $data_polling_units = DB::table('polling_units')
            ->leftjoin('provinces', 'polling_units.province_id', '=', 'provinces.id')
            ->leftjoin('districts', 'polling_units.district_id', '=', 'districts.id')
            ->leftjoin('electorates', 'polling_units.electorate_id', '=', 'electorates.id')
            ->leftjoin('sub_districts', 'polling_units.sub_district_id', '=', 'sub_districts.id')
            ->leftjoin('users', 'polling_units.user_id', '=', 'users.id')
            ->where('polling_units.user_id', '=', $user_id)
            ->select(
                'polling_units.*',
                'provinces.*',
                'districts.*',
                'electorates.*',
                'sub_districts.*'
            )
            ->first();

        // echo "<pre>";
        // print_r($data_polling_units);
        // echo "<pre>";
        // exit();

        return view('after_login', compact('data_polling_units'));
    }

    function save_user_polling_units(Request $request)
    {
        $requestData = $request->all();

        DB::table('users')
            ->where([
                ['id', $requestData['user_id']],
            ])
            ->update([
                'name' => $requestData['name_officer'],
                'phone_1' => $requestData['phone_1'],
                'phone_2' => $requestData['phone_2']
            ]);

        return "SUCCESS";
    }

    function clear_name_user($id, $user_id)
    {

        $data_user = User::where('id', $user_id)->first();
        $province_id = $data_user->province_id;

        if ($id == "all") {
            DB::table('users')
                ->where([
                    ['role', "officer"],
                    ['province_id', $province_id],
                ])
                ->update([
                    'name' => 'กรุณาเพิ่มชื่อของคุณ',
                    'phone_1' => null,
                    'phone_2' => null
                ]);
        } else {
            DB::table('users')
                ->where([
                    ['polling_unit_id', $id],
                    ['role', "officer"],
                    ['province_id', $province_id],
                ])
                ->update([
                    'name' => 'กรุณาเพิ่มชื่อของคุณ',
                    'phone_1' => null,
                    'phone_2' => null
                ]);
        }

        return "SUCCESS";
    }
    public function no_register(Request $request)
    {
        $data_user = Auth::user();
        $province = $data_user->province;
        // $polling_units = Polling_unit::get();
     
     
    //         $polling_units = DB::table('polling_units')
    // ->leftJoin('provinces', 'polling_units.province_id', '=', 'provinces.id')
    // ->leftJoin('districts', 'polling_units.district_id', '=', 'districts.id')
    // ->leftJoin('electorates', 'polling_units.electorate_id', '=', 'electorates.id')
    // ->leftJoin('sub_districts', 'polling_units.sub_district_id', '=', 'sub_districts.id')
    // ->leftjoin('users', 'polling_units.user_id', '=', 'users.id')
    //         ->where('users.name', '=', 'กรุณาเพิ่มชื่อของคุณ')
    // ->select(
    //     'sub_districts.name_sub_districts',  // ตำบล
    //     'electorates.name_electorate',      // เขตเลือกตั้ง
    //     DB::raw("GROUP_CONCAT(SUBSTRING_INDEX(name_polling_unit, ' ', -1)) as polling_unit_numbers"),  // รวมหน่วยเลือกตั้ง
    //     DB::raw('SUM(eligible_voters) as total_voters')  // รวมจำนวนผู้มีสิทธิ
    // )
    // ->groupBy('sub_districts.name_sub_districts', 'electorates.name_electorate')  // GroupBy เฉพาะตำบลและเขตเลือกตั้ง
    // ->get();


    // $polling_units = DB::table('polling_units')
    // ->leftJoin('provinces', 'polling_units.province_id', '=', 'provinces.id')
    // ->leftJoin('districts', 'polling_units.district_id', '=', 'districts.id')
    // ->leftJoin('electorates', 'polling_units.electorate_id', '=', 'electorates.id')
    // ->leftjoin('users', 'polling_units.user_id', '=', 'users.id')
    // ->where('users.name', '=', 'กรุณาเพิ่มชื่อของคุณ')
    // ->select(
    //     DB::raw("SUBSTRING_INDEX(name_polling_unit, ' หน่วยที่', 1) as name_sub_district"),  // ดึงเฉพาะชื่อตำบล
    //     'electorates.name_electorate',  // เขตเลือกตั้ง
    //     DB::raw("GROUP_CONCAT(SUBSTRING_INDEX(name_polling_unit, ' ', -1)) as polling_unit_numbers"),  // รวมหน่วยเลือกตั้ง
    //     DB::raw('SUM(eligible_voters) as total_voters')  // รวมจำนวนผู้มีสิทธิ
    // )
    // ->groupBy('name_sub_district', 'electorates.name_electorate')  // GroupBy ตามชื่อตำบล
    // ->get();

    $polling_units = DB::table('polling_units')
    ->leftJoin('provinces', 'polling_units.province_id', '=', 'provinces.id')
    ->leftJoin('districts', 'polling_units.district_id', '=', 'districts.id')
    ->leftJoin('electorates', 'polling_units.electorate_id', '=', 'electorates.id')
    ->leftjoin('users', 'polling_units.user_id', '=', 'users.id')
    ->where('users.name', '=', 'กรุณาเพิ่มชื่อของคุณ')
    ->select(
        DB::raw("SUBSTRING_INDEX(name_polling_unit, ' หน่วยที่', 1) as name_sub_district"),  // แยกชื่อตำบล
        'electorates.name_electorate',  // เขตเลือกตั้ง
        'districts.name_district',  
        DB::raw("GROUP_CONCAT(CAST(SUBSTRING_INDEX(name_polling_unit, ' ', -1) AS UNSIGNED) ORDER BY CAST(SUBSTRING_INDEX(name_polling_unit, ' ', -1) AS UNSIGNED) ASC) as polling_unit_numbers"),  // รวมหน่วยเลือกตั้งเรียงตามลำดับ
    )
    ->groupBy('name_sub_district', 'electorates.name_electorate', 'districts.name_district')  // GroupBy ตามชื่อตำบล, เขตเลือกตั้ง และอำเภอ
    ->get();

        $count_units = count($polling_units);

        // echo "<pre>";
        // print_r($polling_units);
        // echo "<pre>";

        return view('polling_units.no_register', compact('polling_units', 'count_units'));
    }
}
