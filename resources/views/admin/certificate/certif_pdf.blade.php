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
    </style>
</head>
<body>

<div class="certificate">
    <div style="position: relative; width: 100%; height: 100vh;">
        
        <img 
            src="{{ public_path('storage/' . $participant->certificate->certificate_templates->preview) }}" 
            style="width: 100%; height: 100vh; position: absolute; z-index: -1; object-fit: cover;"
        >

        <div class="content" style="text-align:center">
            <h2 class="name" 
                style="position: absolute; top: -120px;left:-200px;font-size: 32px; width:520px">
                {{ $participant->nama }}
            </h2>

            <div style="position: relative; width: 100%; height: 100vh;">
            <p class="deskripsi" 
            style="position: absolute; top: 65px; left: 50%; transform: translateX(-50%); font-size: 13px; width: 500px; text-align: center;">
            {{ $participant->event->deskripsi }}
            </p>
        </div>


            <h2 class="tgl" 
                style="position: absolute; top: 170px; left: -180px; transform: translateX(-50%); font-size: 20px;">
                {{ $participant->event->tanggal }}
            </h2>

            <img 
                src="{{ public_path('storage/' . $participant->event->ttd) }}" 
                class="signatur" 
                style="position: absolute; top: 120px; right: -230px; height: 120px; object-fit: contain;">
            
            <p class="deskripsi" 
                style="position: absolute; top: 260px; left: -200px; transform: translateX(-50%); font-size: 13px;">
               UUID : {{ $participant->certificate->id }}
            </p>
        </div>
    </div>
</div>


</body>
</html>
