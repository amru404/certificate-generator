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
use Illuminate\Support\Facades\Http;


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


    //  STORE LAMA
    // public function store(Request $request)
    // {
    //     // Validate request
    //     $this->validate($request, [
    //         'nama_event' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'no_telp' => 'required|numeric',
    //         'deskripsi' => 'nullable|string',
    //         'tanggal' => 'required|date',
    //         'ttd' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'user_id' => 'required|string|max:255',
    //     ]);
    
        
    //     $logoImage = $request->file('logo');
    //     if ($logoImage && $logoImage->getSize() > 2048 * 1024) {
    //         return redirect()->back()->with('error', 'Logo Harus Kurang Dari 2MB');
    //     }
    
        
    //     $ttdImage = $request->file('ttd');
    //     if ($ttdImage && $ttdImage->getSize() > 2048 * 1024) {
    //         return redirect()->back()->with('error', 'Tanda tangan Harus Kurang Dari 2MB');
    //     }
    
    
    //     $logoPath = null;
    //     if ($request->hasFile('logo')) {
    //         $logoImage = $request->file('logo');
    //         $logoImagePath = $logoImage->getPathname();
            
    //         $outputLogoPath = storage_path('app/public/logos/removed_' . $logoImage->getClientOriginalName());
    
    //         try {
    //             $removeBg = new RemoveBg(config('removebg.api_key'));
    //             $removeBg->file($logoImagePath)->save($outputLogoPath);
    //             $logoPath = '/logos/removed_' . $logoImage->getClientOriginalName();
    //         } catch (\Exception $e) {
    //             \Log::error('RemoveBg error for logo' . $e->getMessage());
    //             return redirect()->back()->with('error', 'Gagal remove background logo');
    //         }
    //     }
        
    //     $ttdPath = null;
    //     if ($request->hasFile('ttd')) {
    //         $ttdImage = $request->file('ttd');
    //         $ttdImagePath = $ttdImage->getPathname();
    
    //         $outputTtdPath = storage_path('app/public/ttd/removed_' . $ttdImage->getClientOriginalName());
    
    //         try {
    //             $removeBg = new RemoveBg(config('removebg.api_key'));
    //             $removeBg->file($ttdImagePath)->save($outputTtdPath);
    //             $ttdPath = '/ttd/removed_' . $ttdImage->getClientOriginalName();
    //         } catch (\Exception $e) {
    //             \Log::error('RemoveBg error for ttd' . $e->getMessage());
    //             return redirect()->back()->with('error', 'Gagal remove background tanda tangan:');
    //         }
    //     }
    
        
    //     Event::create([
    //         'nama_event' => $request->nama_event,
    //         'email' => $request->email,
    //         'no_telp' => $request->no_telp,
    //         'deskripsi' => $request->deskripsi,
    //         'logo' => $logoPath,
    //         'tanggal' => $request->tanggal,
    //         'ttd' => $ttdPath,
    //         'user_id' => $request->user_id,
    //     ]);
    
    //     return redirect()->route('superadmin.event')->with('success', 'Event created successfully!');
    // }
    

    


    // STORE BARU
    public function store(Request $request)
    {

        // Validate request
        $this->validate($request, [
            'nama_event' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'nomor_certificate' => 'required|string|max:255',
            'logo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ttd.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cap.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|string|max:255',
        ]);
    
        $logoPaths = [];
        $ttdPaths = [];
        $capPaths = [];
    
        // max gambar
        $maxLogoCount = 6;
        $maxTtdCount = 2;
        $maxCapCount = 2;
    
        $maxSize = 2048; // Max per gambar (2MB)
    
        // Check total input gambar
        if ($request->hasFile('logo') && count($request->file('logo')) > $maxLogoCount) {
            return redirect()->back()->withInput()->with('error', 'Logo tidak boleh lebih dari 6.');
        }
    
        if ($request->hasFile('ttd') && count($request->file('ttd')) > $maxTtdCount) {
            return redirect()->back()->withInput()->with('error', 'Tanda tangan tidak boleh lebih dari 2.');
        }
    
        if ($request->hasFile('cap') && count($request->file('cap')) > $maxCapCount) {
            return redirect()->back()->withInput()->with('error', 'Cap tidak boleh lebih dari 2.');
        }
    
        // Check size upload, convert ke bytes
        foreach ($request->file('logo') as $logoImage) {
            if ($logoImage->getSize() > $maxSize * 1024) {
                return redirect()->back()->withInput()->with('error', 'Ukuran file logo tidak boleh lebih dari 2MB.');
            }
        }
    
        foreach ($request->file('ttd') as $ttdImage) {
            if ($ttdImage->getSize() > $maxSize * 1024) {
                return redirect()->back()->withInput()->with('error', 'Ukuran file tanda tangan tidak boleh lebih dari 2MB.');
            }
        }
    
        foreach ($request->file('cap') as $capImage) {
            if ($capImage->getSize() > $maxSize * 1024) {
                return redirect()->back()->withInput()->with('error', 'Ukuran file cap tidak boleh lebih dari 2MB.');
            }
        }
    
        // Function remove bg
        function removeBackground($imageFile, $saveDirectory, $prefix = 'removed_') {
            $imagePath = $imageFile->getPathname();
            $outputPath = storage_path('app/public/' . $saveDirectory . '/' . $prefix . $imageFile->getClientOriginalName());
    
            try {
                $removeBg = new RemoveBg(config('removebg.api_key'));
                $removeBg->file($imagePath)->save($outputPath);
                return $saveDirectory . '/' . $prefix . $imageFile->getClientOriginalName();
            } catch (\Exception $e) {
                \Log::error('RemoveBg error: ' . $e->getMessage());
                return null;
            }
        }
    
        // Handle multi-upload for logo (max 6)
        if ($request->hasFile('logo')) {
            foreach ($request->file('logo') as $index => $logoImage) {
                if ($index >= 6) break;
                $removedLogoPath = removeBackground($logoImage, 'logos', 'logo_' . time() . '_');
                if ($removedLogoPath) {
                    $logoPaths[] = $removedLogoPath;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupload logo.');
                }
            }
        }
    
        // Handle multi-upload for ttd (max 2)
        if ($request->hasFile('ttd')) {
            foreach ($request->file('ttd') as $index => $ttdImage) {
                if ($index >= 2) break;
                $removedTtdPath = removeBackground($ttdImage, 'ttd', 'ttd_' . time() . '_');
                if ($removedTtdPath) {
                    $ttdPaths[] = $removedTtdPath;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupload tanda tangan.');
                }
            }
        }
    
        // Handle multi-upload for cap (max 2)
        if ($request->hasFile('cap')) {
            foreach ($request->file('cap') as $index => $capImage) {
                if ($index >= 2) break;
                $removedCapPath = removeBackground($capImage, 'cap', 'cap_' . time() . '_');
                if ($removedCapPath) {
                    $capPaths[] = $removedCapPath;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupload cap.');
                }
            }
        }
    
        // Save event dan save img to json
        Event::create([
            'user_id' => $request->user_id,
            'nama_event' => $request->nama_event,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'nomor_certificate' => $request->nomor_certificate,
            'logo' => json_encode($logoPaths),
            'ttd' => json_encode($ttdPaths),
            'cap' => json_encode($capPaths),
        ]);
    
        return redirect()->route('superadmin.event')->with('success', 'Event created successfully!');
    }
    



    public function show($id)
    {
        $detail_event = Event::with('User')->findOrFail($id);
        $participant = Participant::where('event_id', $id)->get();
        $logo = json_decode($detail_event->logo);
        $ttd = json_decode($detail_event->ttd);
        $cap = json_decode($detail_event->cap);

        return view('superadmin.event.show', compact('detail_event','participant','logo','ttd','cap'));
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
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Validate request
        $this->validate($request, [
            'nama_event' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'logo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ttd.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cap.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|string|max:255',
            'nomor_certificate' => 'required|string|max:255',
        ]);

        $logoPaths = [];
        $ttdPaths = [];
        $capPaths = [];

        // max gambar
        $maxLogoCount = 6;
        $maxTtdCount = 2;
        $maxCapCount = 2;

        $maxSize = 2048; // Max per gambar (2MB)

        // Check total input gambar
        if ($request->hasFile('logo') && count($request->file('logo')) > $maxLogoCount) {
            return redirect()->back()->withInput()->with('error', 'Logo tidak boleh lebih dari 6.');
        }

        if ($request->hasFile('ttd') && count($request->file('ttd')) > $maxTtdCount) {
            return redirect()->back()->withInput()->with('error', 'Tanda tangan tidak boleh lebih dari 2.');
        }

        if ($request->hasFile('cap') && count($request->file('cap')) > $maxCapCount) {
            return redirect()->back()->withInput()->with('error', 'Cap tidak boleh lebih dari 2.');
        }

        // Check size upload, convert ke bytes
        if ($request->hasFile('logo') && is_array($request->file('logo'))) {
            foreach ($request->file('logo') as $logoImage) {
                if ($logoImage->getSize() > $maxSize * 1024) {
                    return redirect()->back()->withInput()->with('error', 'Ukuran file logo tidak boleh lebih dari 2MB.');
                }
            }
        }


        if ($request->hasFile('ttd') && is_array($request->file('ttd'))) {
            foreach ($request->file('ttd') as $ttdImage) {
                if ($ttdImage->getSize() > $maxSize * 1024) {
                    return redirect()->back()->withInput()->with('error', 'Ukuran file tanda tangan tidak boleh lebih dari 2MB.');
                }
            }
        }

        if ($request->hasFile('cap') && is_array($request->file('cap'))) {
            foreach ($request->file('cap') as $capImage) {
                if ($capImage->getSize() > $maxSize * 1024) {
                    return redirect()->back()->withInput()->with('error', 'Ukuran file cap tidak boleh lebih dari 2MB.');
                }
            }
        }


        // Function remove bg
        function removeBackground($imageFile, $saveDirectory, $prefix = 'removed_') {
            $imagePath = $imageFile->getPathname();
            $outputPath = storage_path('app/public/' . $saveDirectory . '/' . $prefix . $imageFile->getClientOriginalName());

            try {
                $removeBg = new RemoveBg(config('removebg.api_key'));
                $removeBg->file($imagePath)->save($outputPath);
                return $saveDirectory . '/' . $prefix . $imageFile->getClientOriginalName();
            } catch (\Exception $e) {
                \Log::error('RemoveBg error: ' . $e->getMessage());
                return null;
            }
        }

        // Handle multi-upload for logo (max 6)
        if ($request->hasFile('logo')) {
            foreach ($request->file('logo') as $index => $logoImage) {
                if ($index >= 6) break;
                $removedLogoPath = removeBackground($logoImage, 'logos', 'logo_' . time() . '_');
                if ($removedLogoPath) {
                    $logoPaths[] = $removedLogoPath;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupload logo.');
                }
            }
        } else {
            $logoPaths = json_decode($event->logo, true); // Keep the existing logo paths if no new logo is uploaded
        }

        // Handle multi-upload for ttd (max 2)
        if ($request->hasFile('ttd')) {
            foreach ($request->file('ttd') as $index => $ttdImage) {
                if ($index >= 2) break;
                $removedTtdPath = removeBackground($ttdImage, 'ttd', 'ttd_' . time() . '_');
                if ($removedTtdPath) {
                    $ttdPaths[] = $removedTtdPath;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupload tanda tangan.');
                }
            }
        } else {
            $ttdPaths = json_decode($event->ttd, true); // Keep the existing ttd paths if no new ttd is uploaded
        }

        // Handle multi-upload for cap (max 2)
        if ($request->hasFile('cap')) {
            foreach ($request->file('cap') as $index => $capImage) {
                if ($index >= 2) break;
                $removedCapPath = removeBackground($capImage, 'cap', 'cap_' . time() . '_');
                if ($removedCapPath) {
                    $capPaths[] = $removedCapPath;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupload cap.');
                }
            }
        } else {
            $capPaths = json_decode($event->cap, true); // Keep the existing cap paths if no new cap is uploaded
        }

        // Find the event by ID and update
        
        $event->update([
            'user_id' => $request->user_id,
            'nama_event' => $request->nama_event,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'nomor_certificate' => $request->nomor_certificate,
            'logo' => !empty($logoPaths) ? json_encode($logoPaths) : $event->logo,
            'ttd' => !empty($ttdPaths) ? json_encode($ttdPaths) : $event->ttd,
            'cap' => !empty($capPaths) ? json_encode($capPaths) : $event->cap,
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
        return redirect()->route('superadmin.event')->with('success','Delete Event Successfully');

    }

    


    public function checkApiStatus()
{
    $apiKey = 'UYsCn2aXufwwr4T2XmoqCQmT'; // Ganti dengan API key Remove.bg kamu

    // Lakukan request ke API Remove.bg untuk cek status akun
    $response = Http::withHeaders([
        'X-Api-Key' => $apiKey,
    ])->get('https://api.remove.bg/v1.0/account'); // Endpoint untuk cek status akun

    // Cek apakah status code response 200 (berhasil)
    if ($response->successful()) {
        return response()->json([
            'status' => 'success',
            'message' => 'API is active and working.',
            'data' => $response->json(), // Menampilkan informasi akun, seperti sisa kredit
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'API is not active or there was an issue.',
            'error' => $response->body(),
        ], 500);
    }
}

}