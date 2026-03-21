<!DOCTYPE html>
<html>
<head>
<title>NotePortal CMS</title>

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
margin-left:250px;
}

/* SEARCH BAR */

.search-box{
background:#eef1f6;
border-radius:25px;
padding:8px 20px;
width:350px;
border:none;
outline:none;
}

/* SIDEBAR */

.sidebar{
width:250px;
height:100vh;
background:#0f172a;
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

/* MENU LINKS */

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

/* ACTIVE MENU */

.sidebar a.active{
background:linear-gradient(90deg,#6366f1,#7c3aed);
color:white;
}

/* HOVER */

.sidebar a:hover{
background:#1e293b;
color:white;
}

/* CONTENT */

.content{
margin-left:250px;
padding:30px;
min-height:calc(100vh - 120px);
}

/* FOOTER */

.footer{
margin-left:250px;
background:white;
border-top:1px solid #e5e7eb;
text-align:center;
padding:12px;
color:#64748b;
}

/* DASHBOARD CARDS */

.dashboard-card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.card-title{
font-size:14px;
color:#64748b;
text-transform:uppercase;
}

.card-number{
font-size:32px;
font-weight:600;
color:#111827;
}

.green{
color:#22c55e;
}

.purple{
color:#6366f1;
}

.orange{
color:#f97316;
}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

<div class="logo">
NOTEPORTAL <span>CMS</span>
</div>

<a href="/admin/dashboard" class="active">Dashboard</a>

<a href="/admin/category">Add Category</a>

<a href="/admin/notes">Add Subjects</a>

<a href="/admin/users">Manage Users</a>


<br><br>

<a href="/logout" style="color:#fb7185;">Terminer Session</a>

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
    <p>Content</p>

@yield('content')

</div>


<!-- FOOTER -->

<div class="footer">

© 2026 NotePortal CMS | Notes Sharing System

</div>

</body>
</html>