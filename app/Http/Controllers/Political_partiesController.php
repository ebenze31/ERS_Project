<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Political_party;
use Illuminate\Http\Request;

class Political_partiesController extends Controller
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
            $political_parties = Political_party::where('name', 'LIKE', "%$keyword%")
                ->orWhere('logo', 'LIKE', "%$keyword%")
                ->orWhere('color', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $political_parties = Political_party::latest()->paginate($perPage);
        }

        return view('political_parties.index', compact('political_parties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('political_parties.create');
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

        Political_party::create($requestData);

        return redirect('political_parties')->with('flash_message', 'Political_party added!');
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
        $political_party = Political_party::findOrFail($id);

        return view('political_parties.show', compact('political_party'));
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
        $political_party = Political_party::findOrFail($id);

        return view('political_parties.edit', compact('political_party'));
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

        $political_party = Political_party::findOrFail($id);
        $political_party->update($requestData);

        return redirect('political_parties')->with('flash_message', 'Political_party updated!');
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
        Political_party::destroy($id);

        return redirect('political_parties')->with('flash_message', 'Political_party deleted!');
    }
}
