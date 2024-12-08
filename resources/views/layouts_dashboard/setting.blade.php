@extends('layouts_dashboard.app')

@section('title', 'Settings')

@section('content')
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


<div class="container ">
    <!-- Navigation -->
    <nav class="mb-3">
        @if (Auth::user()->role === 'superadmin')
        <a href="{{ route('superadmin.home') }}" class="text-decoration-none text-primary">Dashboard</a> /
        <span class="text-secondary">Settings</span>
        @else
        <a href="{{ route('admin.home') }}" class="text-decoration-none text-primary">Dashboard</a> /
        <span class="text-secondary">Settings</span>
        @endif

    </nav>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- judul Section -->
        <div>
            <h3>Settings</h3>
            <p class="text-muted m-0">Customize the app to suit your needs.</p>
        </div>
        <!-- Buttons -->
        <div class="d-flex">
        </div>
    </div>

    <!-- Main Container -->
    <div class="card shadow-sm">
        <div class="card-body d-flex">
            <!-- Sidebar -->
            <div class="me-4 border-end pe-3">
                <ul class="list-group" id="sidebarMenu">
                    <li class="list-group-item active" onclick="setActive(this)">
                        <i class="bi bi-people me-2"></i> General Information
                    </li>
                    <li class="list-group-item" onclick="setActive(this)">
                        <i class="bi bi-key me-2"></i> Change Password
                    </li>
                    <li class="list-group-item" onclick="setActive(this)">
                        <i class="bi bi-bell me-2"></i> Notification
                    </li>
                    <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#logoutModal"
                        onclick="setActive(this)">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </li>
                </ul>
            </div>
            <!-- Content -->
            <div class="flex-grow-1">
                <!-- Card -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center">General Information</h5>
                        <p class="text-muted text-center">Fill out your form correctly</p>
                        <form action="{{route('setting.updateUser', Auth::user()->id) }}" method="post">
                            @csrf
                            {{-- <!-- Profile Picture -->
                            <div class="mb-3 text-center">
                                <h5 class="mb-4">Profile Picture</h5>
                                <img src="https://via.placeholder.com/100" id="profilePicture"
                                    class="rounded-circle mb-3" alt="Profile Picture">
                                <div>
                                    <label for="uploadPhoto" class="btn btn-sm"
                                        style="background-color:#2D3E50; color:white">Upload Photo</label>
                                    <input type="file" id="uploadPhoto" class="d-none" accept="image/*"
                                        onchange="uploadPhoto(event)">

                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                        onclick="deletePhoto()">Delete</button>
                                </div>
                            </div> --}}
                            <!-- Detailed Information -->
                            <h6>Detailed Information</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Profile Name</label>
                                    <input type="text" class="form-control" id="name" value="{{$user->name}}"
                                        name="name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" value="{{$user->email}}"
                                        name="email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="no_telp" class="form-label">Phone Number</label>
                                    <input type="number" class="form-control" id="no_telp" value="{{$user->no_telp}}"
                                        name="no_telp">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="" disabled {{ $user->gender == null ? 'selected' : '' }}>Select
                                            Gender</option>
                                        <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Address -->
                            <h6>Address</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" value="{{$user->country}}"
                                        name="country">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" value="{{$user->city}}"
                                        name="city">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="postcode" class="form-label">Postcode</label>
                                    <input type="text" class="form-control" id="postcode" value="{{$user->post_code}}"
                                        name="post_code">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" id="state" value="{{$user->state}}"
                                        name="state">
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-secondary me-2">Cancel</button>
                            <button type="submit" class="btn" style="background-color:#2D3E50; color:white">Save
                                Change</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
