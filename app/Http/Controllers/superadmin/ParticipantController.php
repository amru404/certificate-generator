<?php

namespace App\Http\Controllers\superadmin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Participant;
use App\Imports\ParticipantsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateExport;



class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Participant::with('event')->where('id', 1)->first();

        return response()->json($user);
    }

    public function import_create(string $id){
        // dd($id);
        $eventID = $id;
        return view('superadmin.participant.add', compact('eventID')); 
    }


    public function import_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,csv',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'File tidak valid. Pastikan file berformat .xlsx atau .csv');
        }
    
        $eventId = $request->event_id;
    
        try {
            Excel::import(new ParticipantsImport($eventId), $request->file('file'));
        } catch (\Exception $e) {
            // \Log::error('Import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Format file tidak sesuai: ' . $e->getMessage());
        }
        return redirect()->to(url("/superadmin/event/show/{$eventId}"))
            ->with('success', 'Participants imported successfully.');
    }
    

    public function export_template()
    {
        return Excel::download(new TemplateExport, 'template.xlsx');
    }

    public function destroy_all(string $id){
        $participant = Participant::where('event_id', $id)->delete();
        return redirect()->to(url("/superadmin/event/show/{$id}"))->with('success', 'Delete All Paritcipants Successfully');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $participant = Participant::findOrFail($id);

        return view('superadmin.participant.edit', compact('participant'));
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
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|numeric',
        ]);
    
        $participant = Participant::findOrFail($id);
        $eventId = $participant->event_id;

        $participant->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->to(url("/superadmin/event/show/{$eventId}"))->with('success', 'Edit Participant Success.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $participant = Participant::findOrFail($id);
        $eventId = $participant->event_id;
        $participant->delete();
        return redirect()->to(url("/superadmin/event/show/{$eventId}"))->with('success', 'Delte Participant Success.');

    }
}
