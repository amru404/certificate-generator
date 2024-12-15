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
use Options;
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

                dd($participant->event->certificate->certificate_templates);
    
                // Ambil margin dari template
                $namaMargin = is_numeric($participant->event->certificate->certificate_templates->nama ?? null)
    ? round((float)$participant->event->certificate->certificate_templates->nama) . 'mm'
    : '0mm';

$deskripsiMargin = is_numeric($participant->event->certificate->certificate_templates->deskripsi ?? null)
    ? round((float)$participant->event->certificate->certificate_templates->deskripsi) . 'mm'
    : '0mm';

$tanggalMargin = is_numeric($participant->event->certificate->certificate_templates->tanggal ?? null)
    ? round((float)$participant->event->certificate->certificate_templates->tanggal) . 'mm'
    : '0mm';

$ttdMargin = is_numeric($participant->event->certificate->certificate_templates->ttd ?? null)
    ? round((float)$participant->event->certificate->certificate_templates->ttd) . 'mm'
    : '0mm';

$uidMargin = is_numeric($participant->event->certificate->certificate_templates->uid ?? null)
    ? round((float)$participant->event->certificate->certificate_templates->uid) . 'mm'
    : '0mm';

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

    
$pdf->setPaper([0, 0, 595.28, 841.89], 'landscape'); // Custom ukuran A4 dalam point

    
                // Simpan PDF ke dalam penyimpanan
                $fileName = 'certificate-' . $certificate->id . '.pdf';
                $filePath = storage_path('app/public/certificates/' . $fileName);
                $pdf->save($filePath);
    
                // Kirim email sertifikat
                SendCertificateEmailJob::dispatch($participant, $certificate, $filePath);
            } else {
                // Log info, tapi tetap lanjut ke peserta berikutnya
                \Log::info("Certificate already exists for participant ID: {$participant->id} in event ID: {$eventId}");
            }
        }
    
        // Setelah semua peserta diproses
        return redirect()->to(url("/admin/event/show/{$eventId}"))
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



public function generatePdf(Request $request, $participantId)
{
    $participant = Participant::with('event.certificate_templates')->findOrFail($participantId);
    $template = $participant->event->certificate_templates;

    if (!$template) {
        return response()->json(['error' => 'Template tidak ditemukan'], 404);
    }

    // Dimensi kontainer PDF
    $pdfWidth = 794;  // Lebar A4 (landscape) dalam pixel (1/96 inch)
    $pdfHeight = 1123; // Tinggi A4 dalam pixel (1/96 inch)

    $namaMargin = $this->convertMarginToPx((float) ($template->nama ?? 20), $pdfHeight);
    $deskripsiMargin = $this->convertMarginToPx((float) ($template->deskripsi ?? 30), $pdfHeight);
    $tanggalMargin = $this->convertMarginToPx((float) ($template->tanggal ?? 40), $pdfHeight);
    $ttdMargin = $this->convertMarginToPx((float) ($template->ttd ?? 50), $pdfHeight);
    $uidMargin = $this->convertMarginToPx((float) ($template->uid ?? 60), $pdfHeight);

    // Render PDF
    $pdf = PDF::loadView('admin.certificate.certif_pdf', compact(
        'participant',
        'namaMargin',
        'deskripsiMargin',
        'tanggalMargin',
        'ttdMargin',
        'uidMargin'
    ))->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
    $pdf->setPaper('A4', 'landscape');

    return $pdf->stream("certificate-{$participant->id}.pdf");
}

private function convertMarginToPx($percentage, $dimension)
{
    return round(($percentage / 100) * $dimension) . 'px';
}




}