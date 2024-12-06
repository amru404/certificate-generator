@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row vh-100">
        <!-- Left Image Section -->
        <div class="col-lg-6 d-none d-lg-block p-0">
            <img src="https://via.placeholder.com/600x800" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Left Image">
        </div>

        <!-- Right Form Section -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="w-75">
                <h3 class="text-center mb-4">Create New Password</h3>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <!-- New Password Field -->
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input id="new_password" type="password" class="form-control" name="new_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                <i class="bi bi-eye-slash" id="toggle_new_password_icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input id="confirm_password" type="password" class="form-control" name="confirm_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                <i class="bi bi-eye-slash" id="toggle_confirm_password_icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Instruction -->
                    <div class="mb-3 text-muted">
                        Your new password must be unique from those previously used.
                    </div>

                    <!-- Reset Password Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to toggle password visibility
    function togglePassword(fieldId) {
        const inputField = document.getElementById(fieldId);
        const icon = document.getElementById(`toggle_${fieldId}_icon`);

        if (inputField.type === 'password') {
            inputField.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            inputField.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    }
</script>
@endsection
