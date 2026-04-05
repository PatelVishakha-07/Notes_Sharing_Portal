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

<div class="logo">
NOTEPORTAL <span>CMS</span>
</div>

<a href="{{url('admin_dashboard')}}" class="{{ request()->is('admin_dashboard') ? 'active' : '' }}">Dashboard</a>

<a href="{{url('list_category')}}" class="{{ request()->is('list_category') ? 'active' : '' }}">Category</a>

<a href="{{url('list_subject')}}" class="{{ request()->is('list_subject') ? 'active' : '' }}">Subjects</a>

<a href="{{url('admin/showPendingNotesList')}}" class="{{ request()->is('admin/showPendingNotesList') ? 'active' : '' }}">Pending Notes</a>

<a href="{{url('admin/showUsersList')}}" class="{{ request()->is('admin/showUsersList') ? 'active' : '' }}">Users</a>

<a href="{{url('logout')}}" style="color:#fb7185;">Logout</a>

</div>

<!-- HEADER -->
<div class="header">

<input type="text" class="search-box" placeholder="Search system resources...">

<div>
<strong>Admin User</strong><br>
<small style="color:#64748b;">System Administrator</small>
</div>

</div>

<!-- CONTENT -->
<div class="content">
@yield('content')
</div>

<!-- FOOTER -->
<div class="footer">
© 2026 NotePortal CMS | Notes Sharing System
</div>

</body>

<script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>

</html>