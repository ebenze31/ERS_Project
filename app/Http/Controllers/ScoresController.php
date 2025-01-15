<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        return view('scores.add_score', compact('data_user'));
    }
}
