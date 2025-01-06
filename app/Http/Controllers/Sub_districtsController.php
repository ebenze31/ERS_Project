<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Sub_district;
use Illuminate\Http\Request;

class Sub_districtsController extends Controller
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
            $sub_districts = Sub_district::where('name_sub_districts', 'LIKE', "%$keyword%")
                ->orWhere('province_id', 'LIKE', "%$keyword%")
                ->orWhere('district_id', 'LIKE', "%$keyword%")
                ->orWhere('electorate_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $sub_districts = Sub_district::latest()->paginate($perPage);
        }

        return view('sub_districts.index', compact('sub_districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('sub_districts.create');
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
        
        Sub_district::create($requestData);

        return redirect('sub_districts')->with('flash_message', 'Sub_district added!');
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
        $sub_district = Sub_district::findOrFail($id);

        return view('sub_districts.show', compact('sub_district'));
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
        $sub_district = Sub_district::findOrFail($id);

        return view('sub_districts.edit', compact('sub_district'));
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
        
        $sub_district = Sub_district::findOrFail($id);
        $sub_district->update($requestData);

        return redirect('sub_districts')->with('flash_message', 'Sub_district updated!');
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
        Sub_district::destroy($id);

        return redirect('sub_districts')->with('flash_message', 'Sub_district deleted!');
    }
}
