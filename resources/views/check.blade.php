@extends('layouts.app')
@section('content')

<div class="page-bg">
    <!-- Back to Home -->
    <div class="container mt-3">
        <a href="/" class="text-decoration-none text-dark fw-bold">
            &larr; Back to Home
        </a>
    </div>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row g-3">
            <!-- Left Section -->
            <div class="col-12 col-lg-7">
                <div class="bg-white shadow p-4 rounded h-100">
                    <h1 class="fs-4 fw-bold mb-3">Certificate Verification System</h1>
                    <p>Ensure the Authenticity of Your Certificate with a Simple UID Lookup</p>
                    <form action="{{ route('certif.verfication.result') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="id" class="form-label">UUID</label>
                            <input type="text" name="id" class="form-control" id="id" placeholder="Enter certificate UUID">
                        </div>
                        <button type="submit" class="btn w-100 fw-bold text-white" style="background-color: #2D3E50; border: none; padding: 10px 20px; text-align: center; display: inline-block; border-radius: 5px; text-decoration: none;">Verify Now</button>
                    </form>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-12 col-lg-5">
                <div class="bg-white shadow p-4 rounded h-100 d-flex flex-column align-items-center">
                    <img src="{{ asset('assets/cek.jpg') }}" alt="Verification Icon" class="mb-3" style="width: 100px; height: auto;">
                    <h2 class="fs-5 fw-bold mb-3 text-center">Check Certificate</h2>
                    <p class="text-center">Verify the authenticity of your certificate quickly and easily. Enter the unique UID printed on the certificate and your full name to ensure that your certificate is official, valid, and registered in our system.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
