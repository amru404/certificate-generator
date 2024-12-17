<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Acara</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0;">
    <!-- Container Email -->
    <div style="max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #2F3C7E, #4E54C8); color: #ffffff; padding: 30px 20px; text-align: center; border-bottom-left-radius: 50% 20%; border-bottom-right-radius: 50% 20%;">
            <!-- Logo dari Backend -->
            <img src="{{ asset('assets/logo-animated.gif') }}" alt="Logo" style="width: 80px; margin-bottom: 10px;">
            <h2 style="margin: 0; font-size: 24px;">Selamat, {{ $participant->nama }}!</h2>
        </div>

        <!-- Body -->
        <div style="padding: 30px; color: #333333;">
            <p style="margin: 15px 0; font-size: 16px;">
                Anda telah berhasil menyelesaikan acara <strong>{{ $certificate->event->nama_event }}</strong>. Kami sangat bangga dengan pencapaian Anda!
            </p>

            <p style="margin: 15px 0; font-size: 16px; text-align: center;">
                Silakan verifikasi sertifikat Anda dengan mengklik tombol di bawah ini:
            </p>

            <!-- Tombol Verifikasi -->
            <div style="text-align: center;">
                <a href="{{ url('http://127.0.0.1:8000/certificate/verification/' . $certificate->id) }}" 
                   style="background-color: #28a745; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 5px; padding: 12px 25px; display: inline-block;">
                    Verifikasi Sertifikat
                </a>
            </div>

            <!-- Tautan Alternatif -->
            <p style="margin-top: 20px; font-size: 14px; text-align: center;">
                Jika tombol tidak berfungsi, salin tautan berikut ke browser Anda:<br>
                <a href="{{ url('http://127.0.0.1:8000/certificate/verification/' . $certificate->id) }}" style="color: #4E54C8; text-decoration: none;">
                    {{ url('certificate/verification/' . $certificate->id) }}
                </a>
            </p>

            <!-- LinkedIn Upload -->
            <p style="margin: 20px 0; font-size: 16px; text-align: center;">
                Anda dapat mengunggah sertifikat ke profil LinkedIn Anda:
            </p>
            <div style="text-align: center;">
                <a href="https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name={{ urlencode($certificate->event->nama_event) }}&organizationName={{ urlencode($certificate->event->user->name) }}&issueYear={{ $certificate->created_at->year }}&issueMonth={{ $certificate->created_at->month }}&certUrl={{ urlencode(url('http://127.0.0.1:8000/certificate/verification/'.$certificate->id)) }}&certId={{ $certificate->id }}"
                   target="_blank" 
                   style="background-color: #007BFF; color: #fff; text-decoration: none; font-weight: bold; border-radius: 5px; padding: 12px 20px; display: inline-flex; align-items: center;">
                    <!-- Logo LinkedIn -->
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/ca/LinkedIn_logo_initials.png" 
                         alt="LinkedIn" 
                         style="width: 18px; height: 18px; max-width: 18px; margin-right: 10px; display: inline-block; vertical-align: middle;">
                    Upload to LinkedIn
                </a>
            </div>            
        </div>

        <!-- Footer -->
        <div style="background-color: #f1f1f1; text-align: center; padding: 10px; color: #777777; font-size: 12px;">
            <p style="margin: 0;">Salam dari kami,<br> {{ $certificate->event->user->name }}</p>
            <p style="margin: 0;">&copy; 2024 Event {{ $certificate->event->nama_event }} | Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
