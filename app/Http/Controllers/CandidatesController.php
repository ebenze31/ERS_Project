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

        return view('candidates.index', compact('candidates'));
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
}
