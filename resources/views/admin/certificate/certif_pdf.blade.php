<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
      
        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #000;
        }
        .name {
            font-size: 52px;
            font-weight: bold;
            margin-top: 120px;
        }
        .message {
            font-size: 18px;
        }
        h2 .uuid{
            position: relative;
            margin:10px 200px;
        }
    </style>
</head>
<body>
<div class="certificate">
    <div style="position: relative; width: 100%; height: 100vh;">
        <!-- Update the image source to an absolute path -->
        <img src="{{ public_path('storage/' . $participant->certificate->certificate_templates->preview) }}"
     style="width: 100%; height: 100vh; position: absolute; z-index: -1; object-fit: cover;">

        <div class="content">
            <p class="name" style="margin-top:260px">{{ $participant->nama }}</p>
            <p class="deskripsi" style="margin-top:70px">{{ $participant->event->deskripsi }}</p>
            <h2 class="tgl" style="margin-left:-480px">{{ $participant->event->tanggal }}</h2>
            <h2 class="signatur" style="margin-top:-400px; margin-right:-480px">{{ $participant->event->ttd }}</h2> <!--kasih font kaya tanda tangan -->
            <p class="deskripsi" style="margin-left:-560px; margin-top:60px">{{ $participant->certificate->id }}</p>
            <!-- logo : <img src="{{ public_path('storage/' . $participant->event->logo) }}"
            style="width: 100%; height: 50vh; position: absolute; z-index: -1; object-fit: cover;"> -->
            


        </div>
    </div>
</body>
</html>
