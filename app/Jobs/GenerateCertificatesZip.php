<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Certificate;
use App\Models\Participant;
use PDF;
use ZipArchive;
use App\Models\User;
use App\Notifications\FileReadyForDownload;



class GenerateCertificatesZip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $eventId;

    // Konstruktor untuk menerima ID event
    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    // Fungsi untuk mengeksekusi job
    public function handle()
    {
        $certificates = Certificate::where('event_id', $this->eventId)->get();
    
        if ($certificates->isEmpty()) {
            // Jika tidak ada sertifikat, tidak perlu lanjutkan
            return;
        }
    
        $zip = new ZipArchive;
        $zipFile = storage_path("app/public/certificates_event_{$this->eventId}.zip");
    
        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
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
                
                // Menambahkan file PDF ke ZIP
                $zip->addFromString($fileName, $pdf->output());
            }
    
            // Menutup file ZIP setelah semua PDF dimasukkan
            $zip->close();
    
            // Setelah selesai, kirimkan notifikasi ke pengguna
            $user = User::find($this->userId); // Pastikan kamu punya $this->userId
            $user->notify(new FileReadyForDownload($zipFile));
        }
    }
}