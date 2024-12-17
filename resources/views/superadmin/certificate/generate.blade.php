@extends('layouts_dashboard.app')

@section('content')
<!-- Navigation -->
<nav class="mb-3">
    @if (Auth::user()->role === 'superadmin')
    <a href="{{ route('superadmin.home') }}" class="text-decoration-none text-primary">Dashboard</a> /
    <span class="text-secondary">Settings</span>
    @else
    <a href="{{ route('admin.home') }}" class="text-decoration-none text-primary">Dashboard</a> /
    <span class="text-secondary">Template</span>
    @endif
</nav>
<div class="my-2">
    <a href="{{ route('superadmin.certificate.createTemplate') }}" class="btn text-white" style="background-color:#2D3E50;">
        Add Template
    </a>
</div>

    <!-- Tabel data template certificate -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Template Certificate</h4>
        </div>
        <div class="card-body text-center">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Background Template</th>
                            <th class="text-center">Nama Template</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Background Template</th>
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
                            <td><img src="{{ asset('storage/' . $TC->preview) }}" alt="Logo Event" class="img-fluid"
                                    style="max-height: 100px;"></td>
                            <td>{{$TC->nama_template}}</td>
                            <td>
                                <a href="{{ route('superadmin.certificate.editTemplate', $TC->id ) }}"
                                    class="btn btn-sm btn-warning"> Edit</a>
                                <a href="{{ route('superadmin.certificate.showTemplate', $TC->id ) }}"
                                    class="btn btn-sm btn-success"> Preview</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
