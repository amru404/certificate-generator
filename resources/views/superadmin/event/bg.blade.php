@extends('layouts_dashboard.app')

@section('back')
<a href="javascript:history.back()" class="btn mb-3" style="background-color:#2D3E50;color:white;"><i class="fa-solid fa-backward"></i></a>
@endsection

@section('content')
<form action="{{route('remove.bg')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="image">Upload Image:</label>
    <input type="file" name="image" id="image" required>
    <button type="submit">Remove Background</button>
</form>
@endsection