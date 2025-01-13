<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Province;
use App\Models\District;
use App\Models\Sub_district;
use Illuminate\Support\Facades\DB;

class For_DevController extends Controller
{
    public function add_districts()
    {
        return view('for_dev.add_districts');
    }

    public function excel_add_districts(Request $request)
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
        // ประมวลผลข้อมูลจากแถวที่ 2 เป็นต้นไป และบันทึกลงฐานข้อมูล
        foreach ($rows as $row) {
            // District::create([
            //     'name' => $row[0], // คอลัมน์ที่ 1 ของ Excel
            //     // เพิ่มฟิลด์อื่นๆ ตามที่ต้องการ
            // ]);
            // echo $row[0] . " >> " . $row[1];
            // echo "<br>";

            if($old_P != $row[0]){
                $data_P = Province::where('name_province',$row[0])->first();
                $old_P = $row[0] ;
            }

            if($old_A != $row[1]){

                $old_A = $row[1] ;

                $data_add = [];
                $data_add['province_id'] = $data_P->id ;
                $data_add['name_district'] = $row[1] ;
                District::create($data_add);

                echo "เพิ่ม " . $row[1] . " >> " . $row[0];
                echo "<br>";
            }

        }

        echo "SUCCESS";

    }

    public function excel_add_sub_districts(Request $request)
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
        // ประมวลผลข้อมูลจากแถวที่ 2 เป็นต้นไป และบันทึกลงฐานข้อมูล
        $count = 0 ;
        foreach ($rows as $row) {
            // District::create([
            //     'name' => $row[0], // คอลัมน์ที่ 1 ของ Excel
            //     // เพิ่มฟิลด์อื่นๆ ตามที่ต้องการ
            // ]);
            // echo $row[0] . " >> " . $row[1];
            // echo "<br>";

            $count = $count + 1 ;

            if($old_P != $row[0]){
                $data_P = Province::where('name_province',$row[0])->first();
                $old_P = $row[0] ;
            }

            if($old_A != $row[1]){
                $data_A = District::where('name_district',$row[1])
                    ->where('province_id' , $data_P->id)
                    ->first();
                $old_A = $row[1] ;
            }

            $data_add = [];
            $data_add['province_id'] = $data_P->id ;
            $data_add['district_id'] = $data_A->id ;
            $data_add['name_sub_districts'] = $row[2] ;
            Sub_district::create($data_add);

            echo $count . " เพิ่ม " . $row[2] . " >> " . $data_A->name_district . " >> " . $data_P->name_province;
            echo "<br>";
        }

        echo "SUCCESS";
    }

    function install_provinces(Request $request)
    {
        // provinces
        $filePath_provinces = public_path('sql/provinces.txt');
        $sql_provinces = file_get_contents($filePath_provinces);

        $check_provinces = "No" ;
        if ($sql_provinces) {
            DB::statement($sql_provinces);
            $check_provinces = "Yes" ;
        }
        
        if($check_provinces == "Yes"){
            return "provinces OK";
        }else{
            return "provinces Error";
        }
    }

    function install_districts(Request $request)
    {

        // districts
        $filePath_districts = public_path('sql/districts.txt');
        $sql_districts = file_get_contents($filePath_districts);

        $check_districts = "No" ;
        if ($sql_districts) {
            DB::statement($sql_districts);
            $check_districts = "Yes" ;
        }

        if($check_districts == "Yes"){
            return "districts OK";
        }else{
            return "districts Error";
        }
    }

    function install_sub_districts(Request $request)
    {
        // sub_districts
        $filePath_sub_districts = public_path('sql/sub_districts.txt');
        $sql_sub_districts = file_get_contents($filePath_sub_districts);

        $check_sub_districts = "No" ;
        if ($sql_sub_districts) {
            DB::statement($sql_sub_districts);
            $check_sub_districts = "Yes" ;
        }
        
        if($check_sub_districts == "Yes"){
            return "sub_districts OK";
        }else{
            return "sub_districts Error";
        }
    }
}
