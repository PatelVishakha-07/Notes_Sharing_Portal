<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    <title>Register | NotePortal Repository</title>
</head>
<body class="bg-[#f8fafc] min-h-screen flex items-center justify-center p-4 lg:p-8">

    <div class="max-w-6xl w-full grid lg:grid-cols-2 bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[750px]">
        
        <div class="hidden lg:flex bg-slate-900 p-16 flex-col justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-slate-800 rounded-full opacity-50"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-8">
                    <div class="bg-indigo-600 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-white tracking-tight uppercase">NotePortal <span class="text-indigo-500 text-sm font-light">v1.0</span></span>
                </div>
                
                <h1 class="text-4xl font-extrabold text-white leading-tight mb-6">
                    Join the <br> <span class="text-indigo-400">Knowledge Network.</span>
                </h1>
                <p class="text-slate-400 text-lg max-w-md mb-10">
                    Create an account to contribute to the peer-reviewed repository and access shared academic resources.
                </p>

                <div class="space-y-8">
                    <div class="flex items-start gap-4">
                        <div class="text-indigo-500 mt-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold">Secure Authentication</h4>
                            <p class="text-slate-500 text-sm">Encrypted data handling ensuring student privacy and integrity.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="mt-auto pt-10 border-t border-slate-800">
                <div class="flex items-center justify-between text-xs text-slate-500 uppercase tracking-widest">
                    <span>Project Module: Auth</span>
                    <span>Student Documentation</span>
                </div>
            </div> -->
        </div>

        <div class="p-8 lg:p-16 flex flex-col justify-center bg-white">
            <div class="max-w-md mx-auto w-full">
                <h2 class="text-3xl font-bold text-slate-900 mb-2">Create Account</h2>
                <p class="text-slate-500 mb-8 font-medium">Register your credentials below.</p>

                <form action="{{url('process_register')}}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-1">Full Name</label>
                        <input type="text" name="name" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="e.g. Alex Johnson" >
                    </div>

                    <!-- -- Name Validation -->
                    @error('name')
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md" role="alert">
                            <strong class="font-bold">Error:</strong>
                            <span class="block sm:inline">{{ $message }}</span>
                        </div>
                    @enderror

                    <div>
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-1">Your Email</label>
                        <input type="email" name="email" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="alex@university.edu" >
                    </div>

                    <!-- -- Email Validation -->
                    @error('email')
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md" role="alert">
                            <strong class="font-bold">Error:</strong>
                            <span class="block sm:inline">{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-1">Password</label>
                            <input type="password" name="password" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all" >
                        </div>

                        <!-- -- Password Validation -->
                    @error('password')
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md" role="alert">
                            <strong class="font-bold">Error:</strong>
                            <span class="block sm:inline">{{ $message }}</span>
                        </div>
                    @enderror


                        <div>
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all" >
                        </div>
                    </div>

                    <!-- -- password confirmation Validation -->
                    @error('password_confirmation')
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md" role="alert">
                            <strong class="font-bold">Error:</strong>
                            <span class="block sm:inline">{{ $message }}</span>
                        </div>
                    @enderror

                    <button type="submit" class="w-full bg-slate-900 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg transition-all mt-4">
                        Initialize Registration
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-slate-500 font-medium">
                        Already have an account? 
                        <a href="{{url('login')}}" class="text-indigo-600 font-bold hover:underline ml-1">Sign In</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Password and Confirm Password Doesn't Match -->
    @session('error')
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md" role="alert">
            <strong class="font-bold">Error:</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endsession
</body>
</html>