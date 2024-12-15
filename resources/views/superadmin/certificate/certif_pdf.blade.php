<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #000;
        }

        /* @media (max-width: 480px) {
            .name {
                font-size: 1.5rem;
                margin-top: 40px;
            }

            .deskripsi {
                font-size: 0.8rem !important;
                top: 50px !important;
                width: 100% !important;
            }

            .tgl,
            .uid {
                font-size: 0.8rem;
                text-align: center;
            }

            .signatur-img {
                max-width: 100px;
            }
        }

        @media (max-width: 768px) {
            .name {
                font-size: 1.8rem;
                margin-top: 60px;
            }

            .deskripsi {
                font-size: 0.9rem !important;
                top: 60px !important;
                width: 90% !important;
            }

            .tgl {
                position: static;
                font-size: 0.9rem;
            }

            .uid {
                position: static;
                font-size: 0.9rem;
            }

            .signatur-img {
                position: static;
                margin: 20px auto 0;
                display: block;
                max-width: 120px;
                height: auto;
            }
        } */

    </style>
</head>

<body>

    <div class="certificate-container">
        <div style="position: relative; width: 100%; height: 100vh;">

            <img src="{{ public_path('storage/' . $participant->certificate->certificate_templates->preview) }}"
                style="width: 100%; height: 100vh; position: absolute; z-index: -1; object-fit: cover;"
                class="certificate-bg">

            <div class="content" style="text-align:center">

                <h2 class="name" style="position: absolute; font-size: 32px; width: 520px; margin: 
    {{ $participant->event->certificate->certificate_templates->nama ?? '0px' }};">


                    {{ $participant->nama }}
                    <br>

                </h2>

                <div style="position: relative; width: 100%; height: 100vh;">
                    <p class="deskripsi"
                        style="position: absolute; transform: translateX(-50%); font-size: 13px; width: 500px; text-align: center; margin: 
    {{ $participant->event->certificate->certificate_templates->deskripsi ?? '0px' }};">
                        {{ $participant->event->deskripsi }}
                    </p>
                </div>
                <h2 class="tgl" style="margin: 
    {{ $participant->event->certificate->certificate_templates->tanggal ?? '0px' }};">
                    {{ $participant->event->tanggal }}
                </h2>

                <img src="{{ public_path('storage/' . $participant->event->ttd) }}" class="signatur-img" >

                <p class="uid" style="margin: 
    {{ $participant->event->certificate->certificate_templates->uid ?? '0px' }};">
                    UID : {{ $participant->certificate->id }}
                </p>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
