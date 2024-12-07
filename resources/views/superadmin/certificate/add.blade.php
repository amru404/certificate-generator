@extends('layouts_dashboard.app')


@section('back')
<a href="javascript:history.back()" class="btn mb-3" style="background-color:#2D3E50;color:white;"><i
        class="fa-solid fa-backward"></i></a>
@endsection


@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Pilih Template Sertifikat Anda</h2>

    <div id="loader" class="loader" style="display: none;"></div>

    <div class="row justify-content-center">
        @if($templates->isEmpty())
        <p class="text-center">Tidak ada template tersedia.</p>
        @else
        @foreach ($templates as $template)
        <div class="col-md-4 mb-4">
        <div class="card">
                    <form id="certificate-form" class="certificate-form" action="{{ route('superadmin.certificate.store', $detail_event->id) }}">
                    @csrf
                    <input type="hidden" value="{{$template->name}}" name="name">
                    <input type="hidden" value="{{$template->preview}}" name="preview">
                    <input type="hidden" value="{{$template->id}}" name="id">
                    <img src="{{ asset('storage/'.$template->preview) }}"  class="card-img-top" alt="Template">
                    <div class="card-body text-center">
                        <h5 class="card-title">Template {{ $template->name }}</h5>
                        <button type="submit" class="btn" style="background-color:#2D3E50;color:white;" onclick="return confirm('Yakin ingin memilih template ini?')">Select</button>
                    </div>
                  </form>
                </div>

        </div>
        @endforeach
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll(
        '.certificate-form');
        const loader = document.querySelector('#loader');

        forms.forEach(function (form) {
            form.addEventListener('submit', function () {
                loader.style.display = 'grid';
            });
        });
    });

</script>
@endsection
