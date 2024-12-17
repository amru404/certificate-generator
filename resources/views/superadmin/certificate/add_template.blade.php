@extends('layouts_dashboard.app')
@section('content')

<div class="container mt-4">
    <h1>Create Certificate Template</h1>

    <form id="certificateForm" action="{{ route('superadmin.certificate.storeTemplate') }}" method="POST" enctype="multipart/form-data" class="m-3">
        @csrf

        <div class="mb-3">
            <label for="nama_template" class="form-label">Nama Template</label>
            <input type="text" class="form-control" id="nama_template" name="nama_template" required placeholder="Masukkan nama template">
        </div>

        <div class="mb-3">
            <label for="preview" class="form-label">Image Template</label>
            <input type="file" class="form-control" id="preview" name="preview" required>
        </div>
        <input type="hidden" class="form-control" id="nomor_certificate" name="nomor_certificate" required placeholder="margin nomor_certificate">
        <input type="hidden" class="form-control" id="nama" name="nama" required placeholder="margin nama">
        <input type="hidden" class="form-control" id="deskripsi" name="deskripsi" required placeholder="margin deskripsi">
        <input type="hidden" class="form-control" id="tanggal" name="tanggal" required placeholder="margin tanggal">
        <input type="hidden" class="form-control" id="uid" name="uid" required placeholder="margin uid">
        <input type="text" class="form-control" id="ttd1" name="ttd1" required placeholder="margin ttd 1">
        <input type="text" class="form-control" id="ttd2" name="ttd2" required placeholder="margin ttd 2">
    </form>

    <!-- Live Preview -->
    <div class="text-center mb-3">
        <h5 style="font-size: 24px; font-weight: bold; color: #333;">Live Preview</h5>
    </div>

    <div class="certificate-container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div id="certificate-preview" style="position: relative; display: inline-block; border: 2px solid #ddd; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); border-radius: 10px; overflow: hidden; background-color: #f9f9f9; width: 1122px; height: 793px; background-color: #fff; margin: 0 auto;">
            <!-- Preview Image -->
            <img id="preview-image" src="" alt="Live Preview" style="display: block; width: 100%; height: 100%; object-fit: contain;">
            
            <!-- Nama -->
            <div id="preview-nama" style="position:absolute; top:40%; left:50%; transform:translate(-50%, -50%); font-size:24px; font-weight:bold; color:#333; text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);">Amru abdurrahman azzam</div>

            <!-- nomor_certificate -->
            <div id="preview-nomor_certificate" style="position:absolute; top:55%; left:50%; font-size:18px; color:#555; text-align:center; font-weight:500;z-index: 1; width:500px;">001/MA/MB.DMM/MSIB/XII/2024</div>

            <!-- Deskripsi -->
            <div id="preview-deskripsi" style="position:absolute; top:55%; left:50%; font-size:18px; color:#555; text-align:center; font-weight:500;z-index: 1; width:500px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Id blanditiis voluptatibus sed hic vero consequatur fuga necessitatibus qui debitis pariatur!</div>

            <!-- Tanggal -->
            <div id="preview-tanggal" style="position:absolute; bottom:20%; left:50%; transform:translateX(-50%); font-size:16px; color:#777; font-style:italic;">20 September 2024</div>

            <!-- UID -->
            <div id="preview-uid" style="position:absolute; bottom:15%; left:50%; transform:translateX(-50%); font-size:14px; color:#555;">UID: UID12345</div>

            <!-- Signature 1 -->
            <img id="signature-image" src="{{ asset('ttd/ttd.png') }}" alt="Signature" style="position:absolute; bottom:5%; left:50%; transform:translateX(-50%); width:100px; height:auto;">
            
            <!-- Signature 2 -->
            <img id="signature-image2" src="{{ asset('ttd/ttd.png') }}" alt="Signature" style="position:absolute; bottom:5%; left:60%; transform:translateX(-50%); width:100px; height:auto;">
        </div>
    </div>

    <button type="submit" class="btn text-white mt-4" style="background-color:#2D3E50;" onclick="document.getElementById('certificateForm').submit();">Save Template</button>

   <script>
    document.addEventListener("DOMContentLoaded", function () {
        const namaInput = document.getElementById("nama");
        const deskripsiInput = document.getElementById("deskripsi");
        const tanggalInput = document.getElementById("tanggal");
        const nomor_certificateInput = document.getElementById("nomor_certificate");
        const imageInput = document.getElementById("preview");

        const namaPreview = document.getElementById("preview-nama");
        const nomor_certificatePreview = document.getElementById("preview-nomor_certificate");
        const deskripsiPreview = document.getElementById("preview-deskripsi");
        const tanggalPreview = document.getElementById("preview-tanggal");
        const imagePreview = document.getElementById("preview-image");

        // Update margin text based on input
        namaInput.addEventListener("input", () => {
            namaPreview.style.margin = namaInput.value || "0px 0px 0px 0px";
        });

        deskripsiInput.addEventListener("input", () => {
            deskripsiPreview.style.margin = deskripsiInput.value || "0px 0px 0px 0px";
        });

        tanggalInput.addEventListener("input", () => {
            tanggalPreview.style.margin = tanggalInput.value || "0px 0px 0px 0px";
        });

        nomor_certificateInput.addEventListener("input", () => {
            nomor_certificatePreview.style.margin = nomor_certificateInput.value || "0px 0px 0px 0px";
        });

        // Event listener for image preview
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

        // Draggable functionality for text fields, including nomor_certificate
        $(document).ready(function () {
            const elements = [
                { id: "#preview-nama", input: "#nama" },
                { id: "#preview-deskripsi", input: "#deskripsi" },
                { id: "#preview-tanggal", input: "#tanggal" },
                { id: "#preview-nomor_certificate", input: "#nomor_certificate" },
                { id: "#preview-uid", input: "#uid" }
            ];

            const signatureElements = [
                { id: "#signature-image", input: "#ttd1" },
                { id: "#signature-image2", input: "#ttd2" }
            ];

            // Handle draggable for standard text fields
            elements.forEach((el) => {
                $(el.id).draggable({
                    containment: "#certificate-preview",
                    scroll: false,
                    stop: function (event, ui) {
                        const offset = ui.position;
                        const marginTop = offset.top;
                        const marginLeft = offset.left;
                        $(el.input).val(`${marginTop}px 0 0 ${marginLeft}px`);
                    },
                });
            });

            // Handle draggable for signature images
            signatureElements.forEach((el, index) => {
                $(el.id).draggable({
                    containment: "#certificate-preview",
                    scroll: false,
                    stop: function (event, ui) {
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
