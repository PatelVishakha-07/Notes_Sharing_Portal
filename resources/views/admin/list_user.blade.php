@extends('layouts.admin_layout')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#0f172a;">👥 Users List</h4>
        <small class="text-muted">Manage and monitor all registered users</small>
    </div>
</div>

{{-- ===== SEARCH ===== --}}
<form method="GET" action="{{ url('admin/showUsersList') }}" class="mb-3">
    <div class="search-pill">
        <span>🔍</span>
        <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Search by name or email..."
            value="{{ request('search') }}"
        >
        <button type="submit" class="search-btn">Search</button>
        @if(request('search'))
            <a href="{{ url('admin/showUsersList') }}" class="clear-btn">✕</a>
        @endif
    </div>
</form>

{{-- ===== TABLE ===== --}}
<div class="card category-card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table clean-table mb-0">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th style="width:120px;">Status</th>
                        <th style="width:120px; text-align:center;">Notes</th>
                        <th style="width:130px; text-align:center;">Rejected</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="vertical-align:middle;">

                            <td class="text-muted" style="font-size:11px;">
                                {{ $users->firstItem() + $loop->index }}
                            </td>

                            <td class="fw-semibold" style="font-size:13px; color:#1e293b;">
                                {{ $user->name }}
                            </td>

                            <td class="text-muted" style="font-size:12px;">
                                {{ $user->email }}
                            </td>

                            <td>
                                {{-- 
                                    Bug fix: was using <a> tags for state-changing actions.
                                    Using a small form+button is semantically correct for
                                    actions that change server state, even for GET routes.
                                --}}
                                <form
                                    method="GET"
                                    action="{{ url('admin/toggle-user-status/'.$user->id) }}"
                                    onsubmit="return confirm('{{ $user->status == 1 ? 'Deactivate' : 'Activate' }} this user?')"
                                    style="display:inline;">
                                    <button
                                        type="submit"
                                        class="user-status-btn {{ $user->status == 1 ? 'status-active' : 'status-inactive' }}">
                                        {{ $user->status == 1 ? '✔ Active' : '✖ Inactive' }}
                                    </button>
                                </form>
                            </td>

                            <td class="text-center fw-semibold" style="color:#1e293b;">
                                {{ $user->approved_notes_count ?? 0 }}
                            </td>

                            <td class="text-center">
                                @if(($user->rejected_notes_count ?? 0) > 0)
                                    <span style="color:#ef4444; font-weight:600;">
                                        {{ $user->rejected_notes_count }}
                                    </span>
                                @else
                                    <span class="text-muted">0</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            {{-- Bug fix: was colspan="5" but there are 6 columns --}}
                            <td colspan="6" class="text-center text-muted py-5">
                                <div style="font-size:32px; margin-bottom:8px;">👤</div>
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ===== PAGINATION ===== --}}
<div class="mt-3 small-pagination">
    {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

<style>
.user-status-btn {
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    transition: 0.2s;
    white-space: nowrap;
}
.status-active {
    background: #dcfce7;
    color: #16a34a;
}
.status-active:hover {
    background: #16a34a;
    color: white;
}
.status-inactive {
    background: #fee2e2;
    color: #dc2626;
}
.status-inactive:hover {
    background: #dc2626;
    color: white;
}
</style>

@endsection