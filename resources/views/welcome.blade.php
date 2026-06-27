<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotePortal | Public Notes</title>

    <link href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ===== WELCOME PAGE ===== */
        body { background: #f4f6fb; font-family: 'Inter', sans-serif; }

        /* NAV */
        .navbar-guest {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #e5e7eb;
            padding: 14px 0;
        }

        .nav-logo {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            text-decoration: none;
        }
        .nav-logo span { color: #6366f1; }

        .btn-nav-login {
            padding: 7px 20px;
            font-size: 13px;
            font-weight: 600;
            color: #4f46e5;
            border: 1.5px solid #4f46e5;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-nav-login:hover { background: #4f46e5; color: #fff; }

        .btn-nav-register {
            padding: 7px 20px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            border: none;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(99,102,241,0.3);
            transition: 0.2s;
        }
        .btn-nav-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(99,102,241,0.4);
            color: #fff;
        }

        /* HERO */
        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #312e81 100%);
            padding: 80px 0 90px;
            position: relative;
            overflow: hidden;
        }

        /* decorative blobs */
        .hero::before {
            content: "";
            position: absolute;
            top: -80px; right: -80px;
            width: 340px; height: 340px;
            background: #6366f1;
            border-radius: 50%;
            opacity: 0.12;
        }
        .hero::after {
            content: "";
            position: absolute;
            bottom: -100px; left: -60px;
            width: 260px; height: 260px;
            background: #a78bfa;
            border-radius: 50%;
            opacity: 0.1;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #a5b4fc;
            background: rgba(99,102,241,0.15);
            border: 1px solid rgba(99,102,241,0.3);
            padding: 5px 14px;
            border-radius: 999px;
            margin-bottom: 22px;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 16px;
        }

        .hero h1 .accent {
            background: linear-gradient(90deg, #a5b4fc, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-sub {
            font-size: 15px;
            color: #94a3b8;
            max-width: 440px;
            line-height: 1.65;
            margin-bottom: 32px;
        }

        .hero-cta-row { display: flex; gap: 12px; flex-wrap: wrap; }

        .btn-hero-primary {
            padding: 13px 28px;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            border: none;
            border-radius: 10px;
            text-decoration: none;
            box-shadow: 0 6px 20px rgba(99,102,241,0.45);
            transition: 0.2s;
        }
        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(99,102,241,0.5);
            color: #fff;
        }

        .btn-hero-ghost {
            padding: 13px 28px;
            font-size: 14px;
            font-weight: 600;
            color: #e2e8f0;
            border: 1.5px solid rgba(226,232,240,0.25);
            border-radius: 10px;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-hero-ghost:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
            border-color: rgba(226,232,240,0.5);
        }

        /* STAT PILLS inside hero */
        .hero-stats {
            display: flex;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }
        .hero-stat {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #94a3b8;
        }
        .hero-stat strong {
            font-size: 18px;
            font-weight: 700;
            color: #e2e8f0;
        }

        /* SECTION HEADER */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
        }
        .section-sub {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }

        /* NOTE CARD */
        .pdf-grid-card {
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            background: #fff;
            overflow: hidden;
            transition: 0.25s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .pdf-grid-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.09);
            border-color: #c7d2fe;
        }

        .preview-container {
            position: relative;
            height: 170px;
            background: #f1f5f9;
            overflow: hidden;
        }
        .preview-container iframe {
            width: 100%;
            height: 100%;
            border: none;
            pointer-events: none;
        }

        /* lock overlay */
        .login-gate {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(15,23,42,0.45);
            backdrop-filter: blur(3px);
            text-decoration: none;
            transition: 0.2s;
        }
        .login-gate:hover { background: rgba(15,23,42,0.55); }

        .lock-icon {
            background: #fff;
            color: #0f172a;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        }

        .badge-subject {
            display: inline-block;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 6px;
            letter-spacing: 0.3px;
        }

        .btn-access {
            display: block;
            text-align: center;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 9px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-access:hover {
            opacity: 0.9;
            color: #fff;
        }

        /* no-preview placeholder */
        .no-preview {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            gap: 6px;
        }
        .no-preview span { font-size: 28px; }

        /* FOOTER */
        .footer-guest {
            background: #0f172a;
            color: #64748b;
            text-align: center;
            padding: 20px;
            font-size: 12px;
        }
        .footer-guest a { color: #6366f1; text-decoration: none; }

        /* ENTRANCE ANIMATION */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.5s ease both; }
        .delay-1 { animation-delay: 0.08s; }
        .delay-2 { animation-delay: 0.16s; }
        .delay-3 { animation-delay: 0.24s; }

        /* RESPONSIVE */
        @media (max-width: 576px) {
            .hero { padding: 50px 0 60px; }
            .hero-stats { gap: 14px; }
        }
    </style>
</head>
<body>

{{-- ===== NAV ===== --}}
<nav class="navbar-guest">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="nav-logo">NOTE<span>PORTAL</span></a>
        <div class="d-flex gap-2">
            <a href="{{ url('login') }}" class="btn-nav-login">Login</a>
            <a href="{{ url('register') }}" class="btn-nav-register">Join Free</a>
        </div>
    </div>
</nav>

{{-- ===== HERO ===== --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-eyebrow fade-up">
                    📚 Academic Note Sharing
                </div>
                <h1 class="fade-up delay-1">
                    All your study notes,<br>
                    <span class="accent">one place.</span>
                </h1>
                <p class="hero-sub fade-up delay-2">
                    Browse public notes from students across subjects and categories.
                    Login to download, upload your own, and keep your favorites.
                </p>
                <div class="hero-cta-row fade-up delay-3">
                    <a href="{{ url('register') }}" class="btn-hero-primary">Get Started Free</a>
                    <a href="{{ url('login') }}" class="btn-hero-ghost">Login →</a>
                </div>

                <div class="hero-stats fade-up delay-3">
                    <div class="hero-stat">
                        {{-- <strong>{{ $notes->total() ?? '100+' }}</strong> --}}
                        <span>Public Notes</span>
                    </div>
                    <div class="hero-stat" style="padding-left:16px; border-left:1px solid rgba(255,255,255,0.1)">
                        <strong>Free</strong>
                        <span>Always</span>
                    </div>
                    <div class="hero-stat" style="padding-left:16px; border-left:1px solid rgba(255,255,255,0.1)">
                        <strong>PDF &amp; Video</strong>
                        <span>Supported</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== NOTES GRID ===== --}}
<div class="container py-5">
    <div class="section-header">
        <div>
            <div class="section-title">📖 Browse Public Notes</div>
            <div class="section-sub">Login or register to download and access full content</div>
        </div>
        <a href="{{ url('login') }}" class="btn-nav-login" style="font-size:12px;">
            Login to Access →
        </a>
    </div>

    <div class="row g-3">
        @forelse($notes as $n)
            <div class="col-6 col-md-4 col-xl-3">
                <div class="pdf-grid-card h-100">

                    <div class="preview-container">
                        @if($n->filePath && $n->filePath->isNotEmpty())
                            <iframe
                                src="{{ url('view-file/'.$n->filePath->first()->file_path) }}#toolbar=0&page=1&view=FitH"
                                loading="lazy"
                                title="{{ $n->title }} preview">
                            </iframe>
                        @else
                            <div class="no-preview">
                                @if($n->youtubeLink && $n->youtubeLink->isNotEmpty())
                                    <span>▶</span>
                                    <small style="font-size:10px; font-weight:600;">VIDEO LESSON</small>
                                @else
                                    <span>📄</span>
                                    <small style="font-size:10px;">No Preview</small>
                                @endif
                            </div>
                        @endif

                        <a href="{{ url('login') }}" class="login-gate">
                            <div class="lock-icon">🔒 Login to View</div>
                        </a>
                    </div>

                    <div class="card-body p-3">
                        <span class="badge-subject">
                            {{ $n->subject->sub_name ?? 'General' }}
                        </span>
                        <h6 class="mt-2 mb-1 fw-bold text-truncate" style="color:#1e293b; font-size:13px;">
                            {{ $n->title }}
                        </h6>
                        <p class="text-muted mb-3" style="font-size:11px;">
                            By {{ $n->user->name ?? 'System' }}
                        </p>
                        <a href="{{ url('login') }}" class="btn-access">
                            Access Document
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                <div style="font-size:40px;">📭</div>
                <p class="mt-2">No public notes yet. Be the first to share!</p>
                <a href="{{ url('register') }}" class="btn-nav-register">Register &amp; Upload</a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    {{-- @if($notes->hasPages())
        <div class="d-flex justify-content-center mt-5 small-pagination">
            {{ $notes->links('pagination::bootstrap-5') }}
        </div>
    @endif --}}
</div>

{{-- ===== FOOTER ===== --}}
<footer class="footer-guest">
    © 2026 NotePortal &nbsp;|&nbsp; Academic Notes Sharing Platform &nbsp;|&nbsp;
    <a href="{{ url('login') }}">Login</a> &nbsp;·&nbsp;
    <a href="{{ url('register') }}">Register</a>
</footer>

</body>
</html>