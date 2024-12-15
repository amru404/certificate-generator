<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: transparent;
        }

        .certificate-container {
            position: relative;
            width: 100%;
            height: 100vh;
        }

        .certificate-bg {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            z-index: -1;
            top: 0;
            left: 0;
        }

        .tgl {
            position: absolute;
            text-align: center;
            font-size: 18px;
            font-style: italic;
            color: #000;
        }
    </style>
</head>

<body>

    <div class="certificate-container">
        <!-- Background Certificate -->
        <img src="{{ public_path('storage/' . $participant->certificate->certificate_templates->preview) }}"
             alt="Background Certificate" class="certificate-bg">

        <!-- Tanggal dengan Margin dari Database -->
        <div class="tgl" style="{{ $participant->certificate->certificate_templates->tanggal }}">
            {{ $participant->event->tanggal }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
