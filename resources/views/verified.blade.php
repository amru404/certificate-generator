@extends('layouts.app')

@section('content')

<div class="page-bg">
<!-- Back to Home -->
<div class="container mt-3">
    <a href="/" class="text-decoration-none text-dark fw-bold">
        &larr; Back 
    </a>
</div>

<!-- Certificate Verification -->
<div class="container d-flex justify-content-center align-items-center my-5">
    <div class="bg-white shadow p-5 rounded text-center" style="max-width: 600px;">
        <!-- Certificate Verified Image -->
        <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" 
             alt="Verified Icon" class="mb-4" style="width: 100px; height: auto;">

        <!-- Title -->
        <h2 class="fw-bold">Certificate Verified</h2>
        
        <!-- Certificate Details -->
        <div class="text-start mt-4">
            <p><strong>Certificate Holder:</strong> <span class="float-end">{{$certificate->participant->nama}}</span></p>
            <p><strong>Event Name:</strong> <span class="float-end">{{$certificate->event->nama_event}}</span></p>
            <p><strong>Issued By:</strong> <span class="float-end">{{$certificate->event->user->name}}</span></p>
            <p><strong>Issue Date:</strong> <span class="float-end">{{$certificate->event->tanggal}}</span></p>
            <p><strong>Certificate UUID:</strong> <span class="float-end">{{$certificate->id}}</span></p>
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('certif.pdf', $certificate->participant->id) }}" class="btn d-flex align-items-center text-white" style="background-color: #2D3E50; border: none; padding: 10px 20px; text-align: center; display: inline-block; border-radius: 5px; text-decoration: none;">
                <i class="bi bi-download me-2"></i> Download
            </a>
            <a href="#" class="btn d-flex align-items-center text-white" style="background-color: #2D3E50; border: none; padding: 10px 20px; text-align: center; display: inline-block; border-radius: 5px; text-decoration: none;">
                <i class="bi bi-share me-2"></i> Share
            </a>
        </div>
    </div>
</div>
</div>
@endsection
