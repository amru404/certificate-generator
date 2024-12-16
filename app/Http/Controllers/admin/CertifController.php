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
            return redirect()->route('admin.event.show', $eventId)
                ->with('error', 'No participants found for this event.');
        }

        foreach ($participants as $participant) {
            // Cek apakah sertifikat sudah ada
            $existingCertificate = Certificate::where('event_id', $eventId)
                ->where('participant_id', $participant->id)
                ->first();

            if ($existingCertificate) {
                \Log::info("Certificate already exists for participant ID: {$participant->id} in event ID: {$eventId}");
                continue; // Skip peserta yang sudah memiliki sertifikat
            }

            // Buat sertifikat baru
            $certificate = Certificate::create([
                'id' => 'stf-' . Str::random(7),
                'event_id' => $eventId,
                'participant_id' => $participant->id,
                'style' => 'style 1',
                'certificate_templates_id' => $request->id,
                'signature' => $event->ttd,
            ]);

            // Generate margin dari template
            $template = $certificate->certificateTemplate;
            $margins = [
                'namaMargin' => round($template->nama ?? 0) . 'px',
                'deskripsiMargin' => round($template->deskripsi ?? 0) . 'px',
                'tanggalMargin' => round($template->tanggal ?? 0) . 'px',
                'ttdMargin' => round($template->ttd ?? 0) . 'px',
                'uidMargin' => round($template->uid ?? 0) . 'px',
            ];

            // Generate PDF
            $pdf = PDF::loadView('superadmin.certificate.certif_pdf', array_merge([
                'certificate' => $certificate,
                'participant' => $participant,
                'event' => $event,
            ], $margins))->setPaper('A4', 'landscape');

            $fileName = 'certificate-' . $certificate->id . '.pdf';
            $filePath = storage_path("app/public/certificates/{$fileName}");
            $pdf->save($filePath);

            // Kirim sertifikat melalui email
            SendCertificateEmailJob::dispatch($participant, $certificate, $filePath);
        }

        return redirect()->route('admin.event.show', $eventId)
            ->with('success', 'Certificates generated and emails sent successfully.');
    }

    // Fitur pencarian sertifikat berdasarkan ID
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

        $certificate = Certificate::where('participant_id', $id)->firstOrFail();
        $participant = $certificate->participant;
        $nama = $participant->nama;

        $pdf = PDF::loadView('admin.certificate.certif_pdf', compact('certificate', 'participant'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream("certif_$nama.pdf");
    }

    // Menampilkan halaman untuk generate sertifikat berdasarkan template
    public function generate($template_id)
    {
        $template = CertificateTemplate::findOrFail($template_id);
        return view('admin.certificate.generate', compact('template'));
    }
}
