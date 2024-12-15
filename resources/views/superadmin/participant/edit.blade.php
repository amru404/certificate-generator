@extends('layouts_dashboard.app')

@section('back')
<a href="javascript:history.back()" class="btn text-white mb-3" style="background-color:#2D3E50;"><i
        class="fa-solid fa-backward"></i></a>
@endsection

@section('content')
<div class="card-header py-3 d-flex justify-content-start mb-3">
    <div class="row">

        <div class="col-lg-12 margin-tb d-flex justify-content-start">
            <div class="pull-left">
                <h3>Edit Participant</h3>
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


<form action="{{route('superadmin.participant.update', $participant->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')

    <input type="hidden" name="user_id" value="{{ $participant->user_id }}">

    <div class="form-row">
        <div class="form-group mt-3">
            <label for="nama">Nama participant</label>
            <input type="text" name="nama" class="form-control" id="nama" value="{{ $participant->nama }}">
        </div>

        <div class="form-group mt-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ $participant->email }}">
        </div>

    </div>
    <div class="form-group mt-3">
        <label for="no_telephone">No Telephone</label>
        <input type="number" name="no_telp" class="form-control" id="no_telephone" value="{{ $participant->no_telp }}">
    </div>

    <button type="submit" class="btn mt-3 text-white" style="background-color:#2D3E50;">Submit</button>
</form>
@endsection('content')
