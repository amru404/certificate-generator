<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        // Validate request
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
    
        
        $logoImage = $request->file('logo');
        if ($logoImage && $logoImage->getSize() > 2048 * 1024) {
            return redirect()->back()->with('error', 'Logo Harus Kurang Dari 2MB');
        }
    
        
        $ttdImage = $request->file('ttd');
        if ($ttdImage && $ttdImage->getSize() > 2048 * 1024) {
            return redirect()->back()->with('error', 'Tanda tangan Harus Kurang Dari 2MB');
        }
    
    
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoImage = $request->file('logo');
            $logoImagePath = $logoImage->getPathname();
            
            $outputLogoPath = storage_path('app/public/logos/removed_' . $logoImage->getClientOriginalName());
    
            try {
                $removeBg = new RemoveBg(config('removebg.api_key'));
                $removeBg->file($logoImagePath)->save($outputLogoPath);
                $logoPath = '/logos/removed_' . $logoImage->getClientOriginalName();
            } catch (\Exception $e) {
                \Log::error('RemoveBg error for logo' . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal remove background logo');
            }
        }
        
        $ttdPath = null;
        if ($request->hasFile('ttd')) {
            $ttdImage = $request->file('ttd');
            $ttdImagePath = $ttdImage->getPathname();
    
            $outputTtdPath = storage_path('app/public/ttd/removed_' . $ttdImage->getClientOriginalName());
    
            try {
                $removeBg = new RemoveBg(config('removebg.api_key'));
                $removeBg->file($ttdImagePath)->save($outputTtdPath);
                $ttdPath = '/ttd/removed_' . $ttdImage->getClientOriginalName();
            } catch (\Exception $e) {
                \Log::error('RemoveBg error for ttd' . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal remove background tanda tangan:');
            }
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
    
        return redirect()->route('superadmin.event')->with('success', 'Event created successfully!');
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
            'tanggal' => 'required|date',
            'ttd' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|string|max:255',
        ]);

        $logoImage = $request->file('logo');
        if ($logoImage && $logoImage->getSize() > 2048 * 1024) {
            return redirect()->back()->with('error', 'Logo Harus Kurang Dari 2MB');
        }

        $ttdImage = $request->file('ttd');
        if ($ttdImage && $ttdImage->getSize() > 2048 * 1024) {
            return redirect()->back()->with('error', 'Tanda tangan Harus Kurang Dari 2MB');
        }

        $event = Event::findOrFail($id);

        $logoPath = $event->logo;
        if ($request->hasFile('logo')) {
            if ($event->logo) {
                Storage::disk('public')->delete($event->logo);
            }

            $logoImage = $request->file('logo');
            $logoImagePath = $logoImage->getPathname();
            $outputLogoPath = storage_path('app/public/logos/removed_' . $logoImage->getClientOriginalName());

            try {
                $removeBg = new RemoveBg(config('removebg.api_key'));
                $removeBg->file($logoImagePath)->save($outputLogoPath);
                $logoPath = '/logos/removed_' . $logoImage->getClientOriginalName();
            } catch (\Exception $e) {
                \Log::error('RemoveBg error for logo ');
                return redirect()->back()->with('error', 'Gagal remove background logo');
            }
        }

        $ttdPath = $event->ttd;
        if ($request->hasFile('ttd')) {
            if ($event->ttd) {
                Storage::disk('public')->delete($event->ttd);
            }

            $ttdImage = $request->file('ttd');
            $ttdImagePath = $ttdImage->getPathname();
            $outputTtdPath = storage_path('app/public/ttd/removed_' . $ttdImage->getClientOriginalName());

            try {
                $removeBg = new RemoveBg(config('removebg.api_key'));
                $removeBg->file($ttdImagePath)->save($outputTtdPath);
                $ttdPath = '/ttd/removed_' . $ttdImage->getClientOriginalName();
            } catch (\Exception $e) {
                \Log::error('RemoveBg error for ttd');
                return redirect()->back()->with('error', 'Gagal remove background tanda tangan');
            }
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

        return redirect()->route('superadmin.event')->with('success', 'Event berhasil diperbarui!');
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
        return redirect()->route('superadmin.event')->with('success','Delete Event Successfully');

    }

    

}