<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- font awasome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
          html, body {
      overflow-x: hidden;
      }
    </style>

    @yield('css')
    <!-- css datatble -->
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

</head>
<body>
<!-- Navbar -->
@include('layouts_dashboard.navbar')


 <!-- Sidebar -->
 @include('layouts_dashboard.sidebar')
 


<!-- Content -->
<div id="content" style="margin-left: 240px; padding: 20px; transition: margin-left 0.3s; margin-top:50px">
    @yield('back')


    @yield('content')
</div>


<!-- Sidebar Toggle Script -->
<script>
    document.getElementById('toggleSidebar').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content'); // Kontainer content
        const icon = this.querySelector('i');
        const menuTexts = sidebar.querySelectorAll('.menu-text');
        const dashboardText = document.getElementById('dashboardText');

        // Toggle collapsed state
        if (sidebar.style.width === '60px') {
            sidebar.style.width = '240px';
            content.style.marginLeft = '240px'; // Adjust content margin
            menuTexts.forEach(el => el.style.display = 'inline');
            if (dashboardText) dashboardText.style.display = 'inline';
            icon.className = 'bi bi-chevron-double-left';
        } else {
            sidebar.style.width = '60px';
            content.style.marginLeft = '60px'; // Adjust content margin
            menuTexts.forEach(el => el.style.display = 'none');
            if (dashboardText) dashboardText.style.display = 'none';
            icon.className = 'bi bi-chevron-double-right';
        }
    });
</script>


<script src="{{asset ('assets_dashboard/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{asset ('assets_dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset ('assets_dashboard/vendor/jquery-easing/jquery.easing.min.js') }}"></script>


<script src="{{asset ('assets_dashboard/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- datatables -->
    <script src="{{asset ('assets_dashboard/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset ('assets_dashboard/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset ('assets_dashboard/js/demo/datatables-demo.js') }}"></script>

    {{-- sidebar setting --}}
    <script>
        // Function to set the active state
        function setActive(element) {
            // Remove the active class from all list items
            const items = document.querySelectorAll('#sidebarMenu .list-group-item');
            items.forEach(item => item.classList.remove('active'));
    
            // Add the active class to the clicked item
            element.classList.add('active');
        }
    </script>

//Profil
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Mendaftarkan event listener pada input file
        const uploadInput = document.getElementById('uploadPhoto');
        
        uploadInput.addEventListener('change', function(event) {
            uploadPhoto(event);
        });
    });
    function uploadPhoto(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profilePicture').src = e.target.result;
            };
            reader.readAsDataURL(file);

            const formData = new FormData();
            formData.append('photo', file);

            fetch('/profile/upload-photo', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || 'Photo uploaded successfully!');
            })
            .catch(error => {
                console.error('Error uploading photo:', error);
                alert('Failed to upload photo. Please try again.');
            });
        }
    }
</script>

</body>

</body>
</html>
