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

        // echo "<pre>";
        // print_r($polling_units);
        // echo "<pre>";

        return view('scores.admin_vote_score', compact('province'));

    }

    public function admin_vote_score_view($id)
    {

        return view('scores.admin_vote_score_view');

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
                    'provinces.*',
                    'districts.*',
                    'electorates.*',
                    'sub_districts.*',
                    'users.name as name_user'
                )
            ->get();

        $data['count'] = count($data['polling_units']);

        // echo "<pre>";
        // print_r($polling_units);
        // echo "<pre>";

        return $data;

    }

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
            ->max('round');

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

        // บันทึกข้อมูลลงใน Score
        foreach ($results as $result) {
            Score::create($result);

            // อัปเดตคะแนนของ Candidate
            Candidate::where('id', $result['candidate_id'])->update([
                'sum_score' => $result['score'],
            ]);
        }

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
                    'districts.name_district',
                    'electorates.name_electorate',
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
}
