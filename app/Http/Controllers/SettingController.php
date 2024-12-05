<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('layouts_dashboard.setting',compact('user')); 
    }


    public function updateUser(request $request, string $id)
    {
    
        $user = User::findOrFail($id);
    
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'gender' => $request->gender,
            'country' => $request->country,
            'city' => $request->city,
            'post_code' => $request->post_code,
            'state' => $request->state,
        ]);

        return redirect()->route('setting')->with('success', 'Edit Profile successfully.');
    }
}
