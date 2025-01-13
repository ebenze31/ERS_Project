<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Electorate;
use App\Models\Polling_unit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Province;
use App\Models\District;
use App\Models\Sub_district;

class Polling_unitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $polling_units = Polling_unit::where('name_polling_unit', 'LIKE', "%$keyword%")
                ->orWhere('province_id', 'LIKE', "%$keyword%")
                ->orWhere('district_id', 'LIKE', "%$keyword%")
                ->orWhere('electorate_id', 'LIKE', "%$keyword%")
                ->orWhere('sub_district_id', 'LIKE', "%$keyword%")
                ->orWhere('eligible_voters', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $polling_units = Polling_unit::latest()->paginate($perPage);
        }

        $count_units = count($polling_units);

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
}
