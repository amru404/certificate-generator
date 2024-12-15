@extends('layouts.app')
@section('content')

<div class="container d-flex flex-column flex-md-row align-items-center min-vh-100">
    <!-- Image Section -->
    <div class="col-12 col-md-6 p-0 h-100">
        <img src="{{ asset('assets/LOGIN.jpg') }}" alt="Certificate Wall" class="img-fluid w-100 h-100 object-fit-cover">
    </div>

    <!-- Form Section -->
    <div class="col-12 col-md-6 p-4">
        <h2 class="text-center mb-4 fw-bold">Log In</h2>
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control bg-secondary text-light border-0" id="email" placeholder="Enter your email" required>
            </div>

            <!-- Password Field with Eye Icon -->
            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <div class="d-flex align-items-center position-relative">
                    <input type="password" name="password" class="form-control bg-secondary text-light border-0 pe-5" id="password" placeholder="Enter your password" required>
                    <i id="togglePassword" class="bi bi-eye position-absolute" style="right: 15px; cursor: pointer;"></i>
                </div>
            </div>

            <!-- Forgot Password -->
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('password.request') }}" class="text-dark">Forgot Password?</a>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn  w-100 mb-3 text-white"style="background-color: #2D3E50;">Log In</button>
            
            <!-- Remember Me -->
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <!-- Sign Up -->
        </form>

       
       
    </div>
</div>

<!-- JavaScript for Password Toggle -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            this.classList.remove('bi-eye');
            this.classList.add('bi-eye-slash');
        } else {
            passwordField.type = 'password';
            this.classList.remove('bi-eye-slash');
            this.classList.add('bi-eye');
        }
    });
</script>

@endsection  