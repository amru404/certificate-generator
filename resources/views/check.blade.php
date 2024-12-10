@extends('layouts.app')

@section('content')
<div class="page-bg position-relative min-vh-100 d-flex flex-column">
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

        <!-- Back to Home -->
    <div class="mb-3">
        <a href="/" class="text-decoration-none text-dark fw-bold">
            &larr; Back to Home
        </a>
    </div>

    <div class="container" style="padding-top: 10%;">
        <div class="row g-4 justify-content-center align-items-stretch">
            <!-- Left Section -->
            <div class="col-12 col-md-8 col-lg-6 d-flex align-items-stretch">
                <div class="bg-white shadow p-4 rounded w-100">
                    <h1 class="fs-5 fw-bold mb-3 text-center">Certificate Verification System</h1>
                    <p class="text-center">Ensure the Authenticity of Your Certificate with a Simple UID Lookup</p>
                    <form action="{{ route('certif.verfication.result') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="id" class="form-label">UID</label>
                            <input type="text" name="id" class="form-control" id="id" placeholder="Enter Certificate UID">
                        </div>
                        <button type="submit" class="btn w-100 fw-bold text-white" style="background-color: #2D3E50; border-radius: 5px;">Verify Now</button>
                    </form>
                </div>
            </div>
    
            <!-- Right Section -->
            <div class="col-12 col-md-8 col-lg-6 d-flex align-items-stretch">
                <div class="bg-white shadow p-4 rounded w-100 text-center">
                    <img src="{{ asset('assets/cek.jpg') }}" alt="Verification Icon" class="mb-3 img-fluid" style="max-width: 100px;">
                    <h2 class="fs-6 fw-bold mb-3">Check Certificate</h2>
                    <p>Verify the authenticity of your certificate quickly and easily. Enter the unique UID printed on the certificate to ensure that your certificate is official, valid, and registered in our system.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.align-items-stretch {
    display: flex;
}

.bg-white {
    min-height: 100%; 
}

    
    @media (max-width: 768px) {
        .row.g-4 {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .col-12.col-md-8.col-lg-6 {
            width: 100% !important;
            max-width: 500px;
            margin-bottom: 1.5rem;
        }

        h1.fs-5, h2.fs-6 {
            font-size: 1.25rem !important;
        }

        img.img-fluid {
            width: 80px;
            height: auto;
        }
    }
</style>
@endsection
