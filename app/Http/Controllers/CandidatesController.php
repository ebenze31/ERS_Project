<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidatesController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('candidates.create');
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
                if ($request->hasFile('img')) {
            $requestData['img'] = $request->file('img')
                ->store('uploads', 'public');
        }

        Candidate::create($requestData);

        return redirect('candidates')->with('flash_message', 'Candidate added!');
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
        $candidate = Candidate::findOrFail($id);

        return view('candidates.show', compact('candidate'));
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
        $candidate = Candidate::findOrFail($id);

        return view('candidates.edit', compact('candidate'));
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
                if ($request->hasFile('img')) {
            $requestData['img'] = $request->file('img')
                ->store('uploads', 'public');
        }

        $candidate = Candidate::findOrFail($id);
        $candidate->update($requestData);

        return redirect('candidates')->with('flash_message', 'Candidate updated!');
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
        Candidate::destroy($id);

        return redirect('candidates')->with('flash_message', 'Candidate deleted!');
    }
}
