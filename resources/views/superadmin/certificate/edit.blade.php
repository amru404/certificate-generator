@extends('layouts_dashboard.app')

@section('content')
<div class="container mt-4">
    <h1>Edit Certificate Template</h1>
    <form action="{{ route('superadmin.certificate.updateTemplate', $template->id) }}" method="POST" enctype="multipart/form-data" class="m-3">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="nama_template" class="form-label">Nama Template</label>
        <input type="text" class="form-control" id="nama_template" name="nama_template" value="{{ $template->nama_template }}" required>
    </div>

    <div class="mb-3">
        <label for="preview" class="form-label">Image Template</label>
        <input type="file" class="form-control" id="preview" name="preview">
        @if($template->preview)
            <img src="{{ asset('storage/' . $template->preview) }}" alt="Preview" class="img-thumbnail mt-2" style="max-height: 150px;">
        @endif
    </div>

    <div class="row mt-4">
        <div class="col-4">
        <label for="nama" class="form-label">Margin Nama</label>

            <input type="text" class="form-control" id="nama" name="nama" value="{{ $template->nama }}" required placeholder="margin nama">
        </div>
        <div class="col-4">
        <label for="nama" class="form-label">Margin Deskripsi</label>

            <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ $template->deskripsi }}" required placeholder="margin deskripsi">
        </div>
        <div class="col-4">
        <label for="nama" class="form-label">Margin Tanggal</label>

            <input type="text" class="form-control" id="tanggal" name="tanggal" value="{{ $template->tanggal }}" required placeholder="margin tanggal">
        </div>
    </div>

    <div class="row mt-4 mb-4">
        <div class="col-6">
        <label for="nama" class="form-label">Margin ttd</label>

            <input type="text" class="form-control" id="ttd" name="ttd" value="{{ $template->ttd }}" required placeholder="margin ttd">
        </div>
        <div class="col-6">
        <label for="nama" class="form-label">Margin UID</label>

            <input type="text" class="form-control" id="uid" name="uid" value="{{ $template->uid }}" required placeholder="margin uid">
        </div>
    </div>

    <button type="submit" class="btn text-white" style="background-color:#2D3E50;">Update</button>
</form>

</div>
@endsection
