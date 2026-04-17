<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('style.css') }}">

<title>Register | NotePortal</title>
</head>

<body class="bg-[#f8fafc] min-h-screen flex items-center justify-center p-4 lg:p-8">

<div class="auth-container grid lg:grid-cols-2 bg-white rounded-3xl shadow-2xl overflow-hidden">

<!-- LEFT PANEL -->
<div class="hidden lg:flex auth-left p-16 flex-col justify-center text-white">

<h1 class="text-4xl font-bold mb-6">
Join the <span class="text-indigo-400">Knowledge Network</span>
</h1>

<p class="text-slate-400">
Create your account and start sharing notes.
</p>

</div>

<!-- RIGHT PANEL -->
<div class="auth-right p-8 lg:p-16 flex flex-col justify-center">

<h2 class="heading-main mb-2">Create Account</h2>
<p class="text-muted mb-6">Register below</p>

<div class="max-w-md w-full mx-auto">

    @if(session('error'))
        <p class="alert-error text-red-500 mb-3">
            {{ session('error') }}
        </p>
    @endif

    <form action="{{url('process_register')}}" method="POST" class="space-y-4">
    @csrf

    <label class="text-sm text-black-600">Full Name</label>
    <input type="text" name="name" class="input-field" placeholder="Full Name">
    @error('name')
    <p class="alert-error">{{ $message }}</p>
    @enderror

    <label class="text-sm text-black-600">Email</label>
    <input type="email" name="email" class="input-field" placeholder="Email">
    @error('email')
    <p class="alert-error">{{ $message }}</p>
    @enderror

    <label class="text-sm text-black-600">Password</label>
    <input type="password" name="password" class="input-field" placeholder="Password">
    @error('password')
    <p class="alert-error">{{ $message }}</p>
    @enderror

    <label class="text-sm text-black-600">Confirm Password</label>
    <input type="password" name="password_confirmation" class="input-field" placeholder="Confirm Password">
    @error('password_confirmation')
    <p class="alert-error">{{ $message }}</p>
    @enderror

    <button class="btn-primary">Register</button>

    </form>
</div>

<div class="mt-4 text-center">
<a href="{{url('login')}}" class="text-indigo-600 font-semibold">Already have account?</a>
</div>

</div>

</div>

</body>
</html>