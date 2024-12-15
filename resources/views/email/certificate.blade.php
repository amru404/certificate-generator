<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification</title>
</head>
<body>
    <h1>Congratulations, {{ $participant->nama }}!</h1>
    <p>
        Anda telah berhasil menyelesaikan acara <strong>{{ $certificate->event->nama_event }}</strong>.  
        Untuk memverifikasi sertifikat Anda, klik tautan di bawah:
    </p>
    <p>
        <a href="{{ url('http://127.0.0.1:8000/certificate/verification/' . $certificate->id) }}" 
           style="background-color: #007BFF; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Verifikasi Sertifikat Anda
        </a>
    </p>
    <p>
        1. Kalau button tidak berfungsi, kalian bisa copy link dibawah ini ya:
        <br>
        <a href="{{ url('   http://127.0.0.1:8000/certificate/verification/' . $certificate->id) }}">
            {{ url('certificate/verification/' . $certificate->id) }}
        </a>
    </p>

    <p>2. Anda dapat mengunggah sertifikat Anda ke profil LinkedIn Anda dengan mengklik tautan di bawah ini:</p>
    <p><a href="https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name={{ urlencode($certificate->event->nama_event) }}&organizationName={{ urlencode($certificate->event->user->name) }}&issueYear={{ $certificate->created_at->year }}&issueMonth={{ $certificate->created_at->month }}&certUrl={{ urlencode(url('http://127.0.0.1:8000/certificate/verification/'.$certificate->id)) }}&certId={{ $certificate->id }}" target="_blank"  style="background-color: #007BFF; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Upload to LinkedIn</a></p>

    
    <p>
        Best regards,  
        {{ $certificate->event->user->name }}  
    </p>
</body>
</html>
