<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexVerification() {
        return view('check');
    }
    public function storeVerification(request $request) {
        $id = $request->id;
        $certificate = Certificate::where('id', $id)->first();

        // dd($certificate);
        if ($certificate == null) {
            return view('not_verified',compact('id'));
        }else {
            return view('verified',compact('certificate'));
        }

    }
}
