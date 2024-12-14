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
        text-align: center;
    }

    .certificate-preview {
        border: 2px dashed #ccc;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: url('{{ asset("images/sample-certificate.png") }}') no-repeat center/cover;
        position: relative;
    }

    .certificate-preview p {
        position: absolute;
        font-size: 1.5rem;
        font-weight: bold;
        color: #2c3e50;
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
        <div class="certificate-header">
            <h2>🎓 Certificate Generator</h2>
        </div>

        <!-- Certificate Body -->
        <div class="p-4">
            <!-- Certificate Preview -->
            <div class="certificate-preview">
                <iframe src="{{ asset('storage/certificates/' . $certificate->uid . '.pdf') }}" 
                    width="100%" height="400px" style="border: none;">
            </iframe>
                <p id="certificate-name">{{ $certificate->participant->nama }}</p>
            </div>

            <!-- Certificate Details -->
            <div class="mt-4">
                <div class="mb-2"><strong>Event Name:</strong> {{ $certificate->event->nama_event }}</div>
                <div class="mb-2"><strong>Issue Date:</strong> {{ \Carbon\Carbon::parse($certificate->event->tanggal)->translatedFormat('d F Y') }}</div>
                <div><strong>Certificate ID:</strong> {{ $certificate->id }}</div>
            </div>

            <!-- Change Name -->
            <div class="input-group mt-4">
                <input type="text" id="name-input" class="form-control" placeholder="Change Name" value="{{ $certificate->participant->nama }}">
                <button class="btn btn-secondary" onclick="updateCertificateName()">Update</button>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-center gap-3 mt-4">
                <!-- Preview Button -->
                <a href="{{ route('certif.pdf', $certificate->participant->id) }}" 
                   class="btn btn-dark">
                    <i class="bi bi-eye me-1"></i> Preview
                </a>

                <!-- Download Button -->
                <a href="{{ route('certif.pdf', $certificate->participant->id) }}" 
                   class="btn btn-success">
                    <i class="bi bi-download me-1"></i> Download
                </a>

                <!-- LinkedIn Share -->
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('certif.pdf', $certificate->participant->id)) }}"
                   target="_blank" class="btn btn-linkedin">
                    <i class="bi bi-linkedin me-1"></i> Share on LinkedIn
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

@endsection
