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

        <div class="logo">
        NOTEPORTAL <span>CMS</span>
        </div>
            <a href="{{ url('user_dashboard') }}"  class="{{ request()->is('user_dashboard') ? 'active' : '' }}"> Dashboard </a>

            <a href="{{ url('user/list_public_notes/Public') }}"  class="{{ request()->is('user/list_public_notes*') ? 'active' : '' }}"> Public Notes </a>

            <a href="{{ url('user/list_private_notes/Private') }}" class="{{ request()->is('user/list_private_notes*') ? 'active' : '' }}"> Private Notes </a>

            <br><br>
            <a href="{{url('logout')}}" style="color:#fb7185;">Logout</a>
        </div>

        <!-- HEADER -->
        <div class="header">
            <input type="text" class="search-box" placeholder="Search system resources...">
        <div>
            <strong>{{ auth()->user()->name }}</strong><br>
            <small style="color:#64748b;">User Panel</small>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>