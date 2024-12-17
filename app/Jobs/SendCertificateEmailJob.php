<?php

namespace App\Jobs;

use App\Mail\CertificateMail;
use App\Models\EmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCertificateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $participant;
    public $certificate;

    // Konstruktor untuk menerima participant dan certificate
    public function __construct($participant, $certificate)
    {
        $this->participant = $participant;
        $this->certificate = $certificate;
    }

    public function handle()
    {
        // Cek apakah email sudah terkirim sebelumnya
        $existingLog = EmailLog::where('participant_id', $this->participant->id)
                               ->where('certificate_id', $this->certificate->id)
                               ->where('status', 'success')
                               ->first();
    
        if ($existingLog) {
            // Jika sudah ada, kita abaikan pengiriman email
            return;
        }
    
        try {
            // Kirim email dengan menggunakan CertificateMail
            Mail::to($this->participant->email)
                ->send(new CertificateMail($this->participant, $this->certificate));
    
            // Log status sukses jika email berhasil dikirim
            EmailLog::create([
                'participant_id' => $this->participant->id,
                'certificate_id' => $this->certificate->id,
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            // Log status gagal jika terjadi kesalahan
            EmailLog::create([
                'participant_id' => $this->participant->id,
                'certificate_id' => $this->certificate->id,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
    
    
}
