<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Type_candidate;
use App\Models\Year;
use Illuminate\Http\Request;

class YearsController extends Controller
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
            $years = Year::where('year', 'LIKE', "%$keyword%")
                ->orWhere('round', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $years = Year::latest()->paginate($perPage);
        }

        return view('years.index', compact('years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $candidateTypes  = Type_candidate::get();
        return view('years.create',compact('candidateTypes'));
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
        // การตรวจสอบข้อมูลที่ผู้ใช้ส่งมา
        $request->validate([
            'round' => 'required|integer|min:1',
            'year' => 'required|integer|min:' . date('Y'), // ตรวจสอบว่า year เป็นปีปัจจุบันหรือมากกว่า
            'active' => 'required|string|max:255' ,
        ], [
            'round.required' => 'กรุณากรอกข้อมูลรอบการเลือกตั้ง',
            'round.integer' => 'รอบการเลือกตั้งต้องเป็นตัวเลข',
            'round.min' => 'รอบการเลือกตั้งต้องมีค่ามากกว่า 0',

            'year.required' => 'กรุณากรอกปีการเลือกตั้ง',
            'year.integer' => 'ปีการเลือกตั้งต้องเป็นตัวเลข',
            'year.min' => 'ปีการเลือกตั้งต้องเป็นปีปัจจุบันหรืออนาคต',

            'active.required' => 'กรุณาเลือกประเภทผู้สมัครอย่างน้อย 1 อย่าง',
        ]);

        // รับข้อมูลที่ผ่านการตรวจสอบแล้ว
        $requestData = $request->all();

        // บันทึกข้อมูลลงฐานข้อมูล
        Year::create($requestData);

        // Redirect กลับไปยังหน้า years พร้อมข้อความแจ้งเตือน
        return redirect('years')->with('flash_message', 'Year added!');
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
        $year = Year::findOrFail($id);

        return view('years.show', compact('year'));
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
        $year = Year::findOrFail($id);
        $candidateTypes  = Type_candidate::get();

        return view('years.edit', compact('year','candidateTypes'));
    }


    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $year = Year::findOrFail($id);
        $year->update($requestData);

        return redirect('years')->with('flash_message', 'Year updated!');
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
        Year::destroy($id);

        return redirect('years')->with('flash_message', 'Year deleted!');
    }

    public function election_setting()
    {
        $years = Year::get();
        return view('years.election_setting',compact('years'));
    }

    /// API ////
    public function getDataTypeCandidateAPI()
    {
        $data = [];
        $data['type_candidates'] = Type_candidate::get();

        return $data;
    }

    public function getData_Election_Setting_API(Request $request)
    {
        // รับข้อมูลทั้งหมดจาก request
        $requestData = $request->all();

        $data = Year::where('id',$requestData['selected_year'])->first();
        $data['type_candidates'] = Type_candidate::get();

        return $data;
    }

    public function activeStatusYearAPI(Request $request)
    {
        // รับข้อมูลทั้งหมดจาก request
        $requestData = $request->all();
        if ($requestData['status'] == "Yes") {
            $status = "Yes";
        }else{
            $status = null;
        }

        // ค้นหา record ด้วย ID
        $year = Year::findOrFail($requestData['year_id']);
        // อัปเดตข้อมูลในฐานข้อมูล
         // อัปเดตเฉพาะคอลัมน์ active
        $year->update([
                'status' => $status,
            ]);

        // ส่งผลลัพธ์กลับ
        return response()->json([
            'success' => true,
            'message' => 'อัปเดตสถานะสำเร็จ',
            'data' => $year
        ]);

    }


}
