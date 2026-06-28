@extends('layouts.admin_layout')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#0f172a;">Admin Dashboard</h4>
        <small class="text-muted">{{ date('l, d F Y') }}</small>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-3">
        <a href="{{ url('admin/showUsersList') }}" class="text-decoration-none">
            <div class="dashboard-card">
                <p class="card-title">👥 Total Users</p>
                <h4 class="card-number purple">{{ $totalUser }}</h4>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <div class="dashboard-card">
            <p class="card-title">📄 Total Notes</p>
            <h4 class="card-number green">{{ $totalNotes }}</h4>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ url('list_category') }}" class="text-decoration-none">
            <div class="dashboard-card">
                <p class="card-title">📂 Categories</p>
                <h4 class="card-number orange">{{ $totalCategory }}</h4>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ url('list_subject') }}" class="text-decoration-none">
            <div class="dashboard-card">
                <p class="card-title">📚 Subjects</p>
                <h4 class="card-number" style="color:#0ea5e9;">{{ $totalSubjects }}</h4>
            </div>
        </a>
    </div>

</div>

<hr class="my-4">

{{-- ===== SECTION HEADER ===== --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0" style="color:#0f172a;">All Notes</h5>
        <small class="text-muted">Browse and filter every uploaded note</small>
    </div>
    <a href="{{ url('admin/showPendingNotesList') }}" class="browse-btn">
        🕒 Pending Notes
    </a>
</div>

{{-- ===== SEARCH / FILTER ===== --}}
<form method="GET" action="{{ url('admin_dashboard') }}" class="mb-3">
    <div class="search-pill">
        <span>🔍</span>
        <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Search by title or uploader..."
            value="{{ request('search') }}"
        >

        <select name="category" class="filter-select">
            <option value="">Category</option>
            @foreach($category ?? [] as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->cat_name }}
                </option>
            @endforeach
        </select>

        <select name="subject" class="filter-select">
            <option value="">Subject</option>
            @foreach($subject ?? [] as $sub)
                <option value="{{ $sub->id }}" {{ request('subject') == $sub->id ? 'selected' : '' }}>
                    {{ $sub->sub_name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="search-btn">Filter</button>

        @if(request('search') || request('category') || request('subject'))
            <a href="{{ url('admin_dashboard') }}" class="clear-btn">✕</a>
        @endif
    </div>
</form>

{{-- ===== NOTES TABLE ===== --}}
<div class="card category-card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table clean-table mb-0">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Title</th>
                        <th>Uploader</th>
                        <th>Category</th>
                        <th>Subject</th>
                        <th style="width:120px;">Files</th>
                        <th style="width:100px;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notes as $note)
                        <tr style="vertical-align:middle;">
                            <td class="text-muted" style="font-size:11px;">
                                {{ $notes->firstItem() + $loop->index }}
                            </td>
                            <td>
                                <div class="text-truncate fw-semibold" style="max-width:180px; font-size:13px; color:#1e293b;">
                                    {{ $note->title }}
                                </div>
                            </td>
                            <td class="text-nowrap" style="font-size:12px;">
                                {{ $note->user->name ?? '—' }}
                            </td>
                            <td>
                                <span class="badge-soft-info" style="font-size:11px; padding:3px 8px; border-radius:6px; display:inline-block;">
                                    {{ $note->category->cat_name ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-soft-secondary" style="font-size:11px; padding:3px 8px; border-radius:6px; display:inline-block;">
                                    {{ $note->subject->sub_name ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    @foreach($note->filePath ?? [] as $fp)
                                        <a href="{{ url('view-file/'.$fp->file_path) }}"
                                           target="_blank"
                                           class="browse-btn"
                                           style="font-size:10px; padding:3px 7px;"
                                           title="View PDF">
                                            📄
                                        </a>
                                    @endforeach
                                    @if($note->youtubeLink && $note->youtubeLink->count())
                                        @foreach($note->youtubeLink as $yt)
                                            @if(!empty($yt->youtube_link))
                                                <a href="{{ $yt->youtube_link }}"
                                                   target="_blank"
                                                   rel="noopener noreferrer"
                                                   class="admin-yt-btn"
                                                   title="Watch video">
                                                    ▶
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="text-muted" style="font-size:11px; white-space:nowrap;">
                                {{ $note->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <div style="font-size:32px; margin-bottom:8px;">📭</div>
                                No notes found
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
    {{ $notes->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

<style>
.admin-yt-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #ef4444;
    color: white;
    font-size: 10px;
    padding: 3px 7px;
    border-radius: 5px;
    text-decoration: none;
    transition: 0.2s;
}
.admin-yt-btn:hover { background: #dc2626; color: white; }
</style>

@endsection