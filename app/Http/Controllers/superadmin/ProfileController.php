<?php

namespace App\Http\Controllers\superadmin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; 

class ProfileController extends Controller
{
    public function index()
    {
        return view('superadmin.profile.index', [
            'user' => auth()->user(),
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $path = $request->file('photo')->store('user', 'public');

        $user = auth()->user();
        $user->profile_photo = $path;
        $user->save();

        return response()->json(['message' => 'Photo uploaded successfully!', 'path' => $path]);
    }

    public function deletePhoto()
    {
        $user = auth()->user();

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = null;
            $user->save();
        }

        return response()->json(['message' => 'Photo deleted successfully!']);
    }
}
