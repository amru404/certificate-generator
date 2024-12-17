@extends('layouts_dashboard.app')

@section('back')
<a href="javascript:history.back()" class="btn mb-3" style="background-color:#2D3E50;color:white;"><i class="fa-solid fa-backward"></i></a>
@endsection

@section('content')

@if($errors->has('logo'))
    <div class="alert alert-danger">
        {{ $errors->first('logo') }}
    </div>
@endif

@if($errors->has('ttd'))
    <div class="alert alert-danger">
        {{ $errors->first('ttd') }}
    </div>
@endif


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
            <input type="text" name="nama_event" class="form-control" id="nama_event" value="{{ old('nama_event') }}" required>
            @error('nama_event')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="no_telephone" class="form-label">No Telephone</label>
            <input type="number" name="no_telp" class="form-control" id="no_telephone" value="{{ old('no_telp') }}" required>
            @error('no_telp')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="tanggal" class="form-label">Tanggal Pelaksanaan</label>
            <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ old('tanggal') }}" required>
            @error('tanggal')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    
    <div class="mb-3">
        <label for="nomor_certificate" class="form-label">Nomor Certificate</label>
        <input type="text" name="nomor_certificate" class="form-control" id="nomor_certificate" required>
    </div>

    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
        @error('deskripsi')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="logo" class="form-label">Logo</label>
        <input type="file" class="form-control" name="logo[]" id="logo" accept="image/*" multiple required>
        <small class="fw-light">jpeg,png,jpg. max 2mb/img</small>
        @error('logo')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="ttd" class="form-label">Tanda Tangan</label>
        <input type="file" class="form-control" name="ttd[]" id="ttd" accept="image/*" multiple required>
        <small class="fw-light">jpeg,png,jpg. max 2 img. 2mb/ img</small>
        @error('ttd')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="cap" class="form-label">Cap</label>
        <input type="file" class="form-control" name="cap[]" id="cap" accept="image/*" multiple required>
        <small class="fw-light">jpeg,png,jpg. max 2 img. 2mb/ img</small>
        @error('cap')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>


    <button type="submit" class="btn" style="background-color:#2D3E50;color:white;">Submit</button>
</form>


@endsection
