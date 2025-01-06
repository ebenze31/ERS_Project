<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Type_candidate;
use Illuminate\Http\Request;

class Type_candidatesController extends Controller
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
            $type_candidates = Type_candidate::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $type_candidates = Type_candidate::latest()->paginate($perPage);
        }

        return view('type_candidates.index', compact('type_candidates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('type_candidates.create');
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
        
        Type_candidate::create($requestData);

        return redirect('type_candidates')->with('flash_message', 'Type_candidate added!');
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
        $type_candidate = Type_candidate::findOrFail($id);

        return view('type_candidates.show', compact('type_candidate'));
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
        $type_candidate = Type_candidate::findOrFail($id);

        return view('type_candidates.edit', compact('type_candidate'));
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
        
        $type_candidate = Type_candidate::findOrFail($id);
        $type_candidate->update($requestData);

        return redirect('type_candidates')->with('flash_message', 'Type_candidate updated!');
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
        Type_candidate::destroy($id);

        return redirect('type_candidates')->with('flash_message', 'Type_candidate deleted!');
    }
}
