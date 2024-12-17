@extends('layouts_dashboard.app')

@section('back')
<a href="javascript:history.back()" class="btn text-white mb-3" style="background-color:#2D3E50;"><i
        class="fa-solid fa-backward"></i></a>
@endsection


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

<div class="card-header">
    <h3>Detail Event: {{ $detail_event->nama_event }}</h3>
    <a href="{{ route('superadmin.certificate.create', $detail_event->id) }}" class="btn" style="background-color:#2D3E50;color:white;">
        Generate Certificates
    </a>
</div>

<div class="card-body mt-4">
    <div class="row g-4">
        <!-- Informasi Event dan Cap Event -->
        <div class="col-md-6">
            <!-- Informasi Event -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Informasi Event</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama Event:</strong> {{ $detail_event->nama_event }}</p>
                    <p><strong>Nomor Certificate:</strong> {{ $detail_event->nomor_certificate }}</p>
                    <p><strong>Email:</strong> {{ $detail_event->email }}</p>
                    <p><strong>No. Telp:</strong> {{ $detail_event->no_telp }}</p>
                    <p><strong>Deskripsi:</strong></p>
                    <p>{{ $detail_event->deskripsi }}</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($detail_event->tanggal)->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Cap Event -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Cap Event</h5>
                </div>
                <div class="card-body d-flex flex-wrap justify-content-center gap-3">
                    @if($detail_event->cap)
                        @foreach ($cap as $cap)
                            <img src="{{ asset('storage/' . $cap) }}" class="rounded" style="height:100px; object-fit:cover;" alt="Cap">
                        @endforeach
                    @else
                        <p class="text-muted">Cap tidak tersedia</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Logo Event dan TTD Event -->
        <div class="col-md-6">
            <div class="row g-4">
                <!-- Logo Event -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Logo Event</h5>
                        </div>
                        <div class="card-body d-flex flex-wrap justify-content-center gap-3">
                            @if($detail_event->logo)
                                @foreach ($logo as $logo)
                                    <img src="{{ asset('storage/' . $logo) }}" class="rounded" style="height:70px; object-fit:contain;" alt="Logo">
                                @endforeach
                            @else
                                <p class="text-muted">Logo tidak tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tanda Tangan Event -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Tanda Tangan Event</h5>
                        </div>
                        <div class="card-body d-flex flex-wrap justify-content-center gap-3">
                            @if($detail_event->ttd)
                                @foreach ($ttd as $ttd)
                                    <img src="{{ asset('storage/' . $ttd) }}" class="rounded" style="height:100px; object-fit:contain;" alt="Tanda Tangan">
                                @endforeach
                            @else
                                <p class="text-muted">TTD tidak tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Daftar Peserta -->
<div class="card mt-4 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-light">
        <h5 class="mb-0">Daftar Peserta</h5>

        <!-- Wrapper tombol -->
        <div class="d-flex flex-wrap gap-2">
            <!-- Tombol Download Certificate -->
            <a href="{{ route('superadmin.certificate.download_all_pdf', $detail_event->id) }}" 
               class="btn btn-sm btn-outline-primary shadow-sm"
               onclick="return confirm('Are you sure?')">
                <i class="fa-solid fa-download me-1"></i> Download All Certificate
            </a>

            <!-- Grup Tombol 1 -->
            <div class="btn-group">
                <a href="{{ route('superadmin.participant.import.create', $detail_event->id) }}" 
                   class="btn btn-sm btn-outline-dark shadow-sm">
                    <i class="fa-solid fa-user-plus me-1"></i> Add Participant
                </a>
                <a href="{{ route('superadmin.certificate.sendEmail', $detail_event->id) }}" 
                   class="btn btn-sm btn-outline-primary shadow-sm" 
                   onclick="return confirm('Are you sure?')">
                    <i class="fa-solid fa-envelope me-1"></i> Send Email
                </a>
            </div>

            <!-- Grup Tombol 2 -->
            <div class="btn-group">
                <a href="{{ route('superadmin.participant.destroy_all', $detail_event->id) }}" 
                   class="btn btn-sm btn-outline-danger shadow-sm"
                   onclick="return confirm('Are you sure?')">
                    <i class="fa-solid fa-user-xmark me-1"></i> Delete All Participants
                </a>
                <a href="{{ route('superadmin.certificate.destroy_all', $detail_event->id) }}" 
                   class="btn btn-sm btn-outline-danger shadow-sm"
                   onclick="return confirm('Are you sure?')">
                    <i class="fa-solid fa-trash-can me-1"></i> Delete All Certificate
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participant as $key => $p)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->no_telp }}</td>
                    <td class="d-flex justify-content-center gap-2">
                        <a href="{{ route('superadmin.participant.edit', $p->id) }}"
                            class="btn btn-warning btn-sm shadow-sm"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="{{ route('superadmin.participant.destroy', $p->id) }}"
                            class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Are you sure?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                        @if ($p->certificate)
                        <a href="{{ route('superadmin.certificate.pdf', $p->id) }}"
                            class="btn btn-success btn-sm shadow-sm">PDF</a>
                        @else
                        <button disabled class="btn btn-success btn-sm shadow-sm">PDF</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
