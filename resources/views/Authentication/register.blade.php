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

                <h1 class="text-4xl font-bold mb-6"> Join the <span class="text-indigo-400">Knowledge Network</span> </h1>

                <p class="text-slate-400"> Create your account and start sharing notes. </p>
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

            <!-- NAME -->
            <label class="text-sm text-gray-600">Full Name</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10M4 18h10"/>
                    </svg>
                </span>
                <input type="text" name="name" class="input-field pl-10" placeholder="Full Name">
            </div>
            @error('name')
            <p class="alert-error">{{ $message }}</p>
            @enderror


            <!-- EMAIL -->
            <label class="text-sm text-gray-600">Email</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18a2 2 0 002-2V8a2 2 0 00-2-2H3a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </span>
                <input type="email" name="email" class="input-field pl-10" placeholder="Email">
            </div>
            @error('email')
            <p class="alert-error">{{ $message }}</p>
            @enderror


            <!-- PASSWORD -->
            <label class="text-sm text-gray-600">Password</label>

            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3zm6 8H6v-1a6 6 0 0112 0v1z"/>
                    </svg>
                </span>

                <input type="password" id="password" name="password"
                    class="input-field pl-10 pr-10"
                    placeholder="Password">

                <button type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"
                    onclick="togglePassword('password','eye1')">

                    <svg id="eye1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                            -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            @error('password')
            <p class="alert-error">{{ $message }}</p>
            @enderror


            <!-- CONFIRM PASSWORD -->
            <label class="text-sm text-gray-600">Confirm Password</label>

            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3zm6 8H6v-1a6 6 0 0112 0v1z"/>
                    </svg>
                </span>

                <input type="password" id="confirm_password" name="password_confirmation"
                    class="input-field pl-10 pr-10"
                    placeholder="Confirm Password">

                <button type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"
                    onclick="togglePassword('confirm_password','eye2')">

                    <svg id="eye2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                            -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            @error('password_confirmation')
            <p class="alert-error">{{ $message }}</p>
            @enderror

            <button class="btn-primary w-full mt-2">Register</button>
        </form>
        </div>

        <div class="mt-4 text-center">
            <a href="{{url('login')}}" class="text-indigo-600 font-semibold">Already have account?</a>
        </div>

        </div>

        </div>

    </body>

    <script>
        function togglePassword(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);

            if (input.type === "password") {
                input.type = "text";
                eye.style.opacity = "0.5";
            } else {
                input.type = "password";
                eye.style.opacity = "1";
            }
        }
    </script>
</html>

