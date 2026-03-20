<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-effect { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
        .note-card-sketch { border-radius: 2px 20px 2px 2px; }
    </style>
    <title>NoteShare | Access Knowledge</title>
</head>
<body class="bg-[#f8fafc] min-h-screen flex items-center justify-center p-4 lg:p-8">

    <div class="max-w-6xl w-full grid lg:grid-cols-2 bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[700px]">
        
    <div class="hidden lg:flex bg-slate-900 p-16 flex-col justify-between relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-slate-800 rounded-full opacity-50"></div>
        
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-8">
                <div class="bg-indigo-600 p-2 rounded-lg shadow-xl shadow-indigo-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                    </svg>
                </div>
                <span class="text-2xl font-bold text-white tracking-tight uppercase">NotePortal <span class="text-indigo-500 text-sm font-light">v1.0</span></span>
            </div>
            
            <h1 class="text-4xl font-extrabold text-white leading-tight mb-6">
                Centralized <br> <span class="text-indigo-400">Academic Repository.</span>
            </h1>
            <p class="text-slate-400 text-lg max-w-md mb-10">
                A secure peer-to-peer platform designed to streamline the exchange of course materials and research notes.
            </p>

            <div class="space-y-8">
                <div class="flex items-start gap-4">
                    <div class="mt-1">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold">Categorized Resources</h4>
                        <p class="text-slate-500 text-sm">Organized by Semester, Subject, and Module for efficient retrieval.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="mt-1">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold">Collaborative Learning</h4>
                        <p class="text-slate-500 text-sm">Enhancing student engagement through shared intellectual assets.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="mt-auto pt-10 border-t border-slate-800">
            <div class="flex items-center justify-between text-xs text-slate-500 uppercase tracking-widest">
                <span>Semester Project 2024</span>
                <span>Laravel Framework</span>
            </div>
        </div> -->
    </div>

        <div class="p-8 lg:p-20 flex flex-col justify-center">
            <div class="mb-10 lg:hidden flex items-center gap-2">
                <div class="bg-indigo-700 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-800">NoteShare</span>
            </div>

            <div class="max-w-md mx-auto w-full">
                <h2 class="text-3xl font-bold text-gray-900 mb-2 italic">Welcome back!</h2>
                <p class="text-gray-500 mb-8">Please enter your details to access your dashboard.</p>

                <form action="" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="text-sm font-semibold text-gray-700 block mb-2">Your Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" /></svg>
                            </span>
                            <input type="email" name="email" class="pl-10 w-full p-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all outline-none" placeholder="you@university.edu">
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="text-sm font-semibold text-gray-700">Password</label>
                            <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">Forgot?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </span>
                            <input type="password" name="password" class="pl-10 w-full p-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all outline-none" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="remember" class="ml-2 text-sm text-gray-600 font-medium">Keep me logged in</label>
                    </div>

                    <button type="submit" class="w-full bg-indigo-700 hover:bg-indigo-800 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 transform active:scale-[0.98] transition-all">
                        Sign In to Dashboard
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500 font-medium">
                        New to the platform? 
                        <a href="" class="text-indigo-700 font-bold hover:underline ml-1">Create an account</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>