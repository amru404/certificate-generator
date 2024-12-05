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

<form action="{{ route('admin.certificate.storeTemplate') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

       
        <div class="mb-3">
            <label for="preview" class="form-label">Image Template</label>
            <input type="file" class="form-control" id="preview" name="preview" required>
        </div>

        
        <button type="submit" class="btn text-white" style="background-color:#2D3E50;">Submit</button>
    </form>


@endsection('content')
