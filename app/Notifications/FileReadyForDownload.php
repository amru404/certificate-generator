<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FileReadyForDownload extends Notification
{
    protected $zipFile;

    // Konstruktor untuk menerima parameter file ZIP yang telah dibuat
    public function __construct($zipFile)
    {
        $this->zipFile = $zipFile;
    }

    // Menentukan media notifikasi
    public function via($notifiable)
    {
        return ['database', 'mail']; // Bisa mengirim via database atau email
    }

    // Isi notifikasi dalam bentuk array
    public function toArray($notifiable)
    {
        return [
            'message' => 'File sertifikat sudah siap untuk diunduh.',
            'zip_file_url' => asset('storage/certificates_event_' . basename($this->zipFile)) // URL untuk mengunduh file
        ];
    }

    // Untuk email notifikasi (opsional)
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('File Sertifikat Siap Diunduh')
                    ->line('File sertifikat yang Anda buat sudah siap untuk diunduh.')
                    ->action('Unduh Sekarang', url('storage/certificates_event_' . basename($this->zipFile)))
                    ->line('Terima kasih telah menggunakan layanan kami.');
    }
}
