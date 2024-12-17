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
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-color: transparent;
        }

        .certificate-container {
            position: relative;
            width: 1122px;
            height: 793px;
            /* A4 landscape height */
            margin: 0 auto;
            background-color: #fff;
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
            width: 100%;
            height: 100%;
            text-align: center;
            color: #000;
        }

        /* Penempatan nama */
        .preview-nama {
            font-size: 30px;
            font-weight: bold;
            color: #333;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
            position: absolute;
        }

        .preview-nomor_certificate {
            font-size: 16px;
            color: #777;
            font-style: italic;
            position: absolute;
        }

        /* Penempatan deskripsi */
        .preview-deskripsi {
            font-size: 18px;
            color: #555;
            font-weight: 500;
            width: 500px;
            text-align: center;
            position: absolute;
            top: 55%;
            /* Tetapkan top secara eksplisit */
            left: 50%;
            /* Tetapkan left secara eksplisit */
            transform: translateX(-50%);
            /* Hanya offset horizontal */
            white-space: normal;
            /* Izinkan pembungkusan teks */
            word-wrap: break-word;
            /* Pastikan kata yang panjang terpecah */
            overflow: visible;/
        }

        /* Penempatan tanggal */
        .preview-tanggal {
            font-size: 16px;
            color: #777;
            font-style: italic;
            position: absolute;
        }

        /* Penempatan UID */
        .preview-uid {
            font-size: 14px;
            color: #555;
            position: absolute;
        }

        /* Penempatan tanda tangan */
        .signature-img {
            width: 100px;
            height: auto;
            position: absolute;
        }

    </style>
</head>

<body>

    <div class="certificate-container">
        <div style="position: relative; width: 100%; height: 100vh;">

            <!-- Certificate Background -->
            <img src="{{ public_path('storage/' . $template->preview) }}"
                style="width: 100%; height: 100vh; position: absolute; z-index: -1; object-fit: cover;"
                class="certificate-bg">

            <!-- Content Section -->
            <div class="content">
                <!-- Nama -->
                <div class="preview-nama"
                    style="top:10px; left:85px;margin: {{ $template->nama }}; transform: translate(-50%, -50%);">
                    Amru abdurrahman azzam
                </div>

                <div class="preview-nomor_certificate"
                    style="margin: {{ $template->nomor_certificate }}; transform: translate(-50%, -50%); left:335px">
                    001/MA/MB.DMM/MSIB/XII/2024
                </div>

                <!-- Deskripsi -->
                <div class="preview-deskripsi"
                    style="top: 15px; left: 340px; transform: translateX(-50%); margin: {{ $template->deskripsi }};">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore id praesentium necessitatibus vel
                    debitis aspernatur veritatis impedit assumenda possimus sit? Blanditiis dolorem pariatur optio
                    facere dolore minima doloribus sint id!

                </div>


                <!-- Tanggal -->
                <div class="preview-tanggal"
                    style="top:40px; left:50px;margin: {{ $template->tanggal }}; transform:translate(-50%, -50%);">
                    18 December 2024
                </div>

                <!-- Signature -->
                <img src="{{ public_path('ttd/ttd.png') }}"
                    style="top:60px; left:115px;margin: {{ json_decode($template->ttd) }}; transform:translate(-50%, -50%);"
                    class="signature-img">

                <!-- UID -->
                <div class="preview-uid"
                    style="top:50px; left: 80px;margin: {{ $template->uid }}; transform:translate(-50%, -50%);">
                    UID: csf-spsejr
                </div>
            </div>
        </div>
    </div>

</body>

</html>
