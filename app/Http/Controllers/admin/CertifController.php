<?php

namespace App\Http\Controllers\admin;

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


class CertifController extends Controller
{
    public function index()
    {

    }

    public function create(string $id)
    {
        $detail_event = Event::with('participants')->findOrFail($id);
        $templates = CertificateTemplate::all(); 
        return view('admin.certificate.add', compact('templates','detail_event'));
    }

    public function store(Request $request, string $eventId)
    {
        $event = Event::findOrFail($eventId);
        $participants = $event->participants;
    
        if (!$participants || $participants->isEmpty()) {
            \Log::error("No participants found for event ID: {$eventId}");
            return redirect()->back()->with('error', 'No participants found for this event.');
        }
    
        foreach ($participants as $participant) {
            $existingCertificate = Certificate::where('event_id', $event->id)
                ->where('participant_id', $participant->id)
                ->first();
    
            if (!$existingCertificate) {
                $certificate = Certificate::create([
                    'id' => Str::uuid()->toString(),
                    'event_id' => $event->id,
                    'participant_id' => $participant->id,
                    'style' => 'style 1',
                    'certificate_templates_id' => $request->id,
                    'signature' => $event->ttd,
                ]);
    
                Mail::to($participant->email)->send(new CertificateMail($participant, $certificate));
            } else {
                \Log::info("Certificate already exists for participant ID: {$participant->id} in event ID: {$eventId}");
                return redirect()->to(url("/admin/event/show/{$eventId}"))
            ->with('error', 'The certificate has been created previously.');
            }
        }
    
        return redirect()->to(url("/admin/event/show/{$eventId}"))
            ->with('success', 'Participants imported and emails sent successfully.');
    }
    
    
    public function show($id)
    {
        $certif = Certificate::where('participant_id', $id)->first();
        return view('admin.certificate.show', compact('certif'));
    }

    public function edit($id)
    {
        $template = Certificate::findOrFail($id);
        return view('admin.certificate.edit', compact('template'));
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
        // Ambil data pencarian dari input
        $search = $request->input('search');

        // Query database berdasarkan ID
        $results = Certificate::where('id', $search)->get();
        
        if ($results->isEmpty()) {
            // Jika hasil kosong, arahkan ke halaman unverified
            return view('admin.search-certif.unverified', compact('search'));
        }

        // Jika ada hasil, arahkan ke halaman verified
        return view('admin.search-certif.verified', compact('results'));
    }

    public function pdf(string $id)
    {
        $certif = Certificate::where('participant_id', $id)->first();
        $participant = Participant::where('id', $id)->first();
        if (!$certif) {
            abort(404, 'Certificate not found.');
        }
    
        $nama = $certif->participant->nama;
        
        $pdf = PDF::loadView('admin.certificate.certif_pdf', compact('certif', 'participant'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream("certif_$nama.pdf");
    }

    public function template()
    {
        $templates = [
            ['id' => 1, 'name' => 'Template 1', 'preview' => asset('sertif/1.jpeg')],
            ['id' => 2, 'name' => 'Template 2', 'preview' => asset('sertif/1.jpeg')],
        ];

        return view('admin.certificate.template', compact('templates'));
    }

    public function generate($template_id)
    {
        // Ambil template berdasarkan ID yang dipilih
        $template = Certificate::findOrFail($template_id);

        // Tampilkan halaman generate sertifikat dengan data template yang dipilih
        return view('admin.certificate.generate', compact('template'));
    }


}

