@extends('layouts_dashboard.app')

@section('back')
<a href="javascript:history.back()" class="btn text-white mb-3" style="background-color:#2D3E50;"><i class="fa-solid fa-backward"></i></a>
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


<div class="card">
    <div class="card-header">
        <h6>Add Template Certificate</h6>
    </div>
<form action="{{ route('superadmin.certificate.storeTemplate') }}" method="POST" enctype="multipart/form-data" class="m-3">
        @csrf

        <div class="mb-3">
            <label for="nama_template" class="form-label">Nama Template</label>
            <input type="text" class="form-control" id="nama_template" name="nama_template" required>
        </div>

       
        <div class="mb-3">
            <label for="preview" class="form-label">Image Template</label>
            <input type="file" class="form-control" id="preview" name="preview" required>
        </div>

        <div class="row mt-4">
            <div class="col-4">
                    <label for="nama" class="form-label">Margin Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required placeholder="margin nama" value="0px 0px 0px 0px">
            </div>
            <div class="col-4">
                    <label for="deskripsi" class="form-label">Margin Deskripsi</label>
            <input type="text" class="form-control" id="deskripsi" name="deskripsi" required placeholder="margin deskripsi"  value="0px 0px 0px 0px">
            </div>
            <div class="col-4">
                    <label for="tanggal" class="form-label">Margin Tanggal</label>
            <input type="text" class="form-control" id="tanggal" name="tanggal" required placeholder="margin tanggal"  value="0px 0px 0px 0px">
            </div>
        </div>

        <div class="row mt-4 mb-4">
            <div class="col-6">
            <label for="ttd" class="form-label">Margin Ttd</label>
            <input type="text" class="form-control" id="ttd" name="ttd" required placeholder="margin ttd"  value="0px 0px 0px 0px">
            </div>
            <div class="col-6">
            <label for="uid" class="form-label">Margin UID</label>
            <input type="text" class="form-control" id="uid" name="uid" required placeholder="margin uid"  value="0px 0px 0px 0px">
            </div>
        </div>
        
        <button type="submit" class="btn text-white" style="background-color:#2D3E50;">Submit</button>
    </form>

</div>


<div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Template Certificate</h4>
            <div class="btn-group">
            </div>
        </div>
        <div class="card-body text-center">
            <table  class="table table-bordered table-striped text-center" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Preview Template</th>
                    <th class="text-center">Nama Template</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Preview Template</th>
                    <th class="text-center">Nama Template</th>
                    <th class="text-center">Action</th>
                </tr>
            </tfoot>

            <?php $number = 1; ?>

            <tbody>
                @foreach ($templateCertif as $TC)
                <tr>
                    <td>{{ $number }}</td>
                    <?php $number++; ?>
                    <td><img src="{{ asset('storage/' . $TC->preview) }}" alt="Logo Event" class="img-fluid" style="max-height: 100px;"></td>
                    <td>{{$TC->nama_template}}</td> 
                    <td>
                        <a href="{{ route('superadmin.certificate.editTemplate', $TC->id ) }}" class="btn btn-sm btn-warning"> Edit</a>
                        <a href="{{ route('superadmin.certificate.showTemplate', $TC->id ) }}" class="btn btn-sm btn-success"> Preview</a>
                    </td> 
                </tr>
                @endforeach

            </tbody>
            </table>
        </div>
    </div>

@endsection('content')
