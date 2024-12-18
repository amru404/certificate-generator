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

        <button type="submit" class="btn text-white" style="background-color:#2D3E50;">Update</button>
    </form>

    <!-- Live Preview -->
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
            
        </div>


        <!-- Deskripsi -->
        <div id="preview-deskripsi"
            style="position:absolute; top:55%; left:50%; font-size:18px; color:#555; text-align:center; font-weight:500;z-index: 1; width:500px;">
            
        </div>


        <!-- Tanggal -->
        <div id="preview-tanggal"
            style="position:absolute; bottom:20%; left:50%; transform:translateX(-50%); font-size:16px; color:#777; font-style:italic;">
            
        </div>

        <!-- UID -->
        <div id="preview-uid"
            style="position:absolute; bottom:15%; left:50%; transform:translateX(-50%); font-size:14px; color:#555;">
            
        </div>

        <!-- Signature -->
        <img id="signature-image" src="{{ asset('ttd/ttd.png') }}" 
        alt="Signature"
            style="position:absolute; bottom:5%; left:50%; transform:translateX(-50%); width:100px; height:auto;">
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

        // Draggable functionality for text fields
        $(document).ready(function () {
            const elements = [
                { id: "#preview-nama", input: "#nama" },
                { id: "#preview-deskripsi", input: "#deskripsi" },
                { id: "#preview-tanggal", input: "#tanggal" },
                { id: "#signature-image", input: "#ttd" },
                { id: "#preview-uid", input: "#uid" },
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
