<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvincesController extends Controller
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
            $provinces = Province::where('name_province', 'LIKE', "%$keyword%")
                ->orWhere('logo', 'LIKE', "%$keyword%")
                ->orWhere('banner', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $provinces = Province::latest()->paginate($perPage);
        }

        return view('provinces.index', compact('provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('provinces.create');
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
                if ($request->hasFile('logo')) {
            $requestData['logo'] = $request->file('logo')
                ->store('uploads', 'public');
        }
        if ($request->hasFile('banner')) {
            $requestData['banner'] = $request->file('banner')
                ->store('uploads', 'public');
        }

        Province::create($requestData);

        return redirect('provinces')->with('flash_message', 'Province added!');
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
        $province = Province::findOrFail($id);

        return view('provinces.show', compact('province'));
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
        $province = Province::findOrFail($id);

        return view('provinces.edit', compact('province'));
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
                if ($request->hasFile('logo')) {
            $requestData['logo'] = $request->file('logo')
                ->store('uploads', 'public');
        }
        if ($request->hasFile('banner')) {
            $requestData['banner'] = $request->file('banner')
                ->store('uploads', 'public');
        }

        $province = Province::findOrFail($id);
        $province->update($requestData);

        return redirect('provinces')->with('flash_message', 'Province updated!');
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
        Province::destroy($id);

        return redirect('provinces')->with('flash_message', 'Province deleted!');
    }
}
