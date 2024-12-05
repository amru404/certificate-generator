<?php

namespace App\Http\Controllers\superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class SettingController extends Controller
{
    public function index()
    {
        return view('layouts_dashboard.setting'); 
    }
}
