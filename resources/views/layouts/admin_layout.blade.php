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

    {{-- Bug fix: logout must be POST — a GET logout allows a malicious
         link on another site to log the user out without consent --}}
    <form method="POST" action="{{ url('logout') }}" style="margin:0;">
        @csrf
        <button type="submit"
            style="background:none; border:none; padding:0; width:100%; text-align:left; cursor:pointer; color:#fb7185;"
            data-bs-placement="right" title="Logout" data-bs-toggle="tooltip">
            🚪 <span>Logout</span>
        </button>
    </form>

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
                
                @if(auth()->user()->profile && auth()->user()->profile->profile_pic)
                    <img src="{{ asset('profile/'.auth()->user()->profile->profile_pic) }}" class="avatar-img">
                @else
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                @endif

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

        <form action="{{ url('update_profile') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Hidden File Input -->
            <input type="file" name="profile_pic" id="profilePicInput" hidden accept="image/*">

            <!-- Clickable Avatar -->
            <label for="profilePicInput" style="cursor:pointer;">
                {{-- <div class="profile-avatar mb-2">
                    @if(auth()->user()->profile && auth()->user()->profile->profile_pic)
                        <img src="{{ asset('profile/'.auth()->user()->profile->profile_pic) }}" class="avatar-img-large">
                    @else
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    @endif
                </div> --}}

                <div class="profile-avatar mb-2" id="avatarPreview">
                    @if(auth()->user()->profile && auth()->user()->profile->profile_pic)
                        <img src="{{ asset('profile/'.auth()->user()->profile->profile_pic) }}" class="avatar-img-large" id="avatarImg">
                    @else
                        <div id="avatarInitial">
                            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                        </div>
                    @endif
                </div>                    


            </label>
                <br>

            <div class="d-flex justify-content-center gap-2 mt-2">

                <button type="submit" class="profile-save-btn" id="saveBtn" style="display:none;">
                    Save Photo
                </button>

                <button type="button" class="btn btn-danger" id="removeAvatarBtn" style="display:none;">
                    Remove
                </button>

            </div>
        </form>

        <hr>

        <!-- User Info -->
        <h6 class="mb-1">{{ auth()->user()->name }}</h6>
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


<script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>

<script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
        document.body.classList.toggle("sidebar-collapsed");
    });

    // TOOLTIP
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });


    // PROFILE AVATAR UPLOAD LOGIC

    const fileInput = document.getElementById("profilePicInput");
    const saveBtn = document.getElementById("saveBtn");
    const removeBtn = document.getElementById("removeAvatarBtn");
    const avatarPreview = document.getElementById("avatarPreview");

    let originalAvatar = avatarPreview.innerHTML;

    // IMAGE SELECT
    fileInput.addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (e) {

            avatarPreview.innerHTML = `
                <img src="${e.target.result}" class="avatar-img-large" id="avatarImg">
            `;

            saveBtn.style.display = "inline-block";
            removeBtn.style.display = "inline-block";
        };

        reader.readAsDataURL(file);
    });

        removeBtn.addEventListener("click", function () {

            fileInput.value = "";
            avatarPreview.innerHTML = originalAvatar;

            saveBtn.style.display = "none";
            removeBtn.style.display = "none";
        });

</script>

</body>

</html>