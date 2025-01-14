<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Score;
use Illuminate\Http\Request;
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
        ->join('candidates', 'scores.candidate_id', '=', 'candidates.id')
        ->join('political_parties', 'candidates.political_partie_id', '=', 'political_parties.id')
        ->select(
            'scores.score',
            'candidates.*',
            'political_parties.name as political_party_name',
            'political_parties.logo as political_party_logo',
        )
        ->get();


        return view('scores.admin_report_score',compact('scores'));
    }
}
