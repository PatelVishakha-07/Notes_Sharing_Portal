@extends('layouts.user_layout')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#0f172a;">📒 My Notes</h4>
        <small class="text-muted">
            Showing {{ ucfirst(strtolower($status)) }} notes
        </small>
    </div>
    <a href="{{ url('user/upload_notes') }}" class="btn-add text-decoration-none py-2 px-3">
        + Add New Note
    </a>
</div>

{{-- ===== FILTER BAR ===== --}}
<form method="GET" action="{{ url('user/list_'.Str::lower($status).'_notes/'.$status) }}" class="mb-4">
    <div class="search-pill">
        <input
            type="text"
            name="search"
            class="search-input"
            placeholder="🔍 Search notes..."
            value="{{ request('search') }}"
        >

        <select name="cat_id" class="filter-select">
            <option value="">All Categories</option>
            @foreach($category as $c)
                <option value="{{ $c->id }}" {{ request('cat_id') == $c->id ? 'selected' : '' }}>
                    {{ $c->cat_name }}
                </option>
            @endforeach
        </select>

        <select name="sub_id" class="filter-select">
            <option value="">All Subjects</option>
            @foreach($subject as $s)
                <option value="{{ $s->id }}" {{ request('sub_id') == $s->id ? 'selected' : '' }}>
                    {{ $s->sub_name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="search-btn">Search</button>

        @if(request('search') || request('cat_id') || request('sub_id'))
            <a href="{{ url('user/list_'.Str::lower($status).'_notes/'.$status) }}" class="clear-btn">✕</a>
        @endif
    </div>
</form>

{{-- ===== TABLE ===== --}}
<div class="card border-0 shadow-sm category-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="custom-table clean-table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3" style="width:55px;">#</th>
                        <th style="width:200px;">Title</th>
                        <th>Category</th>
                        <th>Subject</th>
                        <th style="width:100px;">Status</th>
                        <th style="width:90px;">Date</th>
                        @if($status == 'Private')
                            <th style="width:100px;">Code</th>
                        @endif
                        <th style="width:110px;">Files</th>
                        <th class="text-end pe-3" style="width:110px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($notes as $n)
                        <tr style="vertical-align:middle;">

                            <td class="ps-3 text-muted" style="font-size:11px;">
                                {{ $notes->firstItem() + $loop->index }}
                            </td>

                            <td class="fw-semibold" style="font-size:12px; color:#1e293b; line-height:1.4;">
                                {{ Str::limit($n->title, 35) }}
                            </td>

                            <td>
                                <span class="badge-soft-info" style="font-size:10px; padding:3px 8px; border-radius:5px; display:inline-block; white-space:nowrap;">
                                    {{ $n->category->cat_name }}
                                </span>
                            </td>

                            <td>
                                <span class="badge-soft-secondary" style="font-size:10px; padding:3px 8px; border-radius:5px; display:inline-block; white-space:nowrap;">
                                    {{ $n->subject->sub_name }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $statusColors = [
                                        'Approved' => ['#dcfce7','#16a34a'],
                                        'Pending'  => ['#fef9c3','#ca8a04'],
                                        'Rejected' => ['#fee2e2','#dc2626'],
                                        'Public'   => ['#e0f2fe','#0284c7'],
                                        'Private'  => ['#f3e8ff','#7c3aed'],
                                    ];
                                    $sc = $statusColors[$n->status] ?? ['#f1f5f9','#64748b'];
                                @endphp
                                <span style="
                                    display:inline-block;
                                    background:{{ $sc[0] }};
                                    color:{{ $sc[1] }};
                                    font-size:10px;
                                    font-weight:700;
                                    padding:3px 8px;
                                    border-radius:20px;
                                    white-space:nowrap;">
                                    {{ $n->status }}
                                </span>
                            </td>

                            <td class="text-muted" style="font-size:11px; white-space:nowrap;">
                                {{ $n->created_at->format('d M y') }}
                            </td>

                            @if($status == 'Private')
                                <td>
                                    <div class="d-flex flex-column gap-1 align-items-center">
                                        <code style="font-size:10px; background:#eef2ff; color:#4f46e5; padding:2px 6px; border-radius:4px; font-weight:700; letter-spacing:1px;">
                                            {{ $n->access_code }}
                                        </code>
                                        <button
                                            type="button"
                                            onclick="copyCode('{{ $n->access_code }}')"
                                            class="list-copy-btn">
                                            Copy
                                        </button>
                                    </div>
                                </td>
                            @endif

                            <td>
                                @foreach($n->filePath as $fp)
                                    <div class="d-flex gap-1 mb-1">
                                        <a href="{{ url('view-file/'.$fp->file_path) }}"
                                           target="_blank"
                                           class="list-file-btn list-view-btn">
                                            View
                                        </a>
                                        <a href="{{ asset('storage/'.$fp->file_path) }}"
                                           download
                                           class="list-file-btn list-dl-btn"
                                           title="Download">
                                            ↓
                                        </a>
                                    </div>
                                @endforeach

                                @if($n->youtubeLink && $n->youtubeLink->count() > 0)
                                    @foreach($n->youtubeLink as $yt)
                                        @if(!empty($yt->youtube_link))
                                            <a href="{{ $yt->youtube_link }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="list-file-btn list-yt-btn mb-1">
                                                ▶ Watch
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </td>

                            <td class="text-end pe-3">
                                <div class="d-flex flex-column gap-1 align-items-end">
                                    <a href="{{ url('user/edit_notes_page/'.$n->id) }}"
                                       class="list-action-btn list-edit-btn">
                                        Edit
                                    </a>
                                    {{-- Bug fix: was GET link — changed to POST form so browsers
                                         and crawlers cannot trigger accidental deletion --}}
                                    <form method="POST"
                                          action="{{ url('user/delete_notes/'.$n->id) }}"
                                          onsubmit="return confirm('Delete this note? This cannot be undone.')"
                                          style="display:inline;">
                                        @csrf
                                        <button type="submit" class="list-action-btn list-del-btn">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $status == 'Private' ? 9 : 8 }}" class="text-center py-5 text-muted">
                                <div style="font-size:32px; margin-bottom:8px;">🚫</div>
                                No {{ strtolower($status) }} notes yet.
                                <a href="{{ url('user/upload_notes') }}" style="color:#6366f1;" class="fw-semibold">Upload one →</a>
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

<script>
function copyCode(code) {
    navigator.clipboard.writeText(code).then(function () {
        // brief visual feedback without alert()
        event.target.textContent = '✓';
        setTimeout(() => { event.target.textContent = 'Copy'; }, 1500);
    });
}
</script>

<style>
/* File action buttons */
.list-file-btn {
    display: inline-block;
    font-size: 9px;
    font-weight: 600;
    padding: 3px 7px;
    border-radius: 5px;
    text-decoration: none;
    text-align: center;
    transition: 0.2s;
    line-height: 1.6;
}
.list-view-btn { background:#6366f1; color:white; }
.list-view-btn:hover { background:#4f46e5; color:white; }
.list-dl-btn { background:#22c55e; color:white; }
.list-dl-btn:hover { background:#16a34a; color:white; }
.list-yt-btn { background:#ef4444; color:white; }
.list-yt-btn:hover { background:#dc2626; color:white; }

/* Edit / Delete action buttons */
.list-action-btn {
    display: inline-block;
    font-size: 10px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 5px;
    text-decoration: none;
    text-align: center;
    min-width: 52px;
    transition: 0.2s;
}
.list-edit-btn { border: 1px solid #22c55e; color: #16a34a; }
.list-edit-btn:hover { background: #22c55e; color: white; }
.list-del-btn { border: 1px solid #ef4444; color: #dc2626; }
.list-del-btn:hover { background: #ef4444; color: white; }

/* Copy code button */
.list-copy-btn {
    background: none;
    border: none;
    font-size: 9px;
    color: #6366f1;
    cursor: pointer;
    text-decoration: underline;
    padding: 0;
    line-height: 1;
}
.list-copy-btn:hover { color: #4f46e5; }
</style>

@endsection