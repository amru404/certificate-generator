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
    <a href="{{ route('admin.certificate.create', $detail_event->id) }}" class="btn"
        style="background-color:#2D3E50;color:white;">Generate Certificates</a>
</div>
<div class="card-body mt-4">
    <div class="row">
        <!-- Detail Event -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header" style="background-color:#2D3E50;color:white;">
                    <h5 class="mb-0">Informasi Event</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama Event:</strong> {{ $detail_event->nama_event }}</p>
                    <p><strong>Email:</strong> {{ $detail_event->email }}</p>
                    <p><strong>No. Telp:</strong> {{ $detail_event->no_telp }}</p>
                    <p><strong>Deskripsi:</strong></p>
                    <p>{{ $detail_event->deskripsi }}</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($detail_event->tanggal)->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Logo Event dan TTD Event -->
        <div class="col-md-6">
            <div class="row">
                <!-- Logo Event -->
                <div class="col-12 text-center">
                    <div class="card mb-4">
                        <div class="card-header" style="background-color:#2D3E50;color:white;">
                            <h5 class="mb-0">Logo Event</h5>
                        </div>
                        <div class="card-body">
                            @if($detail_event->logo)
                            <img src="{{ asset('storage/' . $detail_event->logo) }}" alt="Logo Event" class="img-fluid"
                                style="max-height: 200px;">
                            @else
                            <p>Logo tidak tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tanda Tangan Event -->
                <div class="col-12 text-center">
                    <div class="card mb-4">
                        <div class="card-header" style="background-color:#2D3E50;color:white;">
                            <h5 class="mb-0">Tanda Tangan Event</h5>
                        </div>
                        <div class="card-body">
                            @if($detail_event->ttd)
                            <img src="{{ asset('storage/' . $detail_event->ttd) }}" alt="Tanda Tangan Event"
                                class="img-fluid" style="max-height: 200px;">
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
        <div class="btn-group">
            <a href="{{ route('admin.participant.import.create', $detail_event->id) }}" class="btn btn-sm"
                style="background-color:#2D3E50;color:white;">Add Participant</a>
            <a href="{{ route('admin.participant.destroy_all', $detail_event->id) }}" class="btn btn-sm btn-danger"
                onclick="return confirm('Are you sure?')">Delete All Participants</a>
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
                        <a href="{{ route('admin.participant.edit', $p->id) }}" class="btn btn-warning btn-sm mx-1"><i
                                class="fa-regular fa-pen-to-square"></i></a>
                        <a href="{{ route('admin.participant.destroy', $p->id) }}" class="btn btn-danger btn-sm mx-1"
                            onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash"></i></a>
                        @if ($p->certificate)
                        <a href="{{ route('admin.certificate.pdf', $p->id) }}"
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
