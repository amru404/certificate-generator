@extends('layouts_dashboard.app')

@section('back')
<a href="javascript:history.back()" class="btn text-white mb-3" style="background-color:#2D3E50;"><i class="fa-solid fa-backward"></i></a>
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
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-start">
            <div>
                <h3>Edit Product</h3>
            </div>
        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<form action="{{ route('admin.event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')

    <input type="hidden" name="user_id" value="{{ $event->user_id }}">

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="nama_event" class="form-label">Nama Event</label>
            <input type="text" name="nama_event" class="form-control" id="nama_event" value="{{ $event->nama_event }}">
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ $event->email }}">
        </div>
    </div>

    <div class="mb-3">
        <label for="no_telephone" class="form-label">No Telephone</label>
        <input type="number" name="no_telp" class="form-control" id="no_telephone" value="{{ $event->no_telp }}">
    </div>

    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3">{{ $event->deskripsi }}</textarea>
    </div>

    <div class="mb-3">
        <label for="logo" class="form-label">Input Logo</label>
        @if($event->logo)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $event->logo) }}" alt="Current Logo" width="100">
        </div>
        @endif
        <input type="file" class="form-control" name="logo" id="logo">
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="tanggal" class="form-label">Tanggal Pelaksanaan</label>
            <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ $event->tanggal }}">
        </div>
        <div class="col-md-6">
            <label for="ttd" class="form-label">Unggah Tanda Tangan</label>
            @if(!empty($event->ttd))
            <div class="mb-2">
                <img src="{{ asset('storage/' . $event->ttd) }}" alt="Tanda Tangan Saat Ini" class="img-thumbnail" style="max-width: 200px; max-height: 100px;" accept="image/*">
            </div>
            @endif
            <input type="file" class="form-control" name="ttd" id="ttd" accept="image/*">
        </div>
    </div>
    <button type="submit" class="btn" style="background-color:#2D3E50;color:white;">Submit</button>
</form>
@endsection
