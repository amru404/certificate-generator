@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f9f9f9;
    }

    .certificate-container {
        max-width: 800px;
        margin: auto;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .certificate-header {
        background-color: #2c3e50;
        color: #fff;
        padding: 15px;
        display: flex;
        justify-content:center;
    }

    .certificate-preview {
        border: 2px dashed #ccc;
        height: auto; /* Biarkan tinggi disesuaikan secara otomatis */
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%; /* Pastikan kontainer mengambil 100% lebar */
    }
    
    #pdf-canvas {
        width: 100%; /* Membuat canvas mengikuti lebar kontainer */
        height: auto; /* Menjaga rasio aspek PDF */
    }

    .input-group {
        margin-top: 20px;
    }

    .btn-linkedin {
        background-color: #0a66c2;
        color: white;
    }

    @media (max-width: 576px) {
        .certificate-preview {
            height: 250px;
        }
    }
</style>

<div class="container my-5">
    <!-- Back -->
    <div class="mb-4">
        <a href="/" class="text-decoration-none text-dark fw-bold">
            &larr; Back
        </a>
    </div>

    <!-- Certificate Section -->
    <div class="certificate-container">
        <!-- Header -->
        <div class="certificate-header d-flex text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" 
        alt="Verified Icon" class=" me-4" style="width: 50px; height: 50px;">
            <h2>Certificate Verified</h2>
        </div>

        <!-- Certificate Body -->
        <div class="p-4">
            <!-- Certificate Preview -->
            <div class="certificate-preview">
            <canvas id="pdf-canvas"  width="100%" height="400px" style="border: none;"></canvas>
 
            </div>

            <!-- Certificate Details -->

            <div class="mt-4">
            <div class="mb-2"><strong>Name:</strong> {{ $certificate->participant->nama }}</div>

            <div class="mb-2"><strong>Event Name:</strong> {{ $certificate->event->nama_event }}</div>
                <div class="mb-2"><strong>Issue Date:</strong> {{ \Carbon\Carbon::parse($certificate->event->tanggal)->translatedFormat('d F Y') }}</div>
                <div><strong>Certificate ID:</strong> {{ $certificate->id }}</div>
            </div>


            <!-- Action Buttons -->
            <div class="d-flex justify-content-center gap-3 mt-4">
                <!-- Preview Button -->
                <a href="{{ route('certif.pdf', $certificate->participant->id) }}" 
                   class="btn btn-dark">
                    <i class="bi bi-eye me-1"></i> Preview
                </a>

                <!-- Download Button -->
                <a href="{{ route('certif.pdf.download', $certificate->participant->id) }}" 
                   class="btn btn-success">
                    <i class="bi bi-download me-1"></i> Download
                </a>

            </div>
        </div>
    </div>
</div>

<script>
    
    function updateCertificateName() {
        const inputName = document.getElementById('name-input').value;
        const certificateName = document.getElementById('certificate-name');
        certificateName.textContent = inputName;
    }
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

<script>
    // Menentukan lokasi file PDF yang akan dirender
    var pdfUrl = "{{ route('certif.pdf', $certificate->participant->id) }}";

    // Mengambil elemen canvas
    var canvas = document.getElementById('pdf-canvas');
    var context = canvas.getContext('2d');

    // Menggunakan pdf.js untuk mengambil dan merender PDF
    pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
        // Mengambil halaman pertama dari PDF
        pdf.getPage(1).then(function(page) {
            var scale = 0.65; // Skalakan halaman PDF
            var viewport = page.getViewport({ scale: scale });

            // Set ukuran canvas sesuai dengan ukuran kontainer
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Mengatur ulang ukuran canvas jika ukuran layar berubah
            function resizeCanvas() {
                var containerWidth = document.querySelector('.certificate-preview').offsetWidth;
                var scale = containerWidth / viewport.width; // Menghitung skala berdasarkan lebar kontainer
                var newViewport = page.getViewport({ scale: scale });

                // Update ukuran canvas dan render ulang halaman
                canvas.width = containerWidth;
                canvas.height = newViewport.height;
                page.render({
                    canvasContext: context,
                    viewport: newViewport
                });
            }

            // Render halaman PDF ke dalam canvas
            page.render({
                canvasContext: context,
                viewport: viewport
            });

            // Panggil fungsi resizeCanvas setiap kali ukuran jendela berubah
            window.addEventListener('resize', resizeCanvas);
        });
    }).catch(function(error) {
        console.error("Error while rendering PDF: ", error);
    });
</script>


@endsection