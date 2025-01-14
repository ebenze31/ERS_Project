<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $data_admin = Auth::user();
        return view('admin.dashboard', compact('data_admin'));
    }
}
