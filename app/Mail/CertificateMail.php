<?php

namespace App\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use App\Models\Certificate;
use App\Models\EmailLog;
use App\Models\Participant;
use Illuminate\Contracts\Queue\ShouldQueue;

class CertificateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $participant;
    public $certificate;

    // Constructor to accept participant and certificate
    public function __construct(Participant $participant, Certificate $certificate)
    {
        $this->participant = $participant;
        $this->certificate = $certificate;
    }

    // Build the message
    public function build()
    {
        // Validasi awal untuk memastikan data participant dan certificate valid
        if (!$this->participant || !$this->certificate) {
            throw new \Exception("Participant atau Certificate tidak valid.");
        }
        
        try {
            // Generate the PDF
            $pdf = Pdf::loadView('superadmin.certificate.certif_pdf', [
                'participant' => $this->participant,
                'certificate' => $this->certificate,
            ]);
            $pdf->setPaper('A4', 'landscape');
    
            // Validate PDF content
            $pdfContent = $pdf->output();
            if (!$pdfContent) {
                throw new \Exception("Gagal membuat file PDF untuk participant {$this->participant->id}");
            }
        } catch (\Exception $e) {
            \Log::error("Gagal membuat PDF untuk participant {$this->participant->id}: " . $e->getMessage());
            throw $e; // Lempar ulang exception agar bisa ditangani di level lebih tinggi
        }
    
        // Kirim email dengan lampiran PDF yang sudah divalidasi
        return $this->view('email.certificate')
                    ->subject('Your Event Certificate')
                    ->attachData($pdfContent, "certificate_{$this->participant->nama}.pdf", [
                        'mime' => 'application/pdf',
                ]);
    }
    

}