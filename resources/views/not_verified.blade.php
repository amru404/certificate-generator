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
        <img src="{{ asset('assets/not_verified.png') }}" 
             alt="" class="mb-4" style="width: 100px; height: auto;">

        <!-- Title -->
        <h2 class="fw-bold">Certificate {{$id}} Not Verified</h2>
        
     

        <!-- Buttons -->
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="/" class="btn d-flex align-items-center text-white" style="background-color: #2D3E50; border: none; padding: 10px 20px; text-align: center; display: inline-block; border-radius: 5px; text-decoration: none;">
            &larr; Back 
            </a>
        </div>
    </div>
</div>
</div>
@endsection
