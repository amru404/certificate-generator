@extends('layouts_dashboard.app')

@section('back')
<a href="javascript:history.back()" class="btn text-white mb-3" style="background-color:#2D3E50;"><i
        class="fa-solid fa-backward"></i></a>
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

<div class="text-center mb-3">
    <h5 style="font-size: 24px; font-weight: bold; color: #333;">Live Preview</h5>
</div>

<div class="certificate-container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div id="certificate-preview"
        style="position: relative; display: inline-block; border: 2px solid #ddd; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); border-radius: 10px; overflow: hidden; background-color: #f9f9f9; width: 1122px; height: 793px; background-color: #fff; margin: 0 auto;">

        <!-- Preview Image -->
        <img id="preview-image" src="{{ isset($template->preview) ? asset('storage/' . $template->preview) : '' }}"
            alt="Live Preview" style="display: block; width: 100%; height: 100%; object-fit: contain;">

        <!-- Nama -->
        <!-- Nama -->
        <div id="preview-nama"
            style="position:absolute; top:40%; left:50%; transform:translate(-50%, -50%); font-size:24px; font-weight:bold; color:#333; text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);">
            amru abdurrahman azzam
        </div>


        <!-- Deskripsi -->
        <div id="preview-deskripsi"
            style="position:absolute; top:55%; left:50%; font-size:18px; color:#555; text-align:center; font-weight:500;z-index: 1; width:500px;">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aut dolorem culpa explicabo odio! Adipisci nihil
            omnis quidem nulla inventore natus provident sint officiis eum aliquid.
        </div>


        <!-- Tanggal -->
        <div id="preview-tanggal"
            style="position:absolute; bottom:20%; left:50%; transform:translateX(-50%); font-size:16px; color:#777; font-style:italic;">
            2024-12-11
        </div>

        <!-- UID -->
        <div id="preview-uid"
            style="position:absolute; bottom:15%; left:50%; transform:translateX(-50%); font-size:14px; color:#555;">
            UID: CRF-aeorlv
        </div>

        <!-- Signature -->
        <img id="signature-image" src="{{ asset('ttd/ttd.png') }}" alt="Signature"
            style="position:absolute; bottom:5%; left:50%; transform:translateX(-50%); width:100px; height:auto;">
    </div>
</div>

<!-- Form untuk tambah template -->
<div class="card mt-4">
    <div class="card-header">
        <h6>Add Template Certificate</h6>
    </div>
    <form action="{{ route('superadmin.certificate.storeTemplate') }}" method="POST" enctype="multipart/form-data"
        class="m-3">
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
                <input type="text" class="form-control" id="nama" name="nama" required placeholder="margin nama"
                    value="0px 0px 0px 0px">
            </div>
            <div class="col-4">
                <label for="deskripsi" class="form-label">Margin Deskripsi</label>
                <input type="text" class="form-control" id="deskripsi" name="deskripsi" required
                    placeholder="margin deskripsi" value="0px 0px 0px 0px">
            </div>
            <div class="col-4">
                <label for="tanggal" class="form-label">Margin Tanggal</label>
                <input type="text" class="form-control" id="tanggal" name="tanggal" required
                    placeholder="margin tanggal" value="0px 0px 0px 0px">
            </div>
        </div>

        <div class="row mt-4 mb-4">
            <div class="col-6">
                <label for="ttd" class="form-label">Margin Ttd</label>
                <input type="text" class="form-control" id="ttd" name="ttd" required placeholder="margin ttd"
                    value="0px 0px 0px 0px">
            </div>
            <div class="col-6">
                <label for="uid" class="form-label">Margin UID</label>
                <input type="text" class="form-control" id="uid" name="uid" required placeholder="margin uid"
                    value="0px 0px 0px 0px">
            </div>
        </div>

        <button type="submit" class="btn text-white" style="background-color:#2D3E50;">Submit</button>
    </form>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const namaInput = document.getElementById("nama");
        const deskripsiInput = document.getElementById("deskripsi");
        const tanggalInput = document.getElementById("tanggal");
        const imageInput = document.getElementById("preview");
        const namaPreview = document.getElementById("preview-nama");
        const deskripsiPreview = document.getElementById("preview-deskripsi");
        const tanggalPreview = document.getElementById("preview-tanggal");
        const imagePreview = document.getElementById("preview-image");

        // Update margin teks berdasarkan input
        namaInput.addEventListener("input", () => {
            namaPreview.style.margin = namaInput.value || "0px 0px 0px 0px";
        });

        deskripsiInput.addEventListener("input", () => {
            deskripsiPreview.style.margin = deskripsiInput.value || "0px 0px 0px 0px";
        });

        tanggalInput.addEventListener("input", () => {
            tanggalPreview.style.margin = tanggalInput.value || "0px 0px 0px 0px";
        });

        // Event listener untuk preview gambar
        imageInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                console.error("File gambar tidak dipilih!");
                imagePreview.style.display = "none";
            }
        });

        $(document).ready(function () {
            const elements = [{
                    id: "#preview-nama",
                    input: "#nama"
                },
                {
                    id: "#preview-deskripsi",
                    input: "#deskripsi"
                },
                {
                    id: "#preview-tanggal",
                    input: "#tanggal"
                },
                {
                    id: "#signature-image",
                    input: "#ttd"
                },
                {
                    id: "#preview-uid",
                    input: "#uid"
                },
            ];

            elements.forEach((el) => {
                $(el.id).draggable({
                    containment: "#certificate-preview",
                    scroll: false,
                    stop: function (event, ui) {
                        const container = $("#certificate-preview");
                        const offset = ui.position;

                        const marginTop = offset.top;
                        const marginLeft = offset.left;

                        $(el.input).val(`${marginTop}px 0 0 ${marginLeft}px`);
                    },
                });
            });
        });
    });

</script>

@endsection
