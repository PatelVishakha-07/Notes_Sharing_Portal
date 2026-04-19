@extends(auth()->user()->role == 'Admin' ? 'layouts.admin_layout' : 'layouts.user_layout')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">

    <div class="card shadow-sm p-4" style="width: 400px; border-radius: 12px;">
        
        <h4 class="text-center mb-3">🔒 Change Password</h4>
        <p class="text-center text-muted mb-4" style="font-size: 14px;">
            Keep your account secure by updating your password
        </p>

        <form method="POST" action="{{ url('update_password') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="new_password" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
            </div>

            <div class="d-flex justify-content-between mt-4">                
                <button type="submit" class="btn btn-primary">Update Password</button>

                <a href="{{ auth()->user()->role == 'Admin' ? url('admin_dashboard') : url('user_dashboard') }}" 
                    class="btn btn-secondary ms-5">
                        Cancel
                </a>
            </div>

        </form>
    </div>

</div>

@endsection