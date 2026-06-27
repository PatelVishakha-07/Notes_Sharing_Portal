@extends(auth()->user()->role == 'Admin' ? 'layouts.admin_layout' : 'layouts.user_layout')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">

    <div class="card shadow-sm p-4" style="width: 420px; border-radius: 12px;">

        <h4 class="text-center mb-1">🔒 Change Password</h4>
        <p class="text-center text-muted mb-4" style="font-size: 13px;">
            Keep your account secure by updating your password
        </p>

        {{-- Session error (e.g. wrong current password) — INSIDE the card --}}
        @if(session('error'))
            <div class="alert-error mb-3" role="alert">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="mb-3 p-3 rounded" style="background:#dcfce7; border:1px solid #86efac; color:#166534;" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ url('update_password') }}"
            onsubmit="return confirm('Are you sure you want to update your password?')"
            novalidate
        >
            @csrf

            {{-- CURRENT PASSWORD --}}
            <div class="mb-3">
                <label for="current-password" class="form-label fw-semibold" style="font-size:13px;">
                    Current Password
                </label>
                <div class="position-relative">
                    <input
                        type="password"
                        id="current-password"
                        name="current_password"
                        class="form-control pe-5 @error('current_password') is-invalid @enderror"
                        autocomplete="current-password"
                        maxlength="128"
                        required
                    >
                    <button type="button" class="pwd-eye-btn" onclick="togglePwd('current-password')" aria-label="Toggle visibility">👁</button>
                </div>
                @error('current_password')
                    <div class="alert-error mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>

            {{-- NEW PASSWORD --}}
            <div class="mb-3">
                <label for="new-password" class="form-label fw-semibold" style="font-size:13px;">
                    New Password
                </label>
                <div class="position-relative">
                    <input
                        type="password"
                        id="new-password"
                        name="new_password"
                        class="form-control pe-5 @error('new_password') is-invalid @enderror"
                        autocomplete="new-password"
                        maxlength="128"
                        required
                        oninput="updateStrength(this.value)"
                    >
                    <button type="button" class="pwd-eye-btn" onclick="togglePwd('new-password')" aria-label="Toggle visibility">👁</button>
                </div>

                {{-- Strength bar --}}
                <div id="strength-wrap" style="display:none; margin-top:6px;">
                    <div style="background:#e2e8f0; border-radius:999px; height:5px; overflow:hidden;">
                        <div id="strength-bar" style="height:100%; width:0%; border-radius:999px; transition:width 0.3s, background 0.3s;"></div>
                    </div>
                    <p id="strength-label" class="mt-1" style="font-size:11px; color:#64748b;"></p>
                </div>

                @error('new_password')
                    <div class="alert-error mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div class="mb-3">
                <label for="confirm-password" class="form-label fw-semibold" style="font-size:13px;">
                    Confirm Password
                </label>
                <div class="position-relative">
                    <input
                        type="password"
                        id="confirm-password"
                        name="confirm_password"
                        class="form-control pe-5 @error('confirm_password') is-invalid @enderror"
                        autocomplete="new-password"
                        maxlength="128"
                        required
                        oninput="checkMatch()"
                    >
                    <button type="button" class="pwd-eye-btn" onclick="togglePwd('confirm-password')" aria-label="Toggle visibility">👁</button>
                </div>
                <p id="match-msg" style="display:none; font-size:11px; margin-top:4px;"></p>
                @error('confirm_password')
                    <div class="alert-error mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    Update Password
                </button>
                <a
                    href="{{ auth()->user()->role == 'Admin' ? url('admin_dashboard') : url('user_dashboard') }}"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>
            </div>
        </form>

    </div>
</div>

<style>
    .pwd-eye-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        line-height: 1;
        padding: 0;
        color: #94a3b8;
    }
    .pwd-eye-btn:hover { color: #475569; }
</style>

<script>
    function togglePwd(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function updateStrength(value) {
        const wrap  = document.getElementById('strength-wrap');
        const bar   = document.getElementById('strength-bar');
        const label = document.getElementById('strength-label');
        if (!value) { wrap.style.display = 'none'; return; }
        wrap.style.display = 'block';

        let score = 0;
        if (value.length >= 8)          score++;
        if (/[A-Z]/.test(value))        score++;
        if (/[0-9]/.test(value))        score++;
        if (/[^A-Za-z0-9]/.test(value)) score++;

        const levels = [
            { pct: '25%',  color: '#ef4444', text: 'Weak' },
            { pct: '50%',  color: '#f97316', text: 'Fair' },
            { pct: '75%',  color: '#eab308', text: 'Good' },
            { pct: '100%', color: '#22c55e', text: 'Strong' },
        ];
        const lvl = levels[Math.max(score - 1, 0)];
        bar.style.width      = lvl.pct;
        bar.style.background = lvl.color;
        label.style.color    = lvl.color;
        label.textContent    = lvl.text;
    }

    function checkMatch() {
        const pw  = document.getElementById('new-password').value;
        const cf  = document.getElementById('confirm-password').value;
        const msg = document.getElementById('match-msg');
        if (!cf) { msg.style.display = 'none'; return; }
        msg.style.display = 'block';
        if (pw === cf) {
            msg.style.color   = '#22c55e';
            msg.textContent   = '✓ Passwords match';
        } else {
            msg.style.color   = '#ef4444';
            msg.textContent   = '✗ Passwords do not match';
        }
    }
</script>

@endsection