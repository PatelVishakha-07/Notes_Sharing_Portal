<!DOCTYPE html>
<html>
    <head>
    <title>NotePortal CMS</title>

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- COMMON CSS -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    </head>

    <body class="layout-user">

        <!-- SIDEBAR -->
        <div class="sidebar">

             <div class="logo"> 📝 <span>NOTEPORTAL</span> </div>
            <a href="{{ url('user_dashboard') }}" class="{{ request()->is('user_dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip"
            data-bs-placement="right" title="Dashboard"> 📊 <span>Dashboard</span> </a>

            <a href="{{ url('user/list_public_notes/Public') }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Public Notes">
            🌍 <span>Public Notes</span> </a>

            <a href="{{ url('user/list_private_notes/Private') }}" data-bs-toggle="tooltip" data-bs-placement="right"
            title="Private Notes"> 🔒 <span>Private Notes</span> </a>

            <a href="{{ url('user/show_search_notes') }}" data-bs-toggle="tooltip" data-bs-placement="right"
            title="Search Notes"> 🔎 <span>Search Notes</span> </a>
            
            <a href="{{url('logout')}}" style="color:#fb7185;" data-bs-toggle="tooltip" 
            data-bs-placement="right" title="Logout">🚪 <span>Logout</span></a>
        </div>

       
{{-- ============================================================================ --}}

<!-- HEADER -->
<div class="header d-flex justify-content-between align-items-center">

    <!-- Left -->
    <div class="d-flex align-items-center gap-3">

    <!-- Toggle Button -->
    <button id="menu-toggle" class="menu-toggle">
        ☰
    </button>

    <h5 class="mb-0 fw-semibold">📚 Notes Portal</h5>

    <a href="{{ url('user/show_search_notes') }}" class="search-trigger">
        🔎 Search Notes
    </a>

</div>

    <!-- Right -->
    <div class="d-flex align-items-center gap-3">

        <span class="text-muted">📅 {{ date('d M Y') }}</span>

        <div class="user-box d-flex align-items-center gap-2">

        <!-- Avatar (Initial) -->
            <div class="avatar">
               <a href="#" data-bs-toggle="offcanvas" data-bs-target="#userSidebar">
                    {{ auth()->user() ? strtoupper(substr(auth()->user()->name,0,1)) : 'G' }} 
                </a>
            </div>

            <!-- Name + Role -->
            <div class="user-info">
                <strong>{{ auth()->user()->name ?? 'Guest' }}</strong><br>
                <small class="text-muted">User Panel</small>
            </div>

        </div>

    </div>

</div>

{{-- ============================================================================== --}}

        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>

        <!-- FOOTER -->
        <div class="footer">
        © 2026 NotePortal CMS | Notes Sharing System
        </div>


{{-- ============       Side bar to show user information       ========================== --}}

<div class="offcanvas offcanvas-end" tabindex="-1" id="userSidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body text-center">
        
        <!-- Avatar Circle -->
        <div class="profile-avatar mb-3">
            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
        </div>

        <!-- User Info -->
        <h6>{{ auth()->user()->name }}</h6>
        <p class="text-muted">Email: {{ auth()->user()->email }}</p>

        <hr>

        <!-- Buttons -->
        <a href="{{ url('change_name') }}" class="btn btn-primary w-100 mb-2">
            Change Name
        </a>

        <a href="{{ url('change_password') }}" class="btn btn-outline-danger w-100">
            Change Password
        </a>

    </div>
</div>


{{-- =================    JavaScript code for tool tip   ================= --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>

        <script>
            document.getElementById("menu-toggle").addEventListener("click",function(){
                document.body.classList.toggle("sidebar-collapsed");
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))

            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        </script>
    </body>
</html>