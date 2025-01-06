<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Polling_unit;
use Illuminate\Http\Request;

class Polling_unitsController extends Controller
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
            $polling_units = Polling_unit::where('name_polling_unit', 'LIKE', "%$keyword%")
                ->orWhere('province_id', 'LIKE', "%$keyword%")
                ->orWhere('district_id', 'LIKE', "%$keyword%")
                ->orWhere('electorate_id', 'LIKE', "%$keyword%")
                ->orWhere('sub_district_id', 'LIKE', "%$keyword%")
                ->orWhere('eligible_voters', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $polling_units = Polling_unit::latest()->paginate($perPage);
        }

        return view('polling_units.index', compact('polling_units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('polling_units.create');
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
        
        Polling_unit::create($requestData);

        return redirect('polling_units')->with('flash_message', 'Polling_unit added!');
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
        $polling_unit = Polling_unit::findOrFail($id);

        return view('polling_units.show', compact('polling_unit'));
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
        $polling_unit = Polling_unit::findOrFail($id);

        return view('polling_units.edit', compact('polling_unit'));
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
        
        $polling_unit = Polling_unit::findOrFail($id);
        $polling_unit->update($requestData);

        return redirect('polling_units')->with('flash_message', 'Polling_unit updated!');
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
        Polling_unit::destroy($id);

        return redirect('polling_units')->with('flash_message', 'Polling_unit deleted!');
    }
}
