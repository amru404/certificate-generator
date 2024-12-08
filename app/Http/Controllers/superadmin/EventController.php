<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    $get_event = Event::with('user')->get();

        // return response()->json($get_event);
        return view('superadmin.event.index', compact('get_event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $event = new Event(); 
        return view('superadmin.event.add', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all()); 
        
        $this->validate($request, [
            'nama_event' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal' => 'required|date',
            'ttd' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|string|max:255',
        ]);
        



    $logoPath = $request->hasFile('logo')
    ? $request->file('logo')->store('logos', 'public')
    : null;


$ttdPath = $request->hasFile('ttd')
    ? $request->file('ttd')->store('ttd', 'public')
    : null;

        Event::create([
            'nama_event' => $request->nama_event,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'deskripsi' => $request->deskripsi,
            'logo' => $logoPath,
            'tanggal' => $request->tanggal,
            'ttd' => $ttdPath,
            'user_id' => $request->user_id,
        ]);
        
        return redirect()->route('superadmin.event');
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail_event = Event::with('User')->findOrFail($id);
        
        $participant = Participant::where('event_id', $id)->get();

        return view('superadmin.event.show', compact('detail_event','participant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return view('superadmin.event.edit',compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama_event' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal' => 'required|date',
            'ttd' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|string|max:255',
        ]);
    
        $event = Event::findOrFail($id);
    
        if ($request->hasFile('logo')) {
            if ($event->logo) {
                Storage::disk('public')->delete($event->logo);
            }
            $file = $request->file('logo');
            $logoPath = $file->store('logos', 'public');
        } else {
            $logoPath = $event->logo;
        }

        if ($request->hasFile('ttd')) {
            if ($event->ttd) {
                Storage::disk('public')->delete($event->ttd); 
            }
            $ttdPath = $request->file('ttd')->store('ttd', 'public');
        } else {
            $ttdPath = $event->ttd; 
        }
    
        $event->update([
            'nama_event' => $request->nama_event,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'deskripsi' => $request->deskripsi,
            'logo' => $logoPath,
            'tanggal' => $request->tanggal,
            'ttd' => $ttdPath,
            'user_id' => $request->user_id,
        ]);
    
        return redirect()->route('superadmin.event')->with('success', 'Event updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_event = Event::findOrFail($id);
        $delete_event->delete();
        return redirect()->route('superadmin.event');

    }
}
