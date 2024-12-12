<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Mtownsend\RemoveBg\RemoveBg;



class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_event = Event::with('user')->where('user_id', Auth::user()->id)->get();
        return view('admin.event.index', compact('get_event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.event.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_event' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'ttd' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|string|max:255',
        ]);
    
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoImage = $request->file('logo');
            $logoImagePath = $logoImage->getPathname();
            
            $outputLogoPath = storage_path('app/public/logos/removed_' . $logoImage->getClientOriginalName());

            $removeBg = new RemoveBg(config('removebg.api_key'));
            $removeBg->file($logoImagePath)->save($outputLogoPath);
            
            $logoPath = '/logos/removed_' . $logoImage->getClientOriginalName();
        }

        
        $ttdPath = null;
        if ($request->hasFile('ttd')) {
            $ttdImage = $request->file('ttd');
            $ttdImagePath = $ttdImage->getPathname();

            $outputTtdPath = storage_path('app/public/ttd/removed_' . $ttdImage->getClientOriginalName());
        
            $removeBg = new RemoveBg(config('removebg.api_key')); 
            $removeBg->file($ttdImagePath)->save($outputTtdPath);
        
            $ttdPath = '/ttd/removed_' . $ttdImage->getClientOriginalName();
        }
        
    
        
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
    
        return redirect()->route('admin.event');
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

        return view('admin.event.show', compact('detail_event','participant'));
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

        return view('admin.event.edit',compact('event'));
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
    
        // Cari data event berdasarkan ID
        $event = Event::findOrFail($id);
    
        // Mengolah logo
        $logoPath = $event->logo;
        if ($request->hasFile('logo')) {
            if ($event->logo) {
                // Hapus logo lama
                Storage::disk('public')->delete($event->logo);
            }
    
            // Proses logo baru dengan menghapus background
            $logoImage = $request->file('logo');
            $logoImagePath = $logoImage->getPathname();
            $outputLogoPath = storage_path('app/public/logos/removed_' . $logoImage->getClientOriginalName());
            
            $removeBg = new RemoveBg(config('removebg.api_key'));
            $removeBg->file($logoImagePath)->save($outputLogoPath);
    
            $logoPath = '/logos/removed_' . $logoImage->getClientOriginalName();
        }
    
        // Mengolah ttd
        $ttdPath = $event->ttd;
        if ($request->hasFile('ttd')) {
            if ($event->ttd) {
                // Hapus ttd lama
                Storage::disk('public')->delete($event->ttd);
            }
    
            // Proses ttd baru dengan menghapus background
            $ttdImage = $request->file('ttd');
            $ttdImagePath = $ttdImage->getPathname();
            $outputTtdPath = storage_path('app/public/ttd/removed_' . $ttdImage->getClientOriginalName());
            
            $removeBg = new RemoveBg(config('removebg.api_key'));
            $removeBg->file($ttdImagePath)->save($outputTtdPath);
    
            $ttdPath = '/ttd/removed_' . $ttdImage->getClientOriginalName();
        }
    
        // Update data event
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
    
        // Redirect ke halaman event dengan pesan sukses
        return redirect()->route('admin.event')->with('success', 'Event berhasil diperbarui!');
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
        return redirect()->route('admin.event');

    }
}