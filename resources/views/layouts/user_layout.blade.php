<!DOCTYPE html>
<html>
<head>
<title>NotePortal CMS</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- COMMON CSS -->
<link rel="stylesheet" href="{{ asset('style.css') }}">

</head>

<body class="layout-user">

<!-- SIDEBAR -->
<div class="sidebar">

<div class="logo">
NOTEPORTAL <span>CMS</span>
</div>

<a href="{{ url('user_dashboard') }}"  class="{{ request()->is('user_dashboard') ? 'active' : '' }}"> Dashboard </a>

<a href="{{ url('notes') }}"  class="{{ request()->is('notes*') ? 'active' : '' }}"> Notes </a>

<a href="{{ url('list_subject') }}" class="{{ request()->is('list_subject*') ? 'active' : '' }}"> Subjects </a>


<br><br>

<a href="/logout" style="color:#fb7185;">Logout</a>

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
</html>