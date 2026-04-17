@extends('layouts.admin_layout')

@section('content')

<h3 class="mb-3">Admin Dashboard</h3>

{{-- ================= STATS CARDS ================= --}}
<div class="row g-3 mt-2">

    <div class="col-md-3 col-6">
        <a href="{{ url('admin/showUsersList') }}" class="text-decoration-none">
            <div class="dashboard-card">
                <p class="card-title">Total Users</p>
                <h4 class="card-number">{{ $totalUser }}</h4>
            </div>
        </a>
    </div>

    <div class="col-md-3 col-6">
        <div class="dashboard-card">
            <p class="card-title">Total Notes</p>
            <h4 class="card-number">{{ $totalNotes }}</h4>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <a href="{{ url('list_category') }}" class="text-decoration-none">
            <div class="dashboard-card">
                <p class="card-title">Total Categories</p>
                <h4 class="card-number">{{ $totalCategory }}</h4>
            </div>
        </a>
    </div>

    <div class="col-md-3 col-6">
        <a href="{{ url('list_subject') }}" class="text-decoration-none">
            <div class="dashboard-card">
                <p class="card-title">Total Subjects</p>
                <h4 class="card-number">{{ $totalSubjects }}</h4>
            </div>
        </a>
    </div>

</div>

{{-- ================= SECTION TITLE ================= --}}
<hr class="my-4">

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h4 class="mb-0">All Notes</h4>
</div>

{{-- ================= SEARCH BAR ================= --}}
<form method="GET" action="{{ url('admin_dashboard') }}" class="mt-3 mb-3">

    <div class="search-pill">

        <span>🔍</span>

        <input type="text"
               name="search"
               class="search-input"
               placeholder="Search notes..."
               value="{{ request('search') }}">

        <select name="category" class="filter-select">
            <option value="">Category</option>
            @foreach($category ?? [] as $cat)
                <option value="{{ $cat->id }}"
                    {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->cat_name }}
                </option>
            @endforeach
        </select>

        <select name="subject" class="filter-select">
            <option value="">Subject</option>
            @foreach($subject ?? [] as $sub)
                <option value="{{ $sub->id }}"
                    {{ request('subject') == $sub->id ? 'selected' : '' }}>
                    {{ $sub->sub_name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="search-btn">
            Filter
        </button>

        @if(request('search') || request('category') || request('subject'))
            <a href="{{ url('admin_dashboard') }}" class="clear-btn">✕</a>
        @endif

    </div>

</form>

{{-- ================= TABLE ================= --}}
<div class="card category-card border-0 shadow-sm">
    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table admin-table clean-table mb-0">

                <thead>
                    <tr>
                        <th style="width:50px;">ID</th>
                        <th>Title</th>
                        <th>User</th>
                        <th>Category</th>
                        <th>Subject</th>
                        <th style="width:120px;">Actions</th>
                        <th style="width:100px;">Date</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($notes as $note)

                    <tr style="vertical-align: middle;">

                        <td class="text-muted">{{ $note->id }}</td>

                        <td>
                            <div class="text-truncate" style="max-width:180px;">
                                {{ $note->title }}
                            </div>
                        </td>

                        <td class="text-nowrap">
                            {{ $note->user->name ?? '-' }}
                        </td>

                        <td>
                            <span class="badge bg-light text-dark"
                                  style="font-size:11px; padding:4px 8px;">
                                {{ $note->category->cat_name ?? '-' }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-light text-dark"
                                  style="font-size:11px; padding:4px 8px;">
                                {{ $note->subject->sub_name ?? '-' }}
                            </span>
                        </td>

                        {{-- ACTIONS --}}
                        <td>
                            <div class="d-flex gap-1 flex-wrap">

                                @foreach ($note->filePath ?? [] as $fp)
                                    <a href="{{ url('view-file/'.$fp->file_path) }}"
                                       target="_blank"
                                       class="browse-btn"
                                       style="font-size:10px; padding:3px 7px;">
                                        📄
                                    </a>
                                @endforeach

                                @foreach ($note->youtubeLink ?? [] as $yt)
                                    <a href="{{ $yt->youtube_link }}"
                                       target="_blank"
                                       class="browse-btn"
                                       style="background:#ef4444;
                                              font-size:10px;
                                              padding:3px 7px;">
                                        ▶
                                    </a>
                                @endforeach

                            </div>
                        </td>

                        <td class="text-muted" style="font-size:11px;">
                            {{ $note->created_at->format('d M Y') }}
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No notes found
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>
{{-- ================= PAGINATION ================= --}}
<div class="mt-3 small-pagination">
    {{ $notes->appends(request()->query())->links() }}
</div>

<style>
.small-pagination {
    font-size: 12px;
}

.small-pagination svg {
    width: 14px !important;
    height: 14px !important;
}

.small-pagination .page-link {
    padding: 4px 8px !important;
    font-size: 12px !important;
    line-height: 1 !important;
}
</style>

@endsection