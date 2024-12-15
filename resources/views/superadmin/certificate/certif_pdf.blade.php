<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body,
        html {
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

        .content {
            position: relative;
            text-align: center;
            color: #000;
            width: 100%;
            height: 100%;
        }

        .preview-nama {
            position: absolute;
            top: 25%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
            margin: {{ $participant->event->certificate->certificate_templates->nama ?? '0px' }};
        }

        .preview-deskripsi {
            position: absolute;
            top: 50px;
            left: 50px;
            font-size: 18px;
            color: #555;
            text-align: center;
            font-weight: 500;
            width: 500px;
            margin: {{ $participant->event->certificate->certificate_templates->deskripsi ?? '0px' }};
        }

        .preview-tanggal {
            position: absolute;
            bottom: 20%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 16px;
            color: #777;
            font-style: italic;
            margin: {{ $participant->event->certificate->certificate_templates->tanggal ?? '0px' }};
        }

        .preview-uid {
            position: absolute;
            bottom: 15%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px;
            color: #555;
            margin: {{ $participant->event->certificate->certificate_templates->uid ?? '0px' }};
        }

        .signature-img {
            position: absolute;
            bottom: 5%;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: auto;
        }

    </style>
</head>

<body>

    <div class="certificate-container">
        <div style="position: relative; width: 100%; height: 100vh;">

            <!-- Certificate Background -->
            <img src="{{ public_path('storage/' . $participant->certificate->certificate_templates->preview) }}"
                style="width: 100%; height: 100vh; position: absolute; z-index: -1; object-fit: cover;"
                class="certificate-bg">

            <!-- Content Section -->
            <div class="content">
                <!-- Nama -->
                <div class="preview-nama">
                    {{ $participant->nama }}
                </div>

                <!-- Deskripsi -->
                <div class="preview-deskripsi">
                    {{ $participant->event->deskripsi }}
                </div>

                <!-- Tanggal -->
                <div class="preview-tanggal">
                    {{ $participant->event->tanggal }}
                </div>

                <!-- Signature -->
                <img src="{{ public_path('storage/' . $participant->event->ttd) }}" class="signature-img">

                <!-- UID -->
                <div class="preview-uid">
                    UID: {{ $participant->certificate ? $participant->certificate->id : 'UID tidak tersedia' }}
                </div>
            </div>
        </div>
    </div>

</body>

</html>
