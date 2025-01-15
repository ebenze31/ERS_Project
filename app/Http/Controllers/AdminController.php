<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Province;

class AdminController extends Controller
{
    public function index()
    {
        $data_admin = Auth::user();
        $user_province = Auth::user()->province ;
        $data_provinces = Province::where('name_province' , $user_province)->first();
        $province_id = $data_provinces->id ;
        
        return view('admin.dashboard', compact('data_admin','province_id'));
    }

    function set_system(){
        return view('admin.set_system');
    }
}
