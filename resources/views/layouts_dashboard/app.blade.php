<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="svg" href="{{ asset('assets/Logo.svg') }}">
    <title>Super Admin</title>
    <!-- chart-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!--aos-->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
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
    <!-- ini buat tanggal ya ges-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" defer></script>

    <style>
          html, body {
      overflow-x: hidden;
      }
    </style>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- DataTables Bootstrap 5 Integration CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


    @yield('css')

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
        const menuTexts = sidebar.querySelectorAll('.menu-text'); // Semua teks menu
        const dashboardText = document.getElementById('dashboardText');
        const logoutText = document.getElementById('logoutText'); // Tambahkan logoutText

        // Toggle collapsed state
        if (sidebar.style.width === '60px') {
            sidebar.style.width = '240px';
            content.style.marginLeft = '240px'; // Adjust content margin
            menuTexts.forEach(el => el.style.display = 'inline');
            if (dashboardText) dashboardText.style.display = 'inline';
            if (logoutText) logoutText.style.display = 'inline'; // Tampilkan logoutText
            icon.className = 'bi bi-chevron-double-left';
        } else {
            sidebar.style.width = '60px';
            content.style.marginLeft = '60px'; // Adjust content margin
            menuTexts.forEach(el => el.style.display = 'none');
            if (dashboardText) dashboardText.style.display = 'none';
            if (logoutText) logoutText.style.display = 'none'; // Sembunyikan logoutText
            icon.className = 'bi bi-chevron-double-right';
        }
    });
</script>

<!--chart-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari Laravel Blade
    const eventData = {{ $event }};
    const userData = {{ $user }};
    const certificateData = {{ $participant }};
    
    // Event Chart - Bar Chart
    const ctxEvent = document.getElementById('eventChart').getContext('2d');
    new Chart(ctxEvent, {
        type: 'bar',
        data: {
            labels: ['Event'],
            datasets: [{
                label: 'Total Event',
                data: [eventData],
                backgroundColor: '#4e73df',
                borderColor: '#2e59d9',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // User Chart - Pie Chart
    const ctxUser = document.getElementById('userChart').getContext('2d');
    new Chart(ctxUser, {
        type: 'pie',
        data: {
            labels: ['User'],
            datasets: [{
                data: [userData, 100 - userData], // Misalkan total 100 untuk visualisasi
                backgroundColor: ['#1cc88a', '#f8f9fc'],
            }]
        },
        options: {
            responsive: true
        }
    });

    // Certificate Chart - Line Chart
    const ctxCertificate = document.getElementById('certificateChart').getContext('2d');
    new Chart(ctxCertificate, {
        type: 'line',
        data: {
            labels: ['Certificate'],
            datasets: [{
                label: 'Total Certificate',
                data: [certificateData],
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: '#36b9cc',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>

<!tangallllllllllllllllll-->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dateElement = document.getElementById('current-date');
    
        // Menggunakan API WorldTime untuk mendapatkan waktu real
        fetch('http://worldtimeapi.org/api/ip')
            .then(response => response.json())
            .then(data => {
                // Format tanggal
                const dateTime = new Date(data.datetime);
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                const formattedDate = dateTime.toLocaleDateString('id-ID', options);
    
                // Tampilkan tanggal
                dateElement.textContent = formattedDate;
            })
            .catch(() => {
                // Jika API gagal, gunakan waktu lokal
                const dateTime = new Date();
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                dateElement.textContent = dateTime.toLocaleDateString('id-ID', options);
            });
    });
    </script>
    

</body>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
</body>
</html>
