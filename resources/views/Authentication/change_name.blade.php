@extends(auth()->user()->role == 'Admin' ? 'layouts.admin_layout' : 'layouts.user_layout')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">

    <div class="card shadow-sm p-4" style="width: 420px; border-radius: 12px;">

        <h4 class="text-center mb-1">👤 Change Name</h4>
        <p class="text-center text-muted mb-4" style="font-size: 13px;">
            Update your display name
        </p>

        {{-- Error INSIDE the card --}}
        @error('name')
            <div class="alert-error mb-3" role="alert">{{ $message }}</div>
        @enderror

        @if(session('success'))
            <div class="mb-3 p-3 rounded" style="background:#dcfce7; border:1px solid #86efac; color:#166534;" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ url('update_name') }}"
            onsubmit="return confirm('Are you sure you want to update your name?')"
        >
            @csrf

            <!-- Current Name (read-only, not submitted) -->
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:13px;">Current Name</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ auth()->user()->name }}"
                    disabled
                    aria-label="Current name"
                >
            </div>

            <!-- New Name -->
            <div class="mb-3">
                <label for="new-name" class="form-label fw-semibold" style="font-size:13px;">New Name</label>
                <input
                    type="text"
                    id="new-name"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Enter new name"
                    autocomplete="name"
                    maxlength="100"
                    value="{{ old('name') }}"
                    required
                >
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    Update Name
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

@endsection