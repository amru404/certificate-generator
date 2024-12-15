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
use App\Jobs\SendCertificateEmailJob;



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
            return redirect()->to(url("/admin/event/show/{$eventId}"))
                ->with('error', 'No participants found for this event.');
        }
    
        foreach ($participants as $participant) {
            $existingCertificate = Certificate::where('event_id', $event->id)
                ->where('participant_id', $participant->id)
                ->first();
    
            if (!$existingCertificate) {
                // Buat sertifikat baru
                $certificate = Certificate::create([
                    'id' => 'stf-' . Str::random(7),
                    'event_id' => $event->id,
                    'participant_id' => $participant->id,
                    'style' => 'style 1',
                    'certificate_templates_id' => $request->id,
                    'signature' => $event->ttd,
                ]);
    
                // Ambil margin dari template
                $namaMargin = round($participant->event->certificate->certificate_templates->nama ?? 0) . 'px';
                $deskripsiMargin = round($participant->event->certificate->certificate_templates->deskripsi ?? 0) . 'px';
                $tanggalMargin = round($participant->event->certificate->certificate_templates->tanggal ?? 0) . 'px';
                $ttdMargin = round($participant->event->certificate->certificate_templates->ttd ?? 0) . 'px';
                $uidMargin = round($participant->event->certificate->certificate_templates->uid ?? 0) . 'px';
    
                // Generate PDF
                $pdf = PDF::loadView('superadmin.certificate.certif_pdf', [
                    'certificate' => $certificate,
                    'participant' => $participant,
                    'event' => $event,
                    'namaMargin' => $namaMargin,
                    'deskripsiMargin' => $deskripsiMargin,
                    'tanggalMargin' => $tanggalMargin,
                    'ttdMargin' => $ttdMargin,
                    'uidMargin' => $uidMargin,
                ]);
    
                $pdf->setPaper('A4', 'landscape');
    
                // Simpan PDF ke dalam penyimpanan
                $fileName = 'certificate-' . $certificate->id . '.pdf';
                $filePath = storage_path('app/public/certificates/' . $fileName);
                $pdf->save($filePath);
    
                // Kirim email sertifikat
                SendCertificateEmailJob::dispatch($participant, $certificate, $filePath);
            } else {
                // Log info, tapi tetap lanjut ke peserta berikutnya
            if ($existingCertificate) {
                \Log::info("Certificate already exists for participant ID: {$participant->id} in event ID: {$eventId}");
                // Skip ke peserta berikutnya
                continue;
            }
    
            $certificate = Certificate::create([
                'id' => 'stf-' . Str::random(7),
                'event_id' => $event->id,
                'participant_id' => $participant->id,
                'style' => 'style 1',
                'certificate_templates_id' => $request->id,
                'signature' => $event->ttd,
            ]);
    
            SendCertificateEmailJob::dispatch($participant, $certificate);
        }
    
        return redirect()->to(url("/admin/event/show/{$eventId}"))
            ->with('success', 'Participants imported and emails sent successfully.');
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
        ini_set('max_execution_time', 300);
        
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


    public function generate($template_id)
    {
        $template = Certificate::findOrFail($template_id);

        return view('admin.certificate.generate', compact('template'));
    }


}