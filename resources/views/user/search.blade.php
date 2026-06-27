@extends('layouts.user_layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#0f172a;">🔎 Search Notes</h4>
        <small class="text-muted">Search public notes or access a private note with a code</small>
    </div>
</div>

{{-- ===== SEARCH FORM ===== --}}
<div class="search-panel mb-4">
    <h6 class="search-panel-title">Search Public Notes</h6>
    <form method="POST" action="{{ url('user/search_notes') }}" id="searchForm">
        @csrf
        <div class="search-form-grid">

            <div>
                <label class="upload-label">Uploader Name</label>
                <input
                    type="text"
                    name="username"
                    class="upload-input"
                    placeholder="e.g. John"
                    value="{{ old('username') }}"
                >
            </div>

            <div>
                <label class="upload-label">Category</label>
                <select name="cat_id" class="upload-input">
                    <option value="">All Categories</option>
                    @foreach($category as $c)
                        <option value="{{ $c->id }}" {{ old('cat_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->cat_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="upload-label">Subject</label>
                <select name="sub_id" class="upload-input">
                    <option value="">All Subjects</option>
                    @foreach($subject as $s)
                        <option value="{{ $s->id }}" {{ old('sub_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->sub_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="upload-label">Note Title</label>
                <input
                    type="text"
                    name="title"
                    class="upload-input"
                    placeholder="e.g. Chapter 3"
                    value="{{ old('title') }}"
                >
            </div>

        </div>

        <div class="mt-3">
            <button type="submit" class="btn-upload-submit">🔍 Search Notes</button>
        </div>
    </form>
</div>

{{-- ===== PRIVATE NOTE ACCESS ===== --}}
<div class="search-panel mb-4">
    <h6 class="search-panel-title">🔑 Access Private Note</h6>
    <p class="text-muted mb-3" style="font-size:12px;">
        Have an access code? Enter it below to view a private note.
    </p>

    @if(session('error'))
        <div class="upload-alert-error mb-3" role="alert">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('user/access_private_note') }}">
        @csrf
        <div class="d-flex gap-2 flex-wrap">
            <input
                type="text"
                name="access_code"
                class="upload-input"
                style="max-width:320px; letter-spacing:2px; font-weight:600;"
                placeholder="Enter Access Code"
                maxlength="20"
                required
            >
            <button type="submit" class="btn-upload-submit">Open Private Note</button>
        </div>
    </form>
</div>

{{-- ===== SEARCH RESULTS ===== --}}
@if(isset($notes))
<div class="search-panel">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="search-panel-title mb-0">📒 Search Results</h6>
        <span class="text-muted" style="font-size:12px;">{{ $notes->total() }} result(s)</span>
    </div>

    <div class="table-responsive">
        <table class="custom-table clean-table mb-0">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Title</th>
                    <th>Uploader</th>
                    <th>Category</th>
                    <th>Subject</th>
                    <th style="width:140px;">Files</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notes as $n)
                    <tr>
                        <td class="text-muted" style="font-size:11px;">
                            {{ $notes->firstItem() + $loop->index }}
                        </td>
                        <td class="fw-bold" style="font-size:12px; color:#1e293b;">
                            {{ Str::limit($n->title, 40) }}
                        </td>
                        <td>
                            <span class="badge badge-soft-success">{{ $n->user->name }}</span>
                        </td>
                        <td>
                            <span class="badge badge-soft-info">{{ $n->category->cat_name }}</span>
                        </td>
                        <td>
                            <span class="badge badge-soft-secondary">{{ $n->subject->sub_name }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($n->filePath as $fp)
                                    <a href="{{ url('view-file/'.$fp->file_path) }}"
                                       target="_blank"
                                       class="note-btn-view btn btn-sm py-0 px-2"
                                       style="font-size:10px;">
                                        View
                                    </a>
                                @endforeach

                                @if($n->youtubeLink && $n->youtubeLink->isNotEmpty())
                                    @foreach($n->youtubeLink as $yt)
                                        @if(!empty($yt->youtube_link))
                                            <a href="{{ $yt->youtube_link }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="note-btn-yt btn btn-sm py-0 px-2"
                                               style="font-size:10px;">
                                                Watch
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    {{-- Bug fix: was colspan="5", there are 6 columns --}}
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            🔍 No notes found. Try different search terms.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($notes->hasPages())
        <div class="mt-3 small-pagination">
            {{ $notes->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endif

<style>
.search-panel {
    background: white;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    padding: 22px;
}
.search-panel-title {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 14px;
}
.search-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.upload-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 5px;
}
.upload-input {
    width: 100%;
    padding: 8px 12px;
    font-size: 13px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: #f9fafb;
    color: #111827;
    transition: 0.2s;
    outline: none;
}
.upload-input:focus {
    border-color: #6366f1;
    background: white;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
}
.btn-upload-submit {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: white;
    font-size: 13px;
    font-weight: 700;
    padding: 9px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(99,102,241,0.25);
    transition: 0.2s;
    white-space: nowrap;
}
.btn-upload-submit:hover { opacity: 0.9; transform: translateY(-1px); }

.upload-alert-error {
    background: #fee2e2;
    border: 1px solid #f87171;
    color: #b91c1c;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
}

.note-btn-view { background:#4f46e5 !important; color:white !important; border-radius:5px; }
.note-btn-yt { background:#ef4444 !important; color:white !important; border-radius:5px; }

@media (max-width: 576px) {
    .search-form-grid { grid-template-columns: 1fr; }
}
</style>

@endsection