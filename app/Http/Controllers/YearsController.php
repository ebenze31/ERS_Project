<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Type_candidate;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // $request->validate([
        //     'round' => 'required|integer|min:1',
        //     'year' => 'required|integer|min:' . date('Y'), // ตรวจสอบว่า year เป็นปีปัจจุบันหรือมากกว่า
        //     'active' => 'required|string|max:255' ,
        // ], [
        //     'round.required' => 'กรุณากรอกข้อมูลรอบการเลือกตั้ง',
        //     'round.integer' => 'รอบการเลือกตั้งต้องเป็นตัวเลข',
        //     'round.min' => 'รอบการเลือกตั้งต้องมีค่ามากกว่า 0',

        //     'year.required' => 'กรุณากรอกปีการเลือกตั้ง',
        //     'year.integer' => 'ปีการเลือกตั้งต้องเป็นตัวเลข',
        //     'year.min' => 'ปีการเลือกตั้งต้องเป็นปีปัจจุบันหรืออนาคต',

        //     'active.required' => 'กรุณาเลือกประเภทผู้สมัครอย่างน้อย 1 อย่าง',
        // ]);

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
        $userProvince = Auth::user()->province;
        $years = Year::where('province',$userProvince)->get();
        $type_candidates = Type_candidate::get();
        return view('years.election_setting',compact('years','type_candidates','userProvince'));
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

    public function create_new_yearAPI(Request $request)
    {
        // ตรวจสอบข้อมูลซ้ำ
        $existingYear = Year::where('year', $request->year)
            ->where('round', $request->round)
            ->where('province', $request->province)
            ->first();

        if ($existingYear) {
            return response()->json([
                'error' => 'ข้อมูลนี้มีอยู่แล้วในระบบ'
            ], 400); // ส่งกลับ error message
        }

        // ถ้าไม่พบข้อมูลซ้ำ, ให้ทำการบันทึกข้อมูล
        $yearData = new Year();
        $yearData->year = $request->year;
        $yearData->round = $request->round;
        $yearData->province = $request->province;
        $yearData->save();

        // ดึงข้อมูลปีที่อัพเดต
        $year_after_update = Year::where('province',$request->userProvince)->get();

        return response()->json([
            'success' => 'บันทึกข้อมูลสำเร็จ!',
            'data' => $year_after_update
        ], 200);
    }

    public function update_new_yearAPI(Request $request)
    {
        $year = Year::find($request->year_id);
        if (!$year) {
            return response()->json(['success' => false, 'message' => 'ไม่พบไอดีของข้อมูลใน years']);
        }

        // ถ้าต้องการเปลี่ยน status
        if ($request->has('status')) {
            $province = $year->province; // province ของ ID ที่ถูกเลือก
            $status = $request->status;

            // ถ้า status เป็น 'Yes', จะตั้งค่าของปีที่เหลือเป็น null
            if ($status === 'Yes') {
                // หาปีอื่นๆ ที่มี province ตรงกัน
                $otherYearsWithSameProvince = Year::where('province', $province)
                    ->where('id', '!=', $year->id) // ยกเว้นปีที่ถูกเลือก
                    ->get();

                // เปลี่ยน status ของปีที่มี province ตรงกันเป็น null
                foreach ($otherYearsWithSameProvince as $otherYear) {
                    $otherYear->status = null;
                    $otherYear->save();
                }
            }

            // ตั้งค่า status ของปีที่เลือก
            $year->status = $status;
        }

        // ตรวจสอบว่า request มีค่าที่จะอัพเดตหรือไม่
        if ($request->has('active')) {
            $year->active = $request->active;
        }
        if ($request->has('show_parties')) {
            $year->show_parties = $request->show_parties;
        }


        // บันทึกการเปลี่ยนแปลง
        $year->save();

        // ดึงข้อมูลปีที่อัพเดต
        $year_after_update = Year::where('province',$request->userProvince)->get();

        return response()->json(['success' => true, 'data' => $year_after_update]);
    }


}
