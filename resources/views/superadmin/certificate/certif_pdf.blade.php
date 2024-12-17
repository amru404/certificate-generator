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
            <img src="{{ public_path('storage/' . $participant->event->certificate->certificate_templates->preview) }}"
                style="width: 100%; height: 100vh; position: absolute; z-index: -1; object-fit: cover;"
                class="certificate-bg">

            <!-- Content Section -->
            <div class="content">
                
                <!-- logo -->
                @php
                    $logo = json_decode($participant->event->logo);
                    $margins = json_decode($participant->event->certificate->certificate_templates->logo);
              
                 @endphp

                    <!-- Gambar 1 -->
                @if (isset($logo[0]) && isset($margins[0]))
                    <img src="{{ public_path('storage/' . $logo[0]) }}"style=" top: -20px; left:170px; margin: {{ $margins[0] }}; transform:translate(-50%, -50%); width:60px "class="signature-img">
                @endif

                <!-- Gambar 2 -->

                 @if (isset($logo[1]) && isset($margins[1]))
                    <img src="{{ public_path('storage/' . $logo[1]) }}"style="top:0px; left:100px; margin: {{ $margins[1] }}; transform:translate(-50%, -50%); width:60px "class="signature-img">
                @endif

                 <!-- Gambar 3 -->



                 @if (isset($logo[2]) && isset($margins[2]))
                    <img src="{{ public_path('storage/' . $logo[2]) }}"style="top:0px; left:100px; margin: {{ $margins[2] }}; transform:translate(-50%, -50%); width:60px "class="signature-img">
                @endif

                 <!-- Gambar 4 -->

                 @if (isset($logo[3]) && isset($margins[3]))
                    <img src="{{ public_path('storage/' . $logo[3]) }}"style="top:0px; left:100px; margin: {{ $margins[3] }}; transform:translate(-50%, -50%); width:60px "class="signature-img">
                @endif

                 <!-- Gambar 5 -->

                 @if (isset($logo[4]) && isset($margins[4]))
                    <img src="{{ public_path('storage/' . $logo[4]) }}"style="top:0px; left:100px; margin: {{ $margins[4] }}; transform:translate(-50%, -50%); width:60px "class="signature-img">
                @endif

                 <!-- Gambar 6 -->

                 @if (isset($logo[5]) && isset($margins[5]))
                    <img src="{{ public_path('storage/' . $logo[5]) }}"style="top:0px; left:100px; margin: {{ $margins[5] }}; transform:translate(-50%, -50%); width:60px "class="signature-img">
                @endif

                <!-- Nama -->
                <div class="preview-nama"
                    style="top:10px; left:85px;margin: {{ $participant->event->certificate->certificate_templates->nama }}; transform: translate(-50%, -50%);">
                    {{ $participant->nama }}

                </div>
                <!--Nomor-->
                <div class="preview-nomor_certificate"
                    style="top: -25px; margin: {{ $participant->event->certificate->certificate_templates->nomor_certificate }}; transform: translate(-50%, -50%); left:250px">
                    {{$participant->event->nomor_certificate}}
                </div>

                <!-- Deskripsi -->
                <div class="preview-deskripsi"
                    style="top: 15px; left: 340px; transform: translateX(-50%); margin: {{ $participant->event->certificate->certificate_templates->deskripsi }};">
                    {{ $participant->event->deskripsi }}

                </div>


                <!-- Tanggal -->
                {{-- <!-- <div class="preview-tanggal"
                    style="top:40px; left:50px;margin: {{ $participant->event->certificate->certificate_templates->tanggal }};">
                    {{ \Carbon\Carbon::parse($participant->event->tanggal)->translatedFormat('d F Y') }}
                </div> --> --}}

                <div class="preview-tanggal"
                    style="top:50px; left:30px;margin: {{ $participant->event->certificate->certificate_templates->tanggal }}; transform:translate(-50%, -50%);">
                    {{ \Carbon\Carbon::parse($participant->event->tanggal)->translatedFormat('d F Y') }}
                </div>
                

                <!-- Signature -->
                    @php
                        $ttd = json_decode($participant->event->ttd);
                        $margins = json_decode($participant->event->certificate->certificate_templates->ttd);
                    @endphp

                    <!-- Gambar 1 -->
                    @if (isset($ttd[0]) && isset($margins[0]))
                        <img src="{{ public_path('storage/' . $ttd[0]) }}"
                            style="top:80px; left:120px; margin: {{ $margins[0] }}; transform:translate(-50%, -50%); width:120px"
                            class="signature-img">
                    @endif

                    <!-- Gambar 2 -->

                    @if (isset($ttd[1]) && isset($margins[1]))
                        <img src="{{ public_path('storage/' . $ttd[1]) }}"
                            style="top:60px; left:115px; margin: {{ $margins[1] }}; transform:translate(-50%, -50%); width:120px"
                            class="signature-img">
                    @endif

                    <!-- cap -->
                    @php
                        $cap = json_decode($participant->event->cap);
                        $margins = json_decode($participant->event->certificate->certificate_templates->ttd);
                    @endphp

                    <!-- Gambar 1 -->
                    @if (isset($cap[0]) && isset($margins[0]))
                        <img src="{{ public_path('storage/' . $cap[0]) }}"
                            style="top:80px; left:120px; margin: {{ $margins[0] }}; transform:translate(-50%, -50%); width:70px"
                            class="signature-img">
                    @endif


                    <!-- Gambar 2 -->

                    @if (isset($cap[1]) && isset($margins[1]))
                        <img src="{{ public_path('storage/' . $cap[1]) }}"
                            style="top:60px; left:115px; margin: {{ $margins[1] }}; transform:translate(-50%, -50%); width:70px"
                            class="signature-img">
                    @endif




                <!-- UID -->
                <div class="preview-uid"
                    style="top:60px; left: 20px;margin: {{ $participant->event->certificate->certificate_templates->uid }}; transform:translate(-50%, -50%);">
                    UID: {{ $participant->certificate ? $participant->certificate->id : 'UID tidak tersedia' }}

                </div>
            </div>
        </div>
    </div>

</body>

</html>
