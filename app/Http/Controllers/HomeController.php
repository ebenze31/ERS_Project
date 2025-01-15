<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        $role = Auth::user()->role;

        if ($role === 'dev-admin' || $role === 'admin') {
            return redirect('/for_admin');
        } elseif ($role === 'officer') {
            $name_user = Auth::user()->name;
            if($name_user == "กรุณาเพิ่มชื่อของคุณ"){
                return redirect('/after_login');
            }else{
                return redirect('/add_score');
            }
        } else {
            return redirect('/home');
        }
    }
}
