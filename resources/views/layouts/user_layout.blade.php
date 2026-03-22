<!DOCTYPE html>
<html>
<head>
<title>NotePortal</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
margin:0;
font-family:Segoe UI, sans-serif;
background:#f4f6fb;
}

/* HEADER */

.header{
height:70px;
background:white;
border-bottom:1px solid #e5e7eb;
display:flex;
align-items:center;
justify-content:space-between;
padding:0 30px;
margin-left:230px;
}

/* SEARCH */

.search-box{
background:#eef1f6;
border-radius:25px;
padding:8px 20px;
width:320px;
border:none;
outline:none;
}

/* SIDEBAR */

.sidebar{
width:230px;
height:100vh;
background:#111827;
color:white;
position:fixed;
padding-top:20px;
}

/* LOGO */

.logo{
font-size:20px;
font-weight:600;
padding:15px 25px;
margin-bottom:20px;
}

.logo span{
color:#6366f1;
}

/* MENU */

.sidebar a{
display:flex;
align-items:center;
padding:14px 25px;
color:#cbd5e1;
text-decoration:none;
border-radius:10px;
margin:5px 15px;
transition:0.3s;
}

.sidebar a:hover{
background:#1e293b;
color:white;
}

.sidebar a.active{
background:linear-gradient(90deg,#6366f1,#7c3aed);
color:white;
}

/* CONTENT */

.content{
margin-left:230px;
padding:30px;
min-height:calc(100vh - 120px);
}

/* FOOTER */

.footer{
margin-left:230px;
background:white;
border-top:1px solid #e5e7eb;
text-align:center;
padding:12px;
color:#64748b;
}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

<div class="logo">
NOTEPORTAL <span>User</span>
</div>

<a href="/dashboard" class="active">Dashboard</a>

<a href="/browse-notes">Browse Notes</a>

<a href="/my-notes">My Notes</a>

<a href="/upload-notes">Upload Notes</a>

<a href="/profile">My Profile</a>

<br><br>

<a href="/logout" style="color:#fb7185;">Logout</a>

</div>


<!-- HEADER -->

<div class="header">

<input type="text" class="search-box" placeholder="Search notes, subjects...">

<div>
<strong>{{ Auth::user()->name ?? 'User' }}</strong><br>
<small style="color:#64748b;">NotePortal Member</small>
</div>

</div>


<!-- CONTENT -->

<div class="content">

@yield('content')

</div>


<!-- FOOTER -->

<div class="footer">

© 2026 NotePortal | Notes Sharing Portal

</div>

</body>
</html>