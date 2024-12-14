@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Left Section: Image -->
        <div class="col-12 col-lg-6 p-0">
            <img src="{{ asset('assets/FG.jpg') }}" alt="Keypad" class="img-fluid h-100 " style="object-fit: cover; object-position: left;">
        </div>
        <!-- Right Section: Form -->
        <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center">
            <div class="p-4" style="max-width: 400px; width: 100%;">
                <h1 class="mb-3">Forgot your password?</h1>
                <p class="mb-4">No worries! Just enter your email, and we'll send you a code to reset it.</p>
                <form action="{{route('password.email')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Enter your email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your registered email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Code</button>
                </form>                
            </div>
        </div>
    </div>
</div>
@endsection
