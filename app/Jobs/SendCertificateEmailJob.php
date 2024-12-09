<?php

namespace App\Jobs;

use App\Mail\CertificateMail;
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

    public function __construct($participant, $certificate)
    {
        $this->participant = $participant;
        $this->certificate = $certificate;
    }

    public function handle()
    {
        Mail::to($this->participant->email)->send(new CertificateMail($this->participant, $this->certificate));
    }
}