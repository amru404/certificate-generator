@extends('layouts_dashboard.app')

@section('back')
<a href="javascript:history.back()" class="btn mb-3 btn-sm"style="background-color:#2D3E50;color:white;"><i class="fa-solid fa-backward"></i></a>
<a href="{{route('superadmin.participant.export_template')}}" class="btn btn-sm btn-dark mb-3"> Template <i class="fa-solid fa-file-excel" style="color: #63E6BE;"></i></a>
@endsection



@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form action="{{ route('superadmin.participant.import.store') }}" method="POST" enctype="multipart/form-data">
    @csrf   
    <input type="hidden" value="{{$eventID}}" name="event_id">
    <input type="file" name="file" class="form-control" required>
    <br>
    <button class="btn btn-success">Import User Data</button>
</form>
@endsection('content')
