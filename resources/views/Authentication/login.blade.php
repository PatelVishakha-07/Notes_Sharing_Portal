<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap&font-display=swap" rel="stylesheet">
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

            {{-- Session error (e.g. "Invalid credentials") --}}
            @if(session('error'))
                <div class="alert-error mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ url('process_login') }}" method="POST" class="space-y-4" novalidate>
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="text-sm text-gray-600">Email</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2" aria-hidden="true">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18a2 2 0 002-2V8a2 2 0 00-2-2H3a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="input-field pl-10 @error('email') border-red-400 @enderror"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            maxlength="254"
                            required
                            aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                        >
                    </div>
                    @error('email')
                        <p id="email-error" class="alert-error mt-1" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label for="login-password" class="text-sm text-gray-600">Password</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2" aria-hidden="true">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3zm6 8H6v-1a6 6 0 0112 0v1z"/>
                            </svg>
                        </span>
                        <input
                            type="password"
                            id="login-password"
                            name="password"
                            class="input-field pl-10 pr-10 @error('password') border-red-400 @enderror"
                            placeholder="Your password"
                            autocomplete="current-password"
                            maxlength="128"
                            required
                            aria-describedby="{{ $errors->has('password') ? 'password-error' : '' }}"
                        >
                        <button
                            type="button"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            onclick="togglePassword('login-password', 'eye-login')"
                            aria-label="Toggle password visibility"
                        >
                            <svg id="eye-login" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                                    -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p id="password-error" class="alert-error mt-1" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary mt-2">Login</button>

            </form>

        </div>

        <div class="mt-6 text-center text-sm">
            <span class="text-gray-500">Don't have an account?</span>
            <a href="{{ url('register') }}" class="text-indigo-600 font-semibold ml-1">Create Account</a>
        </div>

    </div>

</div>

<script>
    function togglePassword(inputId, eyeId) {
        const input = document.getElementById(inputId);
        const eye   = document.getElementById(eyeId);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        eye.style.opacity = isHidden ? '0.5' : '1';
    }
</script>

</body>
</html>