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
            width: 90%;
        }

        .name {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
        }

        .message {
            font-size: 18px;
        }

        .tgl {
            position: absolute;
            color: #000000d3;
            transform: translateX(-50%);
            font-size: 1rem;
            bottom: 120px;
        }

        .uid {
            position: absolute;
            transform: translateX(-50%);
            font-size: 1rem;
            font-weight: bold;
            color: #000000d3;
            bottom: 100px;
        }

        .signatur-img {
            position: absolute;
            top: 130px;
            right: -250px;
            max-width: 150px;
            max-height: 100px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .deskripsi {
            font-size: 1rem;
            text-align: center;
            margin: 0;
        }

        @media (max-width: 480px) {
            .name {
                font-size: 1.5rem;
                margin-top: 40px;
            }

            .deskripsi {
                font-size: 0.8rem !important;
                top: 50px !important;
                width: 100% !important;
                margin-top: 10px;
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
        }

    </style>
</head>

<body>

    <div class="certificate-container">
        <div style="position: relative; width: 100%; height: 100vh;">
            <img src="{{ public_path('storage/' . $template) }}"
                style="width: 100%; height: 100vh; position: absolute; z-index: -1; object-fit: cover;"
                class="certificate-bg">

            <div class="content">

                <h2 class="name" style="margin:">
                    amru azzam
                </h2>

                <p class="deskripsi" style="margin: {{ $template->deskripsi ?? '0px' }};">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Est beatae laborum vel obcaecati, neque
                    doloribus similique hic corrupti accusamus voluptatem distinctio illum doloremque esse,
                    consequatur nisi dignissimos harum eos tempore!
                </p>

                <h2 class="tgl" style="margin: {{ $template->tanggal }};">
                    02/10/2020
                </h2>

                <img src="{{ public_path('ttd/ttd.png') }}" class="signatur-img">

                <p class="uid" style="margin: {{ $template->uid }};">
                    UID : scr-123211231
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
