@extends(auth()->user()->role == 'Admin' ? 'layouts.admin_layout' : 'layouts.user_layout')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">

    <div class="card shadow-sm p-4" style="width: 400px; border-radius: 12px;">
        
        <h4 class="text-center mb-3">👤 Change Name</h4>
        <p class="text-center text-muted mb-4" style="font-size: 14px;">
            Update your display name
        </p>

        <form method="POST" action="{{ url('update_name') }}">
            @csrf

            <!-- Current Name -->
            <div class="mb-3">
                <label class="form-label">Current Name</label>
                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
            </div>

            <!-- New Name -->
            <div class="mb-3">
                <label class="form-label">New Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter new name">
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between mt-4">                
                <button type="submit" class="btn btn-primary">Update Name</button>

                @php
                    $dashboard = auth()->user()->role == 'Admin' ? 'admin/dashboard' : 'user/dashboard';
                @endphp

                <a href="{{ auth()->user()->role == 'Admin' ? url('admin_dashboard') : url('user_dashboard') }}" 
                    class="btn btn-secondary ms-5">
                        Cancel
                </a>
            </div>

        </form>
    </div>

</div>

@endsection