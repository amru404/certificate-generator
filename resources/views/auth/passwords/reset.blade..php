@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100 d-flex align-items-center">
    <div class="row w-100">
        <!-- Left Image Section -->
        <div class="col-md-6 p-0">
            <img src="your-image-path.jpg" alt="Locks" class="img-fluid vh-100" style="object-fit: cover;">
        </div>
        <!-- Right Content Section -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="p-5">
                <h2 class="mb-4 fw-bold">OTP Verification</h2>
                <p class="mb-3">Enter the 6-digit code sent to your email</p>
                <form>
                    <div class="d-flex justify-content-between mb-4">
                        <input type="text" maxlength="1" class="form-control text-center me-2" style="width: 50px;">
                        <input type="text" maxlength="1" class="form-control text-center me-2" style="width: 50px;">
                        <input type="text" maxlength="1" class="form-control text-center me-2" style="width: 50px;">
                        <input type="text" maxlength="1" class="form-control text-center me-2" style="width: 50px;">
                        <input type="text" maxlength="1" class="form-control text-center me-2" style="width: 50px;">
                        <input type="text" maxlength="1" class="form-control text-center" style="width: 50px;">
                    </div>
                    <button type="submit" class="btn btn-dark w-100 mb-3">Verify</button>
                    <p class="text-center">
                        Didn’t receive code? <a href="#" class="text-decoration-none">Resend</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
