<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotePortal | Public Notes</title>

    <link href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <style>
        body { background: #f4f6fb; }
    </style>
</head>
<body>

<nav class="navbar-guest">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo m-0 p-0">
            📝 <span style="color: #0f172a; font-weight:700;">NOTEPORTAL</span><span style="color: #6366f1;"></span>
        </div>
        
        <div class="d-flex gap-2" style="margin-top: 10px">
            <a href="{{ url('login') }}" class="btn-login" style="padding: 8px 20px; font-size: 14px; text-decoration: none;">Login</a>
            <a href="{{ url('register') }}" class="btn-register" style="padding: 8px 20px; font-size: 14px; width: auto; text-decoration: none;">Join Now</a>
        </div>
    </div>
</nav>

<div class="container text-center mt-5 mb-5">
    <h1 class="heading-main mb-2">Knowledge Sharing Made Simple</h1>
    <p class="text-muted">Browse public notes. Login to download and access full content.</p>
</div>

<div class="container pb-5">
    <div class="row">
        
        @foreach($notes as $n)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card h-100 pdf-grid-card">
                    
                    <div class="preview-container">
                        
                        {{-- 
                           FIX: We check if filePath exists and is not null 
                           by using ( $n->filePath ?? [] ) 
                        --}}
                        @foreach ($n->filePath ?? [] as $fp)
                            @if($loop->first) 
                                <iframe src="{{ url('view-file/'.$fp->file_path) }}#toolbar=0&page=1&view=FitH"></iframe>
                            @endif
                        @endforeach

                        {{-- If no files exist at all, show a placeholder --}}
                        @if(!$n->filePath || $n->filePath->isEmpty())
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                <span>No Preview Available</span>
                            </div>
                        @endif

                        {{-- The Clickable Login Overlay --}}
                        <a href="{{ url('login') }}" class="login-gate">
                            <div class="lock-icon">🔒 Login to View</div>
                        </a>
                    </div>

                    <div class="card-body p-3">
                        <span class="badge-subject mb-2 d-inline-block">
                            {{ $n->subject->sub_name ?? 'General' }}
                        </span>
                        
                        <h6 class="text-truncate fw-bold mb-1" style="color: #1e293b;">
                            {{ $n->title }}
                        </h6>
                        
                        <p class="text-muted small mb-3">By: {{ $n->user->name ?? 'System' }}</p>
                        
                        <div class="d-grid mt-auto">
                            <a href="{{ url('login') }}" class="btn-primary text-center text-decoration-none" style="padding: 10px; font-size: 13px;">
                                Access Document
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

    </div>
</div>

<div class="footer mt-5">
    © 2026 NotePortal CMS | Study Notes System
</div>

<style>
.btn-login {
    background: transparent;
    color: #4f46e5; 
    border: 1px solid #4f46e5;
    border-radius: 8px;
    font-weight: 600;

    transition: all 0.25s ease;
}
.btn-login:hover {
    background: #4f46e5;
    color: #fff;
}
.btn-register {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
    transition: all 0.25s ease;
}
.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(79, 70, 229, 0.4);
    color: #fff;
}
</style

</body>
</html>