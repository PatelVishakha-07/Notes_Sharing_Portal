<!DOCTYPE html>
<html>
<head>
<title>NotePortal CMS</title>

{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<link href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- COMMON CSS -->
<link rel="stylesheet" href="{{ asset('style.css') }}">

</head> 

<body class="layout-admin">

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">  <span>NOTEPORTAL</span> </div>

    <a href="{{url('admin_dashboard')}}" class="{{ request()->is('admin_dashboard') ? 'active' : '' }}" 
        data-bs-placement="right" title="Dashboard" data-bs-toggle="tooltip">📊 <span>Dashboard</span></a>

    <a href="{{url('list_category')}}" class="{{ request()->is('list_category') ? 'active' : '' }}" 
        data-bs-placement="right" title="Category" data-bs-toggle="tooltip">📁 <span>Category</span></a>

    <a href="{{url('list_subject')}}" class="{{ request()->is('list_subject') ? 'active' : '' }}" 
        data-bs-placement="right" title="Subject" data-bs-toggle="tooltip">📚 <span>Subject</span></a>

    <a href="{{url('admin/showPendingNotesList')}}" class="{{ request()->is('admin/showPendingNotesList') ? 'active' : '' }}"
        data-bs-placement="right" title="Pending Notes" data-bs-toggle="tooltip">📊 <span>Pending Notes</span></a>

    <a href="{{url('admin/showUsersList')}}" class="{{ request()->is('admin/showUsersList') ? 'active' : '' }}" 
        data-bs-placement="right" title="Users" data-bs-toggle="tooltip">👥 <span>Users</span></a>

    <a href="{{url('logout')}}" style="color:#fb7185;"
    data-bs-placement="right" title="Logout" data-bs-toggle="tooltip">🚪 <span>Logout</span></a>

</div>

{{-- ================================================================ --}}

<!-- HEADER -->
<div class="header d-flex justify-content-between align-items-center">

    <!-- Left -->
    <div class="d-flex align-items-center gap-3">

    <!-- Toggle Button -->
    <button id="menu-toggle" class="menu-toggle">
        ☰
    </button>

    <h5 class="mb-0 fw-semibold">📚 Notes Portal</h5>

</div>

  <!-- Right -->
    <div class="d-flex align-items-center gap-4">

        <!-- Date -->
        <span class="text-muted">
            📅 {{ date('d M Y') }}
        </span>

        <!-- Admin -->
        <div class="d-flex align-items-center gap-2">

            <div class="avatar"> 
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#userSidebar">
                    {{ auth()->user() ? strtoupper(substr(auth()->user()->name,0,1)) : 'G' }} 
                </a>
            </div>

            <div class="user-info text-start">
                <strong class="d-block lh-1"> {{ auth()->user()->name }} </strong>
                <small class="text-muted"> Admin Panel </small>
            </div>
        </div>
    </div>
</div>


{{-- ================================================================= --}}

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


{{-- ================       JavaScript code for tootltip          =================================== --}}

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