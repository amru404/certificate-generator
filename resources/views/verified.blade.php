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
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="bg-white shadow p-4 p-md-5 rounded text-center">
                    <!-- Certificate Verified Image -->
                    <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" 
                         alt="Verified Icon" class="mb-4" style="width: 100px; height: auto;">

                    <!-- Title -->
                    <h2 class="fw-bold">Certificate Verified</h2>
                    
                    <!-- Certificate Details -->
                    <div class="text-start mt-4">
                        <p class="d-flex justify-content-between">
                            <strong>Certificate Holder:</strong> 
                            <span>{{$certificate->participant->nama}}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <strong>Event Name:</strong> 
                            <span>{{$certificate->event->nama_event}}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <strong>Issued By:</strong> 
                            <span>{{$certificate->event->user->name}}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <strong>Issue Date:</strong> 
                            <span>{{$certificate->event->tanggal}}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <strong>Certificate UUID:</strong> 
                            <span>{{$certificate->id}}</span>
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
                        <a href="{{ route('certif.pdf', $certificate->participant->id) }}" 
                           class="btn btn-dark d-flex align-items-center justify-content-center text-white px-4">
                            <i class="bi bi-download me-2"></i> Download
                        </a>
                        <a href="#" 
                           class="btn btn-dark d-flex align-items-center justify-content-center text-white px-4">
                            <i class="bi bi-share me-2"></i> Share
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
