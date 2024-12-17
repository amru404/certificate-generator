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
    <div class="row">
        <!-- Detail Event dan Cap Event -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header" style="background-color:#2D3E50;color:white;">
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
            <div class="card mb-4">
                <div class="card-header" style="background-color:#2D3E50;color:white;">
                    <h5 class="mb-0">Cap Event</h5>
                </div>
                <div class="card-body d-flex flex-wrap justify-content-center">
                    @if($detail_event->cap)
                        @foreach ($cap as $cap)
                            <img src="{{ asset('storage/' . $cap) }}" style="height:100px; margin:10px;" alt="Cap">
                        @endforeach
                    @else
                        <p>Cap tidak tersedia</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Logo Event dan TTD Event -->
        <div class="col-md-6">
            <div class="row">
                <!-- Logo Event -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header" style="background-color:#2D3E50;color:white;">
                            <h5 class="mb-0">Logo Event</h5>
                        </div>
                        <div class="card-body d-flex flex-wrap justify-content-center">
                            @if($detail_event->logo)
                                @foreach ($logo as $logo)
                                    <img src="{{ asset('storage/' . $logo) }}" style="height:50px; margin:10px;" alt="Logo">
                                @endforeach
                            @else
                                <p>Logo tidak tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tanda Tangan Event -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header" style="background-color:#2D3E50;color:white;">
                            <h5 class="mb-0">Tanda Tangan Event</h5>
                        </div>
                        <div class="card-body d-flex flex-wrap justify-content-center">
                            @if($detail_event->ttd)
                                @foreach ($ttd as $ttd)
                                    <img src="{{ asset('storage/' . $ttd) }}" style="height:100px; margin:10px;" alt="Tanda Tangan">
                                @endforeach
                            @else
                                <p>TTD tidak tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Daftar Peserta -->
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Daftar Peserta</h4>
      
        <a href="{{ route('superadmin.certificate.download_all_pdf', $detail_event->id) }}" class="btn btn-sm btn-primary"
        onclick="return confirm('Are you sure?')">Download All Certificate</a>
        
        <div class="btn-group">
            <a href="{{ route('superadmin.participant.import.create', $detail_event->id) }}" class="btn btn-sm"
            style="background-color:#2D3E50;color:white;">Add Participant</a>
            <a href="{{ route('superadmin.certificate.sendEmail', $detail_event->id) }}" class="btn btn-sm btn-primary" style="color:white;" onclick="return confirm('Are you sure?')">Send Email</a>
            <a href="{{ route('superadmin.participant.destroy_all', $detail_event->id) }}" class="btn btn-sm btn-danger"
                onclick="return confirm('Are you sure?')">Delete All Participants</a>
            <a href="{{ route('superadmin.certificate.destroy_all', $detail_event->id) }}" class="btn btn-sm btn-danger"
                onclick="return confirm('Are you sure?')">Delete All Certificate</a>
        </div>

        
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
            <thead>
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
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('superadmin.participant.edit', $p->id) }}"
                            class="btn btn-warning btn-sm mx-1"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="{{ route('superadmin.participant.destroy', $p->id) }}"
                            class="btn btn-danger btn-sm mx-1" onclick="return confirm('Are you sure?')"><i
                                class="fa-solid fa-trash"></i></a>
                        @if ($p->certificate)
                        <a href="{{ route('superadmin.certificate.pdf', $p->id) }}"
                            class="btn btn-success btn-sm mx-1">PDF</a>
                        @else
                        <button disabled class="btn btn-success btn-sm mx-1">PDF</button>
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
