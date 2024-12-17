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

<form action="{{ route('superadmin.event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- HTTP PUT for update -->

        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nama_event" class="form-label">Nama Event</label>
                <input type="text" name="nama_event" class="form-control" id="nama_event" value="{{ old('nama_event', $event->nama_event) }}" required>
                @error('nama_event')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $event->email) }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="no_telephone" class="form-label">No Telephone</label>
                <input type="number" name="no_telp" class="form-control" id="no_telephone" value="{{ old('no_telp', $event->no_telp) }}" required>
                @error('no_telp')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="tanggal" class="form-label">Tanggal Pelaksanaan</label>
                <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ old('tanggal', $event->tanggal) }}" required>
                @error('tanggal')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" required>{{ old('deskripsi', $event->deskripsi) }}</textarea>
            @error('deskripsi')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Display existing logos if any -->
        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" class="form-control" name="logo[]" id="logo" accept="image/*" multiple>
            <small class="fw-light">jpeg,png,jpg. max 2mb/img</small>
            @if($event->logo)
                <div class="mt-2">
                    @foreach(json_decode($event->logo) as $logo)
                        @if(is_string($logo))
                            <img src="{{ asset('storage/' . $logo) }}" width="100" alt="Logo">
                        @endif
                    @endforeach
                </div>
            @endif
            @error('logo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Display existing signatures if any -->
        <div class="mb-3">
            <label for="ttd" class="form-label">Tanda Tangan</label>
            <input type="file" class="form-control" name="ttd[]" id="ttd" accept="image/*" multiple>
            <small class="fw-light">jpeg,png,jpg. max 2mb/img</small>
            @if($event->ttd)
                <div class="mt-2">
                    @foreach(json_decode($event->ttd) as $ttd)
                        @if(is_string($ttd))
                            <img src="{{ asset('storage/' . $ttd) }}" width="100" alt="Tanda Tangan">
                        @endif
                    @endforeach
                </div>
            @endif
            @error('ttd')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Display existing caps if any -->
        <div class="mb-3">
            <label for="cap" class="form-label">Cap</label>
            <input type="file" class="form-control" name="cap[]" id="cap" accept="image/*" multiple>
            <small class="fw-light">jpeg,png,jpg. max 2mb/img</small>
            @if($event->cap)
                <div class="mt-2">
                    @foreach(json_decode($event->cap) as $cap)
                        @if(is_string($cap))
                            <img src="{{ asset('storage/' . $cap) }}" width="100" alt="Cap">
                        @endif
                    @endforeach
                </div>
            @endif
            @error('cap')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn" style="background-color:#2D3E50;color:white;">Update</button>
    </form>
@endsection
