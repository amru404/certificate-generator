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

    public function updateUser(Request $request, string $id)
    {
        // Validasi input
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Pengecualian untuk email yang sedang diperbarui
            'no_telp' => 'required|string',
            'gender' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'post_code' => 'required|string',
            'state' => 'required|string',
        ]);
    
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);
    
        // Update data user
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
    
        // Mengirimkan pesan sukses
        return redirect()->route('setting')->with('success', 'Edit Profile successfully.');
    }
    
    
}
