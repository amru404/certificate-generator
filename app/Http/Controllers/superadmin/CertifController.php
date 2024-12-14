<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Mail\CertificateMail;
use Illuminate\Support\Facades\Mail;
use App\Models\CertificateTemplate;
use App\Jobs\SendCertificateEmailJob;

class CertifController extends Controller
{
    public function index()
    {
        $templateCertif = CertificateTemplate::all();

    return view('superadmin.certificate.generate', compact('templateCertif'));

    }

    public function create(string $id)
    {
        $detail_event = Event::with('participants')->findOrFail($id);
        // $participant = Participant::where('event_id', $id)->get();
        $templates = CertificateTemplate::all(); 
        return view('superadmin.certificate.add', compact('templates','detail_event'));
    }

   
    public function store(Request $request, string $eventId)
    {
        $event = Event::findOrFail($eventId);
        $participants = $event->participants;

        if (!$participants || $participants->isEmpty()) {
            \Log::error("No participants found for event ID: {$eventId}");
            return redirect()->to(url("/superadmin/event/show/{$eventId}"))->with('error', 'No participants found for this event.');
        }

        foreach ($participants as $participant) {
            $existingCertificate = Certificate::where('event_id', $event->id)
                ->where('participant_id', $participant->id)
                ->first();

            if (!$existingCertificate) {
                $certificate = Certificate::create([
                    'id' => 'stf-' . Str::random(7),
                    'event_id' => $event->id,
                    'participant_id' => $participant->id,
                    'style' => 'style 1',
                    'certificate_templates_id' => $request->id,
                    'signature' => $event->ttd,
                ]);

                // Generate PDF setelah sertifikat dibuat
            $pdf = PDF::loadView('superadmin.certificate.certif_pdf', compact('certificate', 'participant', 'event'));
            $pdf->setPaper('A4', 'landscape');
            
            // Tentukan path penyimpanan file PDF
            $fileName = 'certificate-' . $certificate->id . '.pdf';
            $filePath = storage_path('app/public/certificates/' . $fileName);

            // Simpan PDF ke dalam storage
            $pdf->save($filePath);

            // Kirim email sertifikat
            SendCertificateEmailJob::dispatch($participant, $certificate, $filePath);
        } else {
            \Log::info("Certificate already exists for participant ID: {$participant->id} in event ID: {$eventId}");
            return redirect()->to(url("/superadmin/event/show/{$eventId}"))
                ->with('error', 'The certificate has been created previously.');
        }
    }

    return redirect()->to(url("/superadmin/event/show/{$eventId}"))
        ->with('success', 'Participants imported and emails sent successfully.');
    }
    
    
    public function show($id)
    {
        $certif = Certificate::where('participant_id', $id)->first();
        return view('superadmin.certificate.show', compact('certif'));
    }

    public function edit($id)
    {
        $template = Certificate::findOrFail($id);
        return view('superadmin.certificate.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'background_url' => 'required|url',
            'style' => 'nullable|string|max:255',
        ]);

        // Cari template berdasarkan ID
        $template = Certificate::findOrFail($id);

        // Update data template
        $template->update([
            'title' => $validated['title'],
            'background_url' => $validated['background_url'],
            'style' => $validated['style'] ?? $template->style,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('certificate.index')->with('success', 'Template updated successfully.');
    }

    public function search(Request $request)
    {
        
        $search = $request->input('search');
        $results = Certificate::where('id', $search)->get();
        
        if ($results->isEmpty()) {
            return view('superadmin.search-certif.unverified', compact('search'));
        }
        return view('superadmin.search-certif.verified', compact('results'));
    }

    public function pdf(string $id)
    {
        $certif = Certificate::where('participant_id', $id)->first();
        $participant = Participant::where('id', $id)->first();
        if (!$certif) {
            abort(404, 'Certificate not found.');
        }
    
        $nama = $certif->participant->nama;
        
        $pdf = PDF::loadView('superadmin.certificate.certif_pdf', compact('certif', 'participant'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream("certif_$nama.pdf");
    }

    

    public function template()
    {
        $templates = [
            ['id' => 1, 'name' => 'Template 1', 'preview' => asset('sertif/1.jpeg')],
            ['id' => 2, 'name' => 'Template 2', 'preview' => asset('sertif/1.jpeg')],
        ];

        return view('superadmin.certificate.template', compact('templates'));
    }

    public function generate($template_id)
    {
        $template = Certificate::findOrFail($template_id);
        return view('superadmin.certificate.generate', compact('template'));
    }



    public function createTemplate()
{
    $templateCertif = CertificateTemplate::all();
    $participant = Participant::with(['certificate', 'certificate.certificate_templates', 'event'])->first();

    return view('superadmin.certificate.generate', compact('templateCertif', 'participant'));
}

    
    public function storeTemplate(request $request) 
    {
        $validated = $request->validate([
            'nama_template' => 'required|string|max:255',
            'preview' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'ttd' => 'required|string|max:255',
            'uid' => 'required|string|max:255',

        ]);

        
        if ($request->hasFile('preview')) {
            $path = $request->file('preview')->store('sertif', 'public');
        }

        CertificateTemplate::create([
            'nama_template' => $validated['nama_template'],
            'preview' => $path ?? null,
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal' => $validated['tanggal'],
            'ttd' => $validated['ttd'],
            'uid' => $validated['uid'],
        ]);
        return redirect()->route('superadmin.certificate.createTemplate')->with('success', 'Add New Template successfully.');
    }




    public function editTemplate($id){
        $template = CertificateTemplate::findOrFail($id);
        return view('superadmin.certificate.edit',compact('template'));
    }

    public function updateTemplate(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_template' => 'required|string|max:255',
            'preview' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'ttd' => 'required|string|max:255',
            'uid' => 'required|string|max:255',
        ]);

        $template = CertificateTemplate::findOrFail($id);

        if ($request->hasFile('preview')) {
            $path = $request->file('preview')->store('sertif', 'public');
            $template->preview = $path;
        }

        $template->nama_template = $validated['nama_template'];
        $template->nama = $validated['nama'];
        $template->deskripsi = $validated['deskripsi'];
        $template->tanggal = $validated['tanggal'];
        $template->ttd = $validated['ttd'];
        $template->uid = $validated['uid'];
        $template->save();

        return redirect()->route('superadmin.certificate.createTemplate')->with('success', 'Edit Template successfully.');
    }


    public function showTemplate($id){
        $template = CertificateTemplate::findOrFail($id);
        if (!$template) {
            abort(404, 'Certificate not found.');
        }
        
        $pdf = PDF::loadView('superadmin.certificate.certif_pdf_preview', compact('template'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream("certif_.pdf");
    }

    public function saveMargin(Request $request)
{
    $request->validate([
        'field' => 'required|string',
        'margin' => 'required|string',
    ]);

    // Ambil template yang sedang digunakan
    $template = CertificateTemplate::findOrFail($request->template_id); 

    // Update field margin
    $field = $request->field;
    $template->$field = $request->margin;
    $template->save();

    return response()->json(['message' => 'Margin updated successfully']);
}


}