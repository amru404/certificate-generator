@extends('layouts_dashboard.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Riwayat Sertifikat</h1>
    @if ($certificates->isEmpty())
        <div class="alert alert-warning">Belum ada riwayat sertifikat.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Peserta</th>
                    <th class="text-center">Event</th>
                    <th class="text-center">uid</th>
                    <th class="text-center">Template</th>
                    <th class="text-center">Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($certificates as $index => $certificate)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $certificate->participant->nama ?? 'Tidak Ada' }}</td>
                    <td>{{  $certificate->event->nama_event?? 'Tidak Ada' }}</td>
                    <td>{{ $certificate->id }}</td>
                    <td>{{ $certificate->certificate_templates->preview ?? 'Tidak Ada Template' }}</td>
                    <td>{{ $certificate->created_at->format('d F Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
