<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Province;
use App\Models\Polling_unit;
use App\Models\Year;
use App\User;
use App\Models\Candidate;
use App\Models\District;
use App\Models\Electorate;

class ScoresController extends Controller
{

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $scores = Score::where('candidate_id', 'LIKE', "%$keyword%")
                ->orWhere('year_id', 'LIKE', "%$keyword%")
                ->orWhere('polling_unit_id', 'LIKE', "%$keyword%")
                ->orWhere('sub_district_id', 'LIKE', "%$keyword%")
                ->orWhere('electorate_id', 'LIKE', "%$keyword%")
                ->orWhere('district_id', 'LIKE', "%$keyword%")
                ->orWhere('province_id', 'LIKE', "%$keyword%")
                ->orWhere('score', 'LIKE', "%$keyword%")
                ->orWhere('round', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $scores = Score::latest()->paginate($perPage);
        }

        return view('scores.index', compact('scores'));
    }

    public function show_score($id){

        $data_provinces = Province::where('id' , $id)->first();
        return view('scores.show_score', compact('data_provinces'));
    }


    public function create()
    {
        return view('scores.create');
    }

    public function store(Request $request)
    {

        $requestData = $request->all();

        Score::create($requestData);

        return redirect('scores')->with('flash_message', 'Score added!');
    }


    public function show($id)
    {
        $score = Score::findOrFail($id);

        return view('scores.show', compact('score'));
    }

    public function edit($id)
    {
        $score = Score::findOrFail($id);

        return view('scores.edit', compact('score'));
    }


    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $score = Score::findOrFail($id);
        $score->update($requestData);

        return redirect('scores')->with('flash_message', 'Score updated!');
    }

    public function destroy($id)
    {
        Score::destroy($id);

        return redirect('scores')->with('flash_message', 'Score deleted!');
    }

    public function admin_report_score()
    {
        $scores = DB::table('scores')
        ->leftjoin('candidates', 'scores.candidate_id', '=', 'candidates.id')
        ->leftjoin('political_parties', 'candidates.political_partie_id', '=', 'political_parties.id')
        ->select(
            'scores.score',
            'candidates.*',
            'political_parties.name as political_party_name',
            'political_parties.logo as political_party_logo',
        )
        ->get();

        return view('scores.admin_report_score',compact('scores'));
    }

    public function admin_vote_score()
    {

        $data_user = Auth::user();
        $province = $data_user->province ;

        $data_Year = Year::where('status' , "Yes")->where('province' , $province)->first();

        // echo "<pre>";
        // print_r($polling_units);
        // echo "<pre>";

        return view('scores.admin_vote_score', compact('province','data_Year'));

    }

    public function admin_vote_score_view($id)
    {
        $polling_unit_id = $id;
        $data_user = Auth::user();
        $user_id = $data_user->id ;
        $province = $data_user->province ;

        $data_polling_units = DB::table('polling_units')
        ->leftjoin('provinces', 'polling_units.province_id', '=', 'provinces.id')
        ->leftjoin('districts', 'polling_units.district_id', '=', 'districts.id')
        ->leftjoin('electorates', 'polling_units.electorate_id', '=', 'electorates.id')
        ->leftjoin('sub_districts', 'polling_units.sub_district_id', '=', 'sub_districts.id')
        ->leftjoin('users', 'polling_units.user_id', '=', 'users.id')
        ->where('provinces.name_province', '=' ,$province)
        ->where('polling_units.id', '=' ,$polling_unit_id)
        ->select(
                'polling_units.*',
                'provinces.name_province as name_province',
                'districts.name_district as name_district',
                'electorates.name_electorate as name_electorate',
                'sub_districts.name_sub_districts as name_sub_districts',
                'users.name as name_user'
            )
        ->first();

        return view('scores.admin_vote_score_view',compact('polling_unit_id','data_polling_units'));

    }

    public function admin_vote_scoreAPI(Request $request)
    {
        $requestData = $request->all();
        // $polling_units = Polling_unit::get();
        $data = [];
        $data['polling_units'] = DB::table('polling_units')
            ->leftjoin('provinces', 'polling_units.province_id', '=', 'provinces.id')
            ->leftjoin('districts', 'polling_units.district_id', '=', 'districts.id')
            ->leftjoin('electorates', 'polling_units.electorate_id', '=', 'electorates.id')
            ->leftjoin('sub_districts', 'polling_units.sub_district_id', '=', 'sub_districts.id')
            ->leftjoin('users', 'polling_units.user_id', '=', 'users.id')
            ->where('provinces.name_province', '=' ,$requestData['userProvince'])
            ->select(
                    'polling_units.*',
                    'provinces.name_province as name_province',
                    'districts.name_district as name_district',
                    'electorates.name_electorate as name_electorate',
                    'sub_districts.name_sub_districts as name_sub_districts',
                    'users.name as name_user',
                    'users.phone_1 as phone_1_user',
                    'users.phone_2 as phone_2_user',
                )
            ->get();

        // ดึงข้อมูลปีที่ใช้สำหรับการคำนวณ
        $data_Year = Year::where('status', 'Yes')->where('province', $requestData['userProvince'])->first();

        // ตรวจสอบว่าพบข้อมูลปีหรือไม่
        if ($data_Year) {
            // Loop ผ่าน polling_units และเพิ่ม max_round
            foreach ($data['polling_units'] as $polling_unit) {
                // ดึง id ของ polling_unit
                $id = $polling_unit->id;

                // หา max_round ของ polling_unit นี้
                $max_round = Score::where('polling_unit_id', $id)
                    ->where('year_id', $data_Year->id)
                    ->selectRaw('MAX(CAST(round AS UNSIGNED)) as max_round')
                    ->value('max_round');

                // เพิ่ม max_round เข้าไปในข้อมูล polling_unit
                $polling_unit->max_round = $max_round; // ถ้าไม่มีค่า max_round ให้ตั้งเป็น 0
            }
        } else {
            // ถ้าไม่พบ $data_Year
            foreach ($data['polling_units'] as $polling_unit) {
                $polling_unit->max_round = 0; // ตั้งค่า default เป็น 0
            }
        }

        $data['count'] = count($data['polling_units']);

        // echo "<pre>";
        // print_r($polling_units);
        // echo "<pre>";

        return $data;

    }

    // function check_count_score_unit($unit_id , $province){

    //     $data_Year = Year::where('status' , "Yes")->where('province' , $province)->first();

    //     $max_round = Score::where('polling_unit_id', $id)
    //         ->where('year_id', $data_Year->id)
    //         ->selectRaw('MAX(CAST(round AS UNSIGNED)) as max_round')
    //         ->value('max_round');

    //     return $max_round ;
    // }

    function add_score(){

        $data_user = Auth::user();
        $user_id = $data_user->id ;
        $province = $data_user->province ;

        $data_polling_units = DB::table('polling_units')
            ->leftjoin('provinces', 'polling_units.province_id', '=', 'provinces.id')
            ->leftjoin('districts', 'polling_units.district_id', '=', 'districts.id')
            ->leftjoin('electorates', 'polling_units.electorate_id', '=', 'electorates.id')
            ->leftjoin('sub_districts', 'polling_units.sub_district_id', '=', 'sub_districts.id')
            ->leftjoin('users', 'polling_units.user_id', '=', 'users.id')
            ->where('polling_units.user_id', '=' ,$user_id)
            ->select(
                    'polling_units.*',
                    'provinces.*',
                    'districts.*',
                    'electorates.*',
                    'sub_districts.*'
                )
            ->first();

        return view('scores.add_score', compact('data_user','data_polling_units'));
    }

    function send_score(Request $request)
    {
        $requestData = $request->all();
        // return $requestData;

        $user_id = $requestData[0]['user_id'] ;
        $data_user = User::where('id' , $user_id)->first();
        $user_province = $data_user->province;

        $data_Polling_unit = Polling_unit::where('user_id' , $user_id)->first();
        $data_Year = Year::where('status', "Yes")->where('province',$user_province)->first();

        // ดึงค่า round ที่มากที่สุดสำหรับ polling_unit_id
        $max_round = Score::where('polling_unit_id', $data_Polling_unit->id)
            ->where('year_id', $data_Year->id)
            ->selectRaw('MAX(CAST(round AS UNSIGNED)) as max_round')
            ->value('max_round');


        // ถ้าไม่มีข้อมูลใน Score ให้กำหนดค่าเริ่มต้นเป็น 0
        $update_round_score = $max_round ? $max_round + 1 : 1;


        // สร้าง Array เพื่อเก็บผลลัพธ์
        $results = [];
        // วนลูปผ่านข้อมูลที่ได้รับ
        foreach ($requestData as $data) {

            $candidate_id = explode("_id_",$data['id'])[1];

            $results[] = [
                'candidate_id' => $candidate_id,
                'score' => $data['value'],
                'polling_unit_id' => $data_Polling_unit->id,
                'sub_district_id' => $data_Polling_unit->sub_district_id,
                'electorate_id' => $data_Polling_unit->electorate_id,
                'district_id' => $data_Polling_unit->district_id,
                'province_id' => $data_Polling_unit->province_id,
                'round' => $update_round_score,
                'year_id' => $data_Year->id,
            ];

        }

        $check_data = [] ;
        // บันทึกข้อมูลลงใน Score
        foreach ($results as $result) {

            Score::create($result);

            $subquery = Score::selectRaw('polling_unit_id, MAX(CAST(round AS UNSIGNED)) as max_round')
                ->where('candidate_id', $result['candidate_id'])
                ->where('polling_unit_id', '!=', $result['polling_unit_id'])
                ->groupBy('polling_unit_id');

            $data_score_candidate = Score::joinSub($subquery, 'max_scores', function ($join) {
                $join->on('scores.polling_unit_id', '=', 'max_scores.polling_unit_id')
                     ->whereRaw('CAST(scores.round AS UNSIGNED) = max_scores.max_round');
            })
            ->where('scores.candidate_id', $result['candidate_id'])
            ->groupBy('scores.polling_unit_id', 'max_scores.max_round', 'scores.candidate_id') // เพิ่ม candidate_id ใน GROUP BY
            ->selectRaw('scores.polling_unit_id, max_scores.max_round, MAX(scores.score) as score, scores.candidate_id') // เพิ่ม candidate_id
            ->get();

            // คำนวณผลรวมของ score
            $total_score = $data_score_candidate->sum('score');

            // เก็บผลลัพธ์ใน array ตาม candidate_id
            $check_data[$result['candidate_id']] = $data_score_candidate;

            $new_sum_score = 0 ;
            if( !empty($total_score) ){
                $new_sum_score = intval($result['score']) + intval($total_score);
            }
            else{
                $new_sum_score = intval($result['score']);
            }

            // อัปเดตคะแนนของ Candidate
            Candidate::where('id', $result['candidate_id'])->update([
                'sum_score' => $new_sum_score,
            ]);
        }

        // return $check_data ;
        return "SUCCESS" ;

    }

    function get_record_score($user_id){

        $data_user = User::where('id' , $user_id)->first();
        $user_province = $data_user->province;

        $data_Polling_unit = Polling_unit::where('user_id' , $user_id)->first();
        $data_Year = Year::where('status', "Yes")->where('province',$user_province)->first();

        // $data_Score = Score::where('polling_unit_id', $data_Polling_unit->id)
        //     ->where('year_id', $data_Year->id)
        //     ->get();

        $data_Score = DB::table('scores')
            ->leftjoin('candidates', 'scores.candidate_id', '=', 'candidates.id')
            ->where('scores.polling_unit_id', $data_Polling_unit->id)
            ->where('scores.year_id', $data_Year->id)
            ->select(
                    'scores.*',
                    'candidates.name as name_candidate',
                    'candidates.number as number_candidate',
                )
            ->get();

        return $data_Score ;
    }

    function get_data_scores($district_id){

        $data_Score = DB::table('candidates')
            ->leftjoin('years', 'candidates.year_id', '=', 'years.id')
            ->leftjoin('provinces', 'candidates.province_id', '=', 'provinces.id')
            ->leftjoin('districts', 'candidates.district_id', '=', 'districts.id')
            ->leftjoin('electorates', 'candidates.electorate_id', '=', 'electorates.id')
            ->leftjoin('political_parties', 'candidates.political_partie_id', '=', 'political_parties.id')
            ->where('candidates.district_id', $district_id)
            ->where('years.status', "Yes")
            ->select(
                    'candidates.name as name_candidate',
                    'candidates.img as img_candidate',
                    'candidates.img_url as img_url_candidate',
                    'candidates.number as number_candidate',
                    'candidates.sum_score as sum_score',
                    'candidates.score_of_electorate as score_of_electorate',
                    'districts.name_district',
                    'electorates.name_electorate',
                    'electorates.score_of_electorate as check_electorate',
                    'years.show_parties',
                    'political_parties.name as name_political_partie',
                )
            ->get();

        return $data_Score ;

    }

    function get_data_districts($provinces_id){

        $data = DB::table('districts')
            ->leftJoin('candidates', 'districts.id', '=', 'candidates.district_id')
            ->where('districts.province_id', $provinces_id)
            ->groupBy('districts.name_district', 'districts.id')
            ->orderBy('candidates.id', 'asc')
            ->select(
                'districts.name_district',
                'districts.id as district_id'
            )
            ->get();


        return $data ;
    }

    function get_vote_score_historyAPI($polling_unit_id){

        $data = DB::table('scores')
            ->leftjoin('polling_units', 'scores.polling_unit_id', '=', 'polling_units.id')
            ->leftjoin('years', 'scores.year_id', '=', 'years.id')
            ->leftjoin('candidates', 'scores.candidate_id', '=', 'candidates.id')
            // ->leftjoin('users', 'scores.user_id', '=', 'users.id')
            ->where('scores.polling_unit_id', $polling_unit_id)
            ->where('years.status', "Yes")
            ->select(
                    'scores.*',
                    'polling_units.name_polling_unit as name_polling_unit',
                    'polling_units.eligible_voters as eligible_voters',
                    'candidates.number as number_candidate',
                    'candidates.name as name_candidate',
                    'candidates.name as name_candidate',
                )
            ->get();

        return $data ;

    }

    function clear_score($id , $user_id , $year_id){

        $data_user = User::where('id' , $user_id)->first();
        $province_id = $data_user->province_id ;

        if($id == "all"){
            Score::where('province_id', $province_id)->where('year_id' , $year_id)->delete();
            Candidate::where('province_id', $province_id)
                ->where('year_id' , $year_id)
                ->update([
                    'sum_score' => null,
                ]);
        }
        else{
            // Score::where('province_id', $province_id)
            //     ->where('year_id' , $year_id)
            //     ->where('polling_unit_id' , $id)
            //     ->delete();

            // $subquery = Score::selectRaw('polling_unit_id, MAX(CAST(round AS UNSIGNED)) as max_round')
            //     ->where('province_id', $province_id)
            //     ->where('year_id', $year_id)
            //     ->where('polling_unit_id', '!=', $id)
            //     ->groupBy('polling_unit_id');


            // $data_score_candidate = Score::joinSub($subquery, 'max_scores', function ($join) {
            //     $join->on('scores.polling_unit_id', '=', 'max_scores.polling_unit_id')
            //          ->whereRaw('CAST(scores.round AS UNSIGNED) = max_scores.max_round');
            // })
            // ->where('scores.candidate_id', $result['candidate_id'])
            // ->groupBy('scores.polling_unit_id', 'max_scores.max_round', 'scores.candidate_id') // เพิ่ม candidate_id ใน GROUP BY
            // ->selectRaw('scores.polling_unit_id, max_scores.max_round, MAX(scores.score) as score, scores.candidate_id') // เพิ่ม candidate_id
            // ->get();

            // // คำนวณผลรวมของ score
            // $total_score = $data_score_candidate->sum('score');

            // return $subquery ;

        }

        return "SUCCESS" ;

    }

    public function score_of_electorate()
    {

        $data_user = Auth::user();
        $province = $data_user->province ;

        $data_Year = Year::where('status' , "Yes")->where('province' , $province)->first();

        $data = DB::table('candidates')
            ->leftjoin('years', 'candidates.year_id', '=', 'years.id')
            ->leftjoin('electorates', 'candidates.electorate_id', '=', 'electorates.id')
            ->leftjoin('districts', 'candidates.district_id', '=', 'districts.id')
            ->where('years.status', "Yes")
            ->select(
                    'candidates.*',
                    'electorates.name_electorate',
                    'electorates.score_of_electorate as check_score_of_electorate',
                    'districts.name_district',
                )
            ->get();

        $groupedData = $data->groupBy('electorate_id');


        // echo "<pre>";
        // print_r($groupedData);
        // echo "<pre>";
        // exit();

        return view('scores.score_of_electorate', compact('province','data_Year','groupedData'));

    }

    public function send_score_of_electorate(Request $request)
    {
        // รับข้อมูล JSON ที่ส่งมาจาก client
        $scores = $request->json()->all();

        // ตัวแปรสำหรับเก็บข้อมูลที่แยกออกมา
        $electorates = []; // เก็บ electorateId
        $candidatesScores = []; // เก็บ candidateId และคะแนน

        // ลูปผ่านข้อมูลแต่ละ electorateId
        foreach ($scores as $electorateId => $candidates) {
            // เก็บ electorateId
            $electorates[] = $electorateId;

            // ลูปผ่านข้อมูลของแต่ละ candidate
            foreach ($candidates as $candidateId => $score) {
                // เก็บคะแนนของแต่ละ candidateId
                $candidatesScores[] = [
                    'electorateId' => $electorateId,
                    'candidateId' => $candidateId,
                    'score' => $score
                ];
            }
        }

        // electorates
        DB::table('electorates')->update(['score_of_electorate' => null]);

        foreach ($electorates as $electorateId) {
            DB::table('electorates')
                ->where('id', $electorateId)
                ->update(['score_of_electorate' => 'Yes']);
        }

        // candidates
        DB::table('candidates')->update(['score_of_electorate' => null]);

        foreach ($candidatesScores as $candidateScore) {
            DB::table('candidates')
                ->where('id', $candidateScore['candidateId'])
                ->update(['score_of_electorate' => $candidateScore['score']]);
        }

        // return response()->json([
        //     'status' => 'SUCCESS',
        //     'electorates' => $electorates, // ส่งข้อมูล electorateId
        //     'candidatesScores' => $candidatesScores // ส่งข้อมูล candidateId และคะแนน
        // ]);

        return "SUCCESS" ;
    }


}
