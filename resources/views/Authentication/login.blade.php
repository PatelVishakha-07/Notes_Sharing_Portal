<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<script src="https://cdn.tailwindcss.com"></script>
{{-- <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet"> --}}

{{-- <link href="{{ asset('css/css2.css') }}" rel="stylesheet"> --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('style.css') }}">

<title>Login | NotePortal</title>
</head>

<body class="bg-[#f8fafc] min-h-screen flex items-center justify-center p-4 lg:p-8">

<div class="auth-container grid lg:grid-cols-2 bg-white rounded-3xl shadow-2xl overflow-hidden">

<!-- LEFT PANEL -->
<div class="hidden lg:flex auth-left p-16 flex-col justify-center text-white">

<h1 class="text-4xl font-bold mb-6">
Centralized <span class="text-indigo-400">Academic Repository</span>
</h1>

<p class="text-slate-400">
Access notes, share knowledge, and collaborate with students.
</p>

</div>

<!-- RIGHT PANEL -->
<div class="auth-right p-8 lg:p-16 flex flex-col justify-center">

<h2 class="heading-main mb-2">Welcome back!</h2>
<p class="text-muted mb-6">Login to your account</p>

<div class="max-w-md w-full mx-auto">
    <form action="{{url('process_login')}}" method="POST" class="space-y-4">
    @csrf
    
    <label class="text-sm text-gray-600">Email</label>
    <input type="email" name="email" class="input-field" placeholder="Email">

    @error('email')
    <p class="alert-error">{{ $message }}</p>
    @enderror

    <label class="text-sm text-gray-600">Password</label>
    <input type="password" name="password" class="input-field" placeholder="Password">

    @error('password')
    <p class="alert-error">{{ $message }}</p>
    @enderror

    <button class="btn-primary">Login</button>

    </form>
</div>

<div class="mt-4 text-center">
<a href="{{url('register')}}" class="text-indigo-600 font-semibold">Create Account</a>
</div>

</div>

</div>

</body>
</html>