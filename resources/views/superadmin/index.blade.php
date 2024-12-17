@extends('layouts_dashboard.app')

@section('content')
<style>
    /* Card Animasi */
.card-animate {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-animate:hover {
    transform: translateY(-10px); /* Melayang ke atas */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.icon-animate {
    transition: transform 0.3s ease;
}

.card-animate:hover .icon-animate {
    transform: scale(1.3); /* Membesarkan ikon */
    color: #2C3E50; /* Mengganti warna ikon */
}

/* Progress Bar Animasi */
.progress-bar-animated {
    width: 0;
    animation: progressAnimation 2s forwards;
}

@keyframes progressAnimation {
    from {
        width: 0;
    }
    to {
        width: 50%;
    }
}

/* Border Warna */
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}

.border-left-success {
    border-left: 4px solid #1cc88a !important;
}

.border-left-info {
    border-left: 4px solid #36b9cc !important;
}

/* Font dan Warna */
.text-primary {
    color: #4e73df !important;
}

.text-success {
    color: #1cc88a !important;
}

.text-info {
    color: #36b9cc !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-400 {
    color: #d1d3e2 !important;
}

</style>
<!-- ini navbar dan date realtime ygy -->
<nav class="mb-3 d-flex justify-content-between align-items-center">
    <div data-aos="fade-down"data-aos-duration="1500">
        @if (Auth::user()->role === 'superadmin')
            <a href="{{ route('superadmin.home') }}" class="text-decoration-none text-primary">Dashboard</a> /
            <span class="text-secondary">Dashboard</span>
        @else
            <a href="{{ route('admin.home') }}" class="text-decoration-none text-primary">Dashboard</a> /
            <span class="text-secondary">Dashboard</span>
        @endif
    </div>

    <div class="d-flex align-items-center shadow-sm rounded bg-white px-2 py-1" data-aos="fade-down"data-aos-duration="1500">
        <i class="fas fa-calendar-alt text-secondary me-2" style="font-size: 1rem;"></i>
        <div id="current-date" class="text-secondary fw-bold small">
            Loading...
        </div>
    </div>
</nav>

<!-- konten-->
<div class="row mt-5">
    <!-- Total Event Card -->
    <div class="col-xl-4 col-md-4 mb-4 mt-3" data-aos="fade-down" data-aos-duration="1500">
        <div class="card card-animate border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Event</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$event}}</div>
                <canvas id="eventChart" style="height: 150px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Total User Card -->
    <div class="col-xl-4 col-md-4 mb-4 mt-3" data-aos="flip-up" data-aos-duration="1500">
        <div class="card card-animate border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total User</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$user}}</div>
                <canvas id="userChart" style="height: 150px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Total Certificate Card -->
    <div class="col-xl-4 col-md-4 mb-4 mt-3" data-aos="fade-up-left" data-aos-duration="1500">
        <div class="card card-animate border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Certificate</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$participant}}</div>
                <canvas id="certificateChart" style="height: 150px;"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection
