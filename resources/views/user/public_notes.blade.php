@extends('layouts.user_layout')

@section('content')

{{-- ===== HEADER + FILTER FORM ===== --}}
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-0" style="color:#0f172a;">🌍 Public Notes</h4>
        <small class="text-muted">Browse all publicly shared notes</small>
    </div>
</div>

<form method="GET" action="{{ url('user/all_notes') }}" class="mb-4">
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
            <a href="{{ url('user/all_notes') }}" class="clear-btn">✕</a>
        @endif
    </div>
</form>

{{-- ===== GRID ===== --}}
<div class="row g-3">
    @forelse($notes as $note)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="note-grid-card position-relative h-100">

                {{-- FAV BUTTON --}}
                {{-- Bug fix: was $note->is_favorite (wrong), correct key is is_favourite --}}
                <button
                    onclick="toggleFav({{ $note->id }}, this)"
                    class="favorite-btn {{ $note->is_favourite ? 'fav-active' : '' }}"
                    aria-label="{{ $note->is_favourite ? 'Remove from favourites' : 'Add to favourites' }}">
                    {{ $note->is_favourite ? '★' : '☆' }}
                </button>

                {{-- PREVIEW --}}
                <div class="note-preview-box">
                    @if(isset($note->filePath[0]))
                        <iframe
                            src="{{ url('/view-file/'.$note->filePath[0]->file_path) }}#page=1&zoom=00"
                            style="width:100%; height:100%; border:none; pointer-events:none;"
                            loading="lazy"
                            title="{{ $note->title }} preview">
                        </iframe>
                    @elseif($note->youtubeLink && $note->youtubeLink->count() > 0)
                        <div style="font-size:28px; color:#ef4444;">▶</div>
                        <small class="note-preview-label">VIDEO LESSON</small>
                    @else
                        <div style="font-size:24px; color:#94a3b8;">📄</div>
                        <small class="note-preview-label">No Preview</small>
                    @endif
                </div>

                {{-- CARD BODY --}}
                <div class="p-3">
                    <span class="subject-badge-pill">{{ $note->subject->sub_name ?? 'General' }}</span>

                    <h6 class="mt-2 mb-0 fw-bold text-truncate" style="font-size:13px; color:#0f172a;">
                        {{ $note->title }}
                    </h6>
                    <p class="mb-3 mt-1" style="font-size:11px; color:#64748b;">
                        👤 {{ $note->user->name ?? 'Unknown' }}
                    </p>

                    {{-- FILE ACTIONS --}}
                    @if(isset($note->filePath[0]))
                        <div class="d-flex gap-1 mb-2">
                            <a href="{{ url('/view-file/'.$note->filePath[0]->file_path) }}"
                               target="_blank"
                               class="btn btn-sm note-btn-view flex-grow-1">
                                View
                            </a>
                            <a href="{{ url('/view-file/'.$note->filePath[0]->file_path) }}"
                               class="btn btn-sm note-btn-dl px-2"
                               title="Download">
                                ↓
                            </a>
                        </div>
                    @endif

                    {{-- YOUTUBE LINKS --}}
                    @if($note->youtubeLink && $note->youtubeLink->count() > 0)
                        <div class="d-flex flex-column gap-1">
                            @foreach($note->youtubeLink as $idx => $link)
                                @if(!empty($link->youtube_link))
                                    <a href="{{ $link->youtube_link }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="btn btn-sm note-btn-yt">
                                        🎥 Watch Video{{ $idx > 0 ? ' '.($idx+1) : '' }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">
            <div style="font-size:38px;">🔍</div>
            <p class="mt-2">No notes found. Try adjusting your filters.</p>
            <a href="{{ url('user/all_notes') }}" class="btn-add text-decoration-none py-2 px-4">Clear Filters</a>
        </div>
    @endforelse
</div>

{{-- ===== PAGINATION ===== --}}
<div class="d-flex justify-content-center mt-4 small-pagination">
    {{ $notes->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

<script>
function toggleFav(noteId, btn) {
    $.ajax({
        url: '/user/add_to_fav/' + noteId,
        type: 'POST',
        data: { _token: '{{ csrf_token() }}' },
        success: function(data) {
            if (data.status === 'added') {
                $(btn).html('★').addClass('fav-active');
            } else {
                $(btn).html('☆').removeClass('fav-active');
            }
        },
        error: function() {
            alert('Something went wrong. Please try again.');
        }
    });
}
</script>

<style>
.note-grid-card {
    border-radius: 14px;
    background: white;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    transition: 0.25s ease;
    overflow: hidden;
}
.note-grid-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    border-color: #c7d2fe;
}
.note-preview-box {
    width: 100%;
    aspect-ratio: 16/9;
    background: #f1f5f9;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #e2e8f0;
    overflow: hidden;
    gap: 4px;
}
.note-preview-label { font-size: 10px; font-weight: 700; color: #64748b; letter-spacing: 0.5px; text-transform: uppercase; }
.subject-badge-pill {
    display: inline-block;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 10px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 6px;
}
.note-btn-view { background:#4f46e5; color:white; font-size:11px; font-weight:600; border-radius:6px; padding: 5px 0; }
.note-btn-view:hover { background:#4338ca; color:white; }
.note-btn-dl { border:1px solid #d1fae5; color:#059669; background:#f0fdf4; font-size:13px; border-radius:6px; }
.note-btn-dl:hover { background:#059669; color:white; border-color:#059669; }
.note-btn-yt { background:#ef4444; color:white; font-size:11px; font-weight:600; border-radius:6px; }
.note-btn-yt:hover { background:#dc2626; color:white; }
</style>

@endsection