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
            
            {{-- Bug fix: logout must be POST — GET logout is a CSRF risk --}}
            <form method="POST" action="{{ url('logout') }}" style="margin:0;">
                @csrf
                <button type="submit"
                    style="background:none; border:none; padding:0; width:100%; text-align:left; cursor:pointer; color:#fb7185;"
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Logout">
                    🚪 <span>Logout</span>
                </button>
            </form>
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
                    
                    @if(auth()->user()->profile && auth()->user()->profile->profile_pic)
                        <img src="{{ asset('profile/'.auth()->user()->profile->profile_pic) }}"  class="avatar-img">
                    @else
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    @endif

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

<div class="offcanvas offcanvas-end" tabindex="-1" id="userSidebar" data-bs-backdrop="true" data-bs-scroll="false">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body text-center">
        <!-- Avatar Circle -->
        <form action="{{ url('update_profile') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Hidden File Input -->
            <input type="file" name="profile_pic" id="profilePicInput" hidden accept="image/*">

            @error('profile_pic')
                <p class="alert-error "> {{$message}} </p>
            @enderror

            <!-- Clickable Avatar -->
            <label for="profilePicInput" style="cursor:pointer;">
                <div class="profile-avatar mb-2">
                    @if(auth()->user()->profile && auth()->user()->profile->profile_pic)
                        <img src="{{ asset('profile/'.auth()->user()->profile->profile_pic) }}" class="avatar-img-large">
                    @else
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    @endif
                </div>
            </label>
                <br>
            <button type="submit" class="profile-save-btn" id="saveBtn" style="display: none"> Save Photo </button>
        </form>

        <hr>

        <!-- User Info -->
        <h6 class="mb-1">{{ auth()->user()->name }}</h6>
        <p class="text-muted">Email: {{ auth()->user()->email }}</p>

        <!-- Buttons -->
        <a href="{{ url('change_name') }}" class="btn btn-primary w-100 mb-2">
            Change Name
        </a>

        <a href="{{ url('change_password') }}" class="btn btn-outline-danger w-100">
            Change Password
        </a>

    </div>
</div>


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

        const fileInput = document.getElementById("profilePicInput");
        const saveBtn = document.getElementById("saveBtn");

        fileInput.addEventListener("change", function () {
            if (fileInput.files.length > 0) {
                saveBtn.style.display = "inline-block";
            } else {
                saveBtn.style.display = "none";
            }
        });

        fileInput.addEventListener("change", function () {
            saveBtn.style.display = fileInput.files.length ? "inline-block" : "none";
        });

    </script>


    </body>
</html>