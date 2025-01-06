<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Electorate;
use Illuminate\Http\Request;

class ElectoratesController extends Controller
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
            $electorates = Electorate::where('name_electorate', 'LIKE', "%$keyword%")
                ->orWhere('province_id', 'LIKE', "%$keyword%")
                ->orWhere('district_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $electorates = Electorate::latest()->paginate($perPage);
        }

        return view('electorates.index', compact('electorates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('electorates.create');
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
        
        Electorate::create($requestData);

        return redirect('electorates')->with('flash_message', 'Electorate added!');
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
        $electorate = Electorate::findOrFail($id);

        return view('electorates.show', compact('electorate'));
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
        $electorate = Electorate::findOrFail($id);

        return view('electorates.edit', compact('electorate'));
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
        
        $electorate = Electorate::findOrFail($id);
        $electorate->update($requestData);

        return redirect('electorates')->with('flash_message', 'Electorate updated!');
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
        Electorate::destroy($id);

        return redirect('electorates')->with('flash_message', 'Electorate deleted!');
    }
}
