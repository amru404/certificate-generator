<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\Participant;
use App\Models\CertificateTemplate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Jobs\SendCertificateEmailJob;

class CertifController extends Controller
{
    // Menampilkan halaman daftar sertifikat
    public function index()
    {
        return view('admin.certificate.index');
    }

    // Menampilkan form pembuatan sertifikat untuk event tertentu
    public function create(string $id)
    {
        $detail_event = Event::with('participants')->findOrFail($id);
        $templates = CertificateTemplate::all();
        return view('admin.certificate.add', compact('templates', 'detail_event'));
    }

    // Menyimpan sertifikat untuk peserta dalam sebuah event
    public function store(Request $request, string $eventId)
    {
        $event = Event::findOrFail($eventId);
        $participants = $event->participants;

        if ($participants->isEmpty()) {
            \Log::error("No participants found for event ID: {$eventId}");
            return redirect()->to(url("/admin/event/show/{$eventId}"))
                ->with('error', 'No participants found for this event.');
        }

        foreach ($participants as $participant) {
            // Check if certificate already exists
            $existingCertificate = Certificate::where('event_id', $event->id)
                ->where('participant_id', $participant->id)
                ->first();
    
            if ($existingCertificate) {
                \Log::info("Certificate already exists for participant ID: {$participant->id} in event ID: {$eventId}");
                continue;
            }
    
            // Create a new certificate
            $certificate = Certificate::create([
                'id' => 'stf-' . Str::random(7),
                'event_id' => $eventId,
                'participant_id' => $participant->id,
                'style' => 'style 1',
                'certificate_templates_id' => $request->id,
            ]);
        }
    
        // Redirect back with success message
        return redirect()->to(url("/admin/event/show/{$eventId}"))
            ->with('success', 'Participants imported and emails sent successfully.');
    }
    
    
    public function sendEmail(Request $request, string $eventId)
    {
        
        $event = Event::findOrFail($eventId);
        $participants = $event->participants;

        // Validasi jika tidak ada peserta
        if ($participants->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada participant untuk event ini.');
        }

        $errors = []; // Array untuk menyimpan peserta tanpa sertifikat

        foreach ($participants as $participant) {
            $certificate = Certificate::where('participant_id', $participant->id)->first();

            if (!$certificate) {
                $errors[] = $participant->nama;
                continue;
            }

            SendCertificateEmailJob::dispatch($participant, $certificate);
        }

        if (!empty($errors)) {
            return redirect()->back()->with('error', 'Beberapa peserta tidak memiliki sertifikat: ');
        }

        // Jika semua proses berhasil
        return redirect()->to(url("/admin/event/show/{$eventId}"))
            ->with('success', 'Pengiriman email dalam proses.');
    }


     
    public function download_all_pdf(string $id)
    {
        $certificates = Certificate::where('event_id', $id)->get();
    
        if ($certificates->isEmpty()) {
            return redirect()->to(url("/admin/event/show/{$id}"))->with('error', 'Certificate Belum Dibuat');
        }
    
        $zip = new \ZipArchive;
        $zipFile = storage_path("app/public/certificates_event_{$id}.zip");
    
        if ($zip->open($zipFile, \ZipArchive::CREATE) === TRUE) {
            foreach ($certificates as $certificate) {
                $participant = $certificate->participant;
                
                if (!$participant) {
                    continue; 
                }
    
                $pdf = PDF::loadView('admin.certificate.certif_pdf', [
                    'certificate' => $certificate,
                    'participant' => $participant
                ]);
                $pdf->setPaper('A4', 'landscape');
    
                $fileName = "certif_{$participant->nama}_{$certificate->id}.pdf";
                
                $zip->addFromString($fileName, $pdf->output());
            }
    
            $zip->close();
        }
    
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }


    

    public function destroy_all(string $id){
        $certificate = Certificate::where('event_id', $id)->delete();
        if (!$certificate) {
            return redirect()->to(url("/admin/event/show/{$id}"))->with('error', 'Semua Certifikat sudah dihapus sebelumnya');
        }
        return redirect()->to(url("/admin/event/show/{$id}"))->with('success', 'Delete All Certificate Successfully');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $results = Certificate::where('id', $search)->get();

        if ($results->isEmpty()) {
            return view('admin.search-certif.unverified', compact('search'));
        }

        return view('admin.search-certif.verified', compact('results'));
    }

    // Meng-generate PDF sertifikat untuk peserta tertentu
    public function pdf(string $id)
    {
        ini_set('max_execution_time', 300);
        
        $certif = Certificate::where('participant_id', $id)->first();
        $participant = Participant::where('id', $id)->first();
        if (!$certif) {
            abort(404, 'Certificate not found.');
        }
    
        // dd($participant->event->certificate->certificate_templates->nama);
        $nama = $certif->participant->nama;
        
        $pdf = PDF::loadView('admin.certificate.certif_pdf', compact('certif', 'participant'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream("certif_$nama.pdf");
    }

    public function pdfDownload(string $id)
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
        
        return $pdf->download("certif_$nama.pdf");
    }
    


    public function generate($template_id)
    {
        $template = CertificateTemplate::findOrFail($template_id);
        return view('admin.certificate.generate', compact('template'));
    }
}
