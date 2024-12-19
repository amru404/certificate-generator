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
use App\Models\EmailLog;
use App\Jobs\GenerateCertificatesZip;



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
                'event_id' => $event->id,
                'participant_id' => $participant->id,
                'style' => 'style 1',
                'certificate_templates_id' => $request->id,
            ]);
        }
    
        return redirect()->to(url("/superadmin/event/show/{$eventId}"))
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
        return redirect()->to(url("/superadmin/event/show/{$eventId}"))
            ->with('success', 'Pengiriman email dalam proses.');
    }


    
    public function download_all_pdf(string $id)
    {
        $certificates = Certificate::where('event_id', $id)->get();
    
        if ($certificates->isEmpty()) {
            return redirect()->to(url("/superadmin/event/show/{$id}"))->with('error', 'Certificate Belum Dibuat');
        }
    
        $zip = new \ZipArchive;
        $zipFile = storage_path("app/public/certificates_event_{$id}.zip");
    
        if ($zip->open($zipFile, \ZipArchive::CREATE) === TRUE) {
            foreach ($certificates as $certificate) {
                $participant = $certificate->participant;
                
                if (!$participant) {
                    continue; 
                }
    
                // Generate PDF untuk setiap sertifikat
                $pdf = PDF::loadView('superadmin.certificate.certif_pdf', [
                    'certificate' => $certificate,
                    'participant' => $participant
                ]);
                $pdf->setPaper('A4', 'landscape');
    
                $fileName = "certif_{$participant->nama}_{$certificate->id}.pdf";
                
                $zip->addFromString($fileName, $pdf->output());
            }
    
            // Menutup file ZIP setelah semua PDF dimasukkan
            $zip->close();
        }
    
        // Mengirim file ZIP yang sudah dibuat untuk diunduh
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }

    

    // public function download_all_pdf(string $id)
    // {
    //     // Dispatch job untuk membuat ZIP
    //     GenerateCertificatesZip::dispatch($id);

    //     // Memberikan response ke pengguna bahwa proses sedang berjalan
    //     return redirect()->back()->with('status', 'Proses pembuatan file ZIP sedang berjalan.');
    // }



    // public function downloadZip($eventId)
    // {
    //     $zipFile = storage_path("app/public/certificates_event_{$eventId}.zip");
        
    //     if (file_exists($zipFile)) {
    //         return response()->download($zipFile)->deleteFileAfterSend(true);
    //     } else {
    //         return redirect()->back()->with('error', 'File ZIP tidak ditemukan.');
    //     }
    // }
        
    
    

    public function destroy_all(string $id){
        $certificate = Certificate::where('event_id', $id)->delete();
        if (!$certificate) {
            return redirect()->to(url("/superadmin/event/show/{$id}"))->with('error', 'All Certificates have been deleted');
        }
        return redirect()->to(url("/superadmin/event/show/{$id}"))->with('success', 'Delete All Certificate Successfully');
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
    
        // $dd($participant->event->certificate->certificate_templates->nama);
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


    public function indexTemplate()
    {
        $templateCertif = CertificateTemplate::all();
        $participant = Participant::with(['certificate', 'certificate.certificate_templates', 'event'])->first();

        return view('superadmin.certificate.generate', compact('templateCertif', 'participant'));
    }


    public function createTemplate(){
        return view('superadmin.certificate.add_template');
    }

    
    public function storeTemplate(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_template' => 'required|string|max:255',
            'preview' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'nomor_certificate' => 'required|string|max:255',
            'uid' => 'required|string|max:255',
        ]);
        
        // Upload Preview Image
        $path = null;
        if ($request->hasFile('preview')) {
            $path = $request->file('preview')->store('sertif', 'public');
        }
        
        $ttd1 = $request->input('ttd1');
        $ttd2 = $request->input('ttd2');
        
        $logo1 = $request->input('logo1');
        $logo2 = $request->input('logo2');
        $logo3 = $request->input('logo3');
        $logo4 = $request->input('logo4');
        $logo5 = $request->input('logo5');
        $logo6 = $request->input('logo6');

        $cap1 = $request->input('cap1');
        $cap2 = $request->input('cap2');



        $ttds = [
            $ttd1,
            $ttd2,
        ];
        
        $logos = [
            $logo1,
            $logo2,
            $logo3,
            $logo4,
            $logo5,
            $logo6,
        ];

        $caps = [
            $cap1,
            $cap2,
        ];
    
        $ttd = json_encode($ttds);
        $logo = json_encode($logos);
        $cap = json_encode($caps);

        CertificateTemplate::create([
            'nama_template' => $validated['nama_template'],
            'preview' => $path,
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal' => $validated['tanggal'],
            'nomor_certificate' => $validated['nomor_certificate'],
            'uid' => $validated['uid'],
            'ttd' => $ttd,
            'logo' => $logo,
            'cap' => $cap,  
        ]);
    
        return redirect()->route('superadmin.certificate.indexTemplate')->with('success', 'Add New Template successfully.');
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

        // dd($template->nama);
        
        $pdf = PDF::loadView('superadmin.certificate.certif_pdf_preview', compact('template'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream("certif_.pdf");
    }
    


    function cekpdf(){
        return view('superadmin.certificate.certif_pdf_preview2');
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
    public function generateCertificateView($participantId)
{
    // Cari data peserta berdasarkan ID
    $participant = Participant::with('certificate')->findOrFail($participantId);
    
    // Validasi jika sertifikat tidak ditemukan
    if (!$participant->certificate) {
        return redirect()->back()->with('error', 'Sertifikat tidak ditemukan untuk peserta ini.');
    }

    // Ambil data sertifikat
    $certificate = $participant->certificate;

    // Kirim data ke view
    return view('superadmin.certificate.add_template', [
        'name' => $participant->nama,
        'nomor_certificate' => $certificate->id,
        'deskripsi' => $certificate->deskripsi ?? 'Deskripsi tidak tersedia',
        'tanggal' => now()->format('d F Y'),
        'uid' => $certificate->uid ?? 'UID tidak tersedia',
    ]);
}
public function history()
{
    $certificates = Certificate::with(['participant', 'event'])
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan terbaru
        ->get(); // Ambil semua data tanpa pagination

    return view('superadmin.certificate.history', compact('certificates'));
}

}
