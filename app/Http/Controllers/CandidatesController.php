<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Candidate;
use App\Models\District;
use App\Models\Electorate;
use App\Models\Political_party;
use App\Models\Province;
use App\Models\Sub_district;
use App\Models\Type_candidate;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class CandidatesController extends Controller
{

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $candidates = Candidate::where('name', 'LIKE', "%$keyword%")
                ->orWhere('img', 'LIKE', "%$keyword%")
                ->orWhere('number', 'LIKE', "%$keyword%")
                ->orWhere('province_id', 'LIKE', "%$keyword%")
                ->orWhere('district_id', 'LIKE', "%$keyword%")
                ->orWhere('electorate_id', 'LIKE', "%$keyword%")
                ->orWhere('sub_district_id', 'LIKE', "%$keyword%")
                ->orWhere('political_partie_id', 'LIKE', "%$keyword%")
                ->orWhere('year_id', 'LIKE', "%$keyword%")
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $candidates = Candidate::latest()->paginate($perPage);
        }

        $type_candidates = Type_candidate::get();

        return view('candidates.index', compact('candidates','type_candidates'));
    }

    public function create()
    {
        $politicalParties = Political_party::get();
        $years = Year::get();
        $provinces = Province::get();
        $type_candidates = Type_candidate::get();

        return view('candidates.create', compact('politicalParties','years','provinces','type_candidates'));
    }

    public function store(Request $request)
    {
        $requestData = $request->all();

        $validator = FacadesValidator::make($request->all(), [
            'name' => 'required|string|max:255',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'number' => 'required|numeric|min:1',
            'political_partie_id' => 'required|exists:political_parties,id',
            'province_id' => 'required|exists:provinces,id',
            'district_id' => 'nullable|exists:districts,id',
            'electorate_id' => 'nullable|exists:electorates,id',
            'sub_district_id' => 'nullable|exists:sub_districts,id',
            'year_id' => 'required|exists:years,id',
            'type' => 'required|string|max:255',
        ], [
            'name.required' => 'กรุณากรอกชื่อ-สกุล',
            'name.string' => 'ชื่อ-สกุลต้องเป็นตัวอักษรเท่านั้น',
            'name.max' => 'ชื่อ-สกุลต้องไม่เกิน 255 ตัวอักษร',

            'img.required' => 'กรุณาเพิ่มไฟล์รูปภาพ',
            'img.image' => 'ไฟล์รูปต้องเป็นรูปภาพ',
            'img.mimes' => 'รองรับเฉพาะไฟล์ .jpeg, .png, .jpg, .gif, .svg',
            'img.max' => 'ขนาดไฟล์รูปภาพไม่ควรเกิน 2MB',

            'number.required' => 'กรุณากรอกหมายเลขผู้สมัคร',
            'number.numeric' => 'หมายเลขผู้สมัครต้องเป็นตัวเลข',
            'number.min' => 'หมายเลขผู้สมัครต้องไม่น้อยกว่า 1',

            'political_partie_id.required' => 'กรุณาเลือกพรรคการเมือง',
            'political_partie_id.exists' => 'พรรคการเมืองที่เลือกไม่ถูกต้อง',

            'province_id.required' => 'กรุณาเลือกจังหวัด',
            'province_id.exists' => 'จังหวัดที่เลือกไม่ถูกต้อง',

            'district_id.exists' => 'เขตเลือกตั้งที่เลือกไม่ถูกต้อง',

            'electorate_id.exists' => 'เขตเลือกตั้งที่เลือกไม่ถูกต้อง',

            'sub_district_id.exists' => 'ตำบลที่เลือกไม่ถูกต้อง',

            'year_id.required' => 'กรุณาเลือกปีการเลือกตั้ง',
            'year_id.exists' => 'ปีการเลือกตั้งที่เลือกไม่ถูกต้อง',

            'type.required' => 'กรุณากรอกประเภทผู้สมัคร',
            'type.string' => 'ประเภทผู้สมัครต้องเป็นตัวอักษรเท่านั้น',
            'type.max' => 'ประเภทผู้สมัครต้องไม่เกิน 255 ตัวอักษร',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }


        $type_candidate = Type_candidate::firstOrCreate(
            ['name' => $requestData['type']] // เอา ชื่อที่ได้จาก type มาบันทึกในตาราง type_candidates
        );

        $requestData['type'] = $type_candidate->name; //กำหนด type ให้เป็น name ของ type_candidates เพื่อเอาไปบันทึกในตาราง candidates

        // อัพโหลดโลโก้
        if ($request->hasFile('img')) {
            $filePath = $request->file('img')->store('uploads', 'public');
            $requestData['img'] = $filePath;
        }

        Candidate::create($requestData);

        return redirect('candidates')->with('flash_message', 'Candidate added!');
    }

    public function show($id)
    {
        $candidate = Candidate::findOrFail($id);

        return view('candidates.show', compact('candidate'));
    }

    public function edit($id)
    {
        $politicalParties = Political_party::get();
        $years = Year::get();
        $candidate = Candidate::findOrFail($id);
        $provinces = Province::get();
        $type_candidates = Type_candidate::get();

        return view('candidates.edit', compact('candidate','politicalParties','years','provinces','type_candidates'));
    }

    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $type_candidate = Type_candidate::firstOrCreate(
            ['name' => $requestData['type']] // เอา ชื่อที่ได้จาก type มาบันทึกในตาราง type_candidates
        );
        $requestData['type'] = $type_candidate->name; //กำหนด type ให้เป็น name ของ type_candidates เพื่อเอาไปบันทึกในตาราง candidates

        if ($request->hasFile('img')) {
            $filePath = $request->file('img')->store('uploads', 'public');
            $requestData['img'] = $filePath;
        }

        $candidate = Candidate::findOrFail($id);
        $candidate->update($requestData);

        return redirect('candidates')->with('flash_message', 'Candidate updated!');
    }

    public function destroy($id)
    {
        Candidate::destroy($id);

        return redirect('candidates')->with('flash_message', 'Candidate deleted!');
    }

    /// API ////
    public function getDataCandidateAPI()
    {
        $data = [];
        $data['politicalParties'] = Political_party::get();
        $data['years'] = Year::get();
        $data['provinces'] = Province::get();
        $data['districts'] = District::get();
        $data['sub_districts'] = Sub_district::get();
        $data['electorates'] = Electorate::get();
        $data['type_candidates'] = Type_candidate::get();

        return $data;
    }

    public function excel_add_candidates(Request $request)
    {
        // ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'year_id' => 'required',
            'type_candidates' => 'required',
        ]);

        // รับค่า year_id และ type_candidates
        $year_id = $request->input('year_id');
        $type_candidates = $request->input('type_candidates');

        // รับไฟล์และเก็บใน storage
        $file = $request->file('file');
        $path = $file->store('uploads');  // หรือกำหนดตำแหน่งการเก็บตามต้องการ

        // อ่านข้อมูลจากไฟล์ Excel
        $data = Excel::toArray([], $file);

        // ข้ามแถวแรก (header) โดยใช้ array_slice()
        $rows = array_slice($data[0], 1);

        $old_P = "" ;
        $old_A = "" ;

        foreach ($rows as &$row) {

            // จังหวัด
            $province = $row[0] ;
            // อำเภอ
            $district = $row[1];
            // เขตเลือกตั้งที่
            $name_electorate = $row[2];
            // หมายเลข
            $number_candidates = $row[3];
            // ชื่อ-สกุลผู้สมัคร
            $name_candidates = $row[4];
            // ลิงก์รูปภาพผู้สมัคร
            $img_url = $row[5];
            // พรรคการเมือง
            $political_partie = $row[6];

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

            $data_Electorate = Electorate::where('name_electorate' , $name_electorate)
                ->where('province_id' , $data_P->id)
                ->where('district_id' , $data_A->id)
                ->first();

            $data_Political_party = Political_party::where('name' , $political_partie)->first();

            $political_partie_id = "";
            if( !empty($data_Political_party->id) ){
                $political_partie_id = $data_Political_party->id;
            }

            $data_add = [];
            $data_add['name'] = $name_candidates ;
            $data_add['img_url'] = $img_url ;
            $data_add['number'] = $number_candidates ;
            $data_add['province_id'] = $data_P->id ;
            $data_add['district_id'] = $data_A->id ;
            $data_add['electorate_id'] = $data_Electorate->id ;
            $data_add['political_partie_id'] = $political_partie_id ;
            $data_add['year_id'] = $year_id ;
            $data_add['type'] = $type_candidates ;
            Candidate::create($data_add);
        }

        return "SUCCESS" ;

    }

    function get_data_years(){
        $data['years'] = Year::get();
        return $data;
    }
}
