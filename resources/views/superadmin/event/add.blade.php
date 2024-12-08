@extends('layouts_dashboard.app')

@section('back')
<a href="javascript:history.back()" class="btn mb-3" style="background-color:#2D3E50;color:white;"><i class="fa-solid fa-backward"></i></a>
@endsection

@section('content')
<div class="card-header py-3 d-flex justify-content-start mb-3">
    <div class="col-lg-12 margin-tb d-flex justify-content-start">
        <div>
            <h3>Add Data Event</h3>
        </div>
    </div>
</div>

<form action="{{ route('superadmin.event.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="nama_event" class="form-label">Nama Event</label>
            <input type="text" name="nama_event" class="form-control" id="nama_event">
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email">
        </div>
    </div>

    <div class="mb-3">
        <label for="no_telephone" class="form-label">No Telephone</label>
        <input type="number" name="no_telp" class="form-control" id="no_telephone">
    </div>

    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label for="logo" class="form-label">Logo</label>
        <input type="file" class="form-control" name="logo" id="logo">
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="tanggal" class="form-label">Tanggal Pelaksanaan</label>
            <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ old('tanggal', $event->tanggal ?? '') }}">
        </div>
        <div class="col-md-6">
            <label for="ttd" class="form-label">Unggah Tanda Tangan</label>
            @if(!empty($event->ttd))
            <div class="mb-2">
                <img src="{{ asset('storage/' . $event->ttd) }}" alt="Tanda Tangan Saat Ini" class="img-thumbnail" style="max-width: 200px; max-height: 100px;">
            </div>
            @endif
            <input type="file" class="form-control" name="ttd" id="ttd" accept="image/*">
        </div>
    </div>     

    <button type="submit" class="btn" style="background-color:#2D3E50;color:white;">Submit</button>
</form>
@endsection
