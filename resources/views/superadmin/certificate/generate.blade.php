@extends('layouts_dashboard.app')

@section('css')

      <style>
    /* Sesuaikan gaya CSS untuk elemen-elemen */
    #templatePreview {
        position: relative;
        width: 842px; /* Sesuaikan dengan lebar template PDF */
        height: 595px; /* Sesuaikan dengan tinggi template PDF */
        text-align: center;
        overflow: hidden;
        background-color: #fff;
    }

    /* Posisi elemen-elemen teks sesuai dengan template */
    #previewNama {
        position: absolute;
        font-size: 32px;
        left: 50%;
        top: 50%; /* Menyesuaikan posisi */
        transform: translate(-50%, -50%);
    }

    #previewDeskripsi {
        position: absolute;
        font-size: 13px;
        left: 50%;
        top: 70%; /* Menyesuaikan posisi */
        transform: translateX(-50%);
    }

    #previewTanggal {
        position: absolute;
        left: 50%;
        top: 80%; /* Menyesuaikan posisi */
        transform: translateX(-50%);
    }

    #previewTtd {
        position: absolute;
        right: -250px; /* Sesuaikan posisi tanda tangan */
        top: 130px; /* Sesuaikan posisi tanda tangan */
        max-width: 150px;
        max-height: 100px;
        width: auto;
        height: auto;
        object-fit: contain;
    }

    #previewUid {
        position: absolute;
        left: 50%;
        top: 90%; /* Menyesuaikan posisi UID */
        transform: translateX(-50%);
        font-weight: bold;
        color: #000000d3;
    }
</style>

    
@endsection

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
        <input type="file" class="form-control" id="preview" name="preview" required accept="image/*">
    </div>

    <!-- Elemen untuk pratinjau gambar dan teks -->
    <div class="mb-3">
        <label class="form-label">Pratinjau Template</label>
        <div id="templatePreview" style="border: 1px solid #ccc; padding: 10px; position: relative; width: 842px; height: 595px; text-align: center; overflow: hidden; background-color: #fff;">
    <img id="imagePreview" src="#" alt="Pratinjau Gambar" style="max-width: 100%; display: none;">
    <!-- Elemen teks dummy -->
    <p id="previewNama" style="position: absolute; margin: 0;">amru azzam</p>
    <p id="previewDeskripsi" style="position: absolute; margin: 0;">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Provident, culpa.</p>
    <p id="previewTanggal" style="position: absolute; margin: 0;">01/01/2024</p>
    <img id="previewTtd" src="path-to-signature-image" alt="Tanda Tangan">
    <p id="previewUid" style="position: absolute; margin: 0;">UID: 123456789</p>
</div>

    </div>

    <!-- Input margin -->
    <div class="row mt-4">
        <div class="col-4">
            <label for="nama" class="form-label">Margin Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required placeholder="margin nama" value="10px 20px 0px 30px">
        </div>
        <div class="col-4">
            <label for="deskripsi" class="form-label">Margin Deskripsi</label>
            <input type="text" class="form-control" id="deskripsi" name="deskripsi" required placeholder="margin deskripsi" value="40px 10px 0px 50px">
        </div>
        <div class="col-4">
            <label for="tanggal" class="form-label">Margin Tanggal</label>
            <input type="text" class="form-control" id="tanggal" name="tanggal" required placeholder="margin tanggal" value="70px 30px 0px 20px">
        </div>
    </div>

    <div class="row mt-4 mb-4">
        <div class="col-6">
            <label for="ttd" class="form-label">Margin Ttd</label>
            <input type="text" class="form-control" id="ttd" name="ttd" required placeholder="margin ttd" value="100px 10px 0px 40px">
        </div>
        <div class="col-6">
            <label for="uid" class="form-label">Margin UID</label>
            <input type="text" class="form-control" id="uid" name="uid" required placeholder="margin uid" value="130px 20px 0px 30px">
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


    <script>
    // Event listener untuk pratinjau gambar
    document.getElementById('preview').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById('imagePreview');
                img.src = e.target.result;
                img.style.display = 'block'; // Tampilkan gambar
            };
            reader.readAsDataURL(file);
        }
    });

    // Event listener untuk memperbarui margin
    const inputs = ['nama', 'deskripsi', 'tanggal', 'ttd', 'uid'];
    inputs.forEach(input => {
        document.getElementById(input).addEventListener('input', function () {
            const element = document.getElementById(`preview${input.charAt(0).toUpperCase() + input.slice(1)}`);
            element.style.margin = this.value; // Terapkan margin dari input ke elemen teks
        });
    });
</script>

@endsection('content')
