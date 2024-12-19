<div id="sidebar" class="position-fixed d-flex flex-column" style="background-color:#D3D6DB; width: 240px; height: calc(100vh - 56px); top: 56px; transition: width 0.3s;">
    <!-- Header -->
    @if (Auth::user() && Auth::user()->role === 'super-admin')
        <div id="sidebar-header" class="d-flex align-items-center justify-content-between py-3 px-3">
            <!-- Gambarrrrrrrrrrrr-->
            <img id="dashboardText" src="{{ asset('assets/dash.png') }}" alt="Logo" style="width: 80%; height: 80%; margin-top: 10px;">
            <!-- Teks Dashboard -->
            <!-- Tombol Toggle -->
            <button id="toggleSidebar" class="btn btn-sm"style="background-color: #D3D6DB;">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- Menu Items -->
        <a href="{{ route('superadmin') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-speedometer2 me-2"></i> <span class="menu-text">Dashboard</span>
        </a>

        <a href="{{ route('superadmin.user') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-people me-2"></i> <span class="menu-text">User</span>
        </a>

        <a href="{{ route('superadmin.certificate.indexTemplate') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-files-alt me-2"></i> <span class="menu-text">Template Certificate</span>
        </a>
        <a href="{{ route('superadmin.event') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-clipboard-data me-2"></i> <span class="menu-text">Data Event</span>
        </a>
        <a href="{{ route('certificate.history') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-clock-history me-2"></i> <span class="menu-text">History</span>
        </a>
        <a href="{{ route('setting') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-gear me-2"></i> <span class="menu-text">Setting</span>
        </a>
    @endif

    @if (Auth::user() && Auth::user()->role === 'admin')
    <div id="sidebar-header" class="d-flex align-items-center justify-content-between py-3 px-3">
            <!-- Teks Dashboard -->
            <span id="dashboardText" class="me-2">Dashboard</span>
            
            <!-- Tombol Toggle -->
            <button id="toggleSidebar" class="btn btn-sm"style="background-color: #D3D6DB;">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- Menu Items -->
        <a href="{{ route('admin.home') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-speedometer2 me-2"></i> <span class="menu-text">Dashboard</span>
        </a>
        <a href="{{ route('admin.event') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-clipboard-data me-2"></i> <span class="menu-text">Data Event</span>
        </a>
        <a href="{{ route('certificate.history') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-clock-history me-2"></i> <span class="menu-text">History</span>
        </a>
        <a href="{{ route('setting') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-gear me-2"></i> <span class="menu-text">Setting</span>
        </a>
    @endif
    <div id="logout" style="margin-top: auto; background-color: #2C3E50;">
        <a href="#" id="logout-link" style="display: flex; align-items: center; justify-content: center; padding: 12px; text-decoration: none; color: white;" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i id="logout-icon" class="bi bi-box-arrow-right" style="margin-right: 8px;"></i>
            <span id="logoutText">Log out</span>
        </a>
    </div>        
</div>


