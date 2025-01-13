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
        $province = $data_user->province ;
        // $polling_units = Polling_unit::get();
        $polling_units = DB::table('polling_units')
            ->leftjoin('provinces', 'polling_units.province_id', '=', 'provinces.id')
            ->leftjoin('districts', 'polling_units.district_id', '=', 'districts.id')
            ->leftjoin('electorates', 'polling_units.electorate_id', '=', 'electorates.id')
            ->leftjoin('sub_districts', 'polling_units.sub_district_id', '=', 'sub_districts.id')
            ->leftjoin('users', 'polling_units.user_id', '=', 'users.id')
            ->where('provinces.name_province', '=' ,$province)
            ->select(
                    'polling_units.*',
                    'provinces.*',
                    'districts.*',
                    'electorates.*',
                    'sub_districts.*',
                    'users.name as name_user'
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

        $old_P = "" ;
        $old_A = "" ;
        $old_electorate_A = "" ;
        $old_name_electorate = "" ;

        foreach ($rows as $row) {
            // จังหวัด
            $province = $row[0] ;
            // อำเภอ
            $district = $row[1];
            // เขตเลือกตั้งที่
            $name_electorate = $row[2];
            // ชื่อหน่วยเลือกตั้ง(ตำบล)
            $name_polling_unit = $row[3];
            // หน่วยเลือกตั้งที่
            $number_polling_unit = $row[4];
            // ชื่อหน่วย
            $name_unit = $name_polling_unit . " หน่วยที่ " . $number_polling_unit ;
            // จำนวนผู้มีสิทธิ
            $eligible_voters = $row[5];

            if($old_P != $province){
                $data_P = Province::where('name_province',$province)->first();
                $old_P = $province ;
            }

            if($old_A != $district){
                $data_A = District::where('name_district',$district)
                    ->where('province_id' , $data_P->id)
                    ->first();
                $old_A = $district ;
            }

            if($old_electorate_A == $district && $old_name_electorate == $name_electorate){
                // เหมือนกันทั้งอำเภอและเขต ข้าม
            }
            else{
                // เพิ่มใน Electorates (เขตเลือกตั้ง)
                $data_Electorates = [];
                $data_Electorates['name_electorate'] = $name_electorate ;
                $data_Electorates['province_id'] = $data_P->id ;
                $data_Electorates['district_id'] = $data_A->id ;
                $create_electorate = Electorate::create($data_Electorates);

                $old_electorate_A = $district ;
                $old_name_electorate = $name_electorate ;
            }

            // เพิ่มใน Polling_units (หน่วยลงคะแนนเสียง)
            $data_Polling_unit = [];
            $data_Polling_unit['name_polling_unit'] = $name_unit ;
            $data_Polling_unit['province_id'] = $data_P->id ;
            $data_Polling_unit['district_id'] = $data_A->id ;
            $data_Polling_unit['electorate_id'] = $create_electorate->id ;
            $data_Polling_unit['eligible_voters'] = $eligible_voters ;
            // $data_Polling_unit['sub_district_id'] = xxx ;
            // $data_Polling_unit['moo'] = xxx ;
            // $data_Polling_unit['amount_home'] = xxx ;
            Polling_unit::create($data_Polling_unit);
        }

        return "SUCCESS" ;

    }

    function create_user_units($province){


        $polling_units = DB::table('polling_units')
            ->leftjoin('provinces', 'polling_units.province_id', '=', 'provinces.id')
            ->where('provinces.name_province' ,$province)
            ->where('polling_units.user_id' , null)
            ->select('polling_units.*')
            ->get();

        if ($polling_units->isEmpty()) {
            // หากไม่มีข้อมูล polling_units ให้หยุดการทำงาน
            return "Empty polling units";
        }

        $usedPasswords = [];
        $count_create = 0 ;

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

            $count_create = $count_create + 1 ;
        }

        return $count_create ;
    }

}
