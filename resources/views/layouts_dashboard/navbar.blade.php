<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #FFEE32;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Logo</a>
        <div class="d-flex align-items-center">
            <span class="me-3" data-bs-toggle="modal" data-bs-target="#logoutModal"style="cursor: pointer;">Hi, {{Auth::user()->name}}</span>
            <i class="bi bi-person-circle" style="font-size: 1.5rem; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#logoutModal">

            </i>
        </div>
    </div>
</nav>

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Select "Logout" below if you are ready to end your current session.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="{{ route('logout') }}" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>