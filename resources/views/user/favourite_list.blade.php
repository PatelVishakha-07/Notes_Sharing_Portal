@extends('layouts.user_layout')

@section('content')

{{-- ===== HEADER ===== --}}
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-0" style="color:#0f172a;">❤️ My Favourite Notes</h4>
        <small class="text-muted">All notes you've saved for quick access</small>
    </div>

    <form method="GET" action="{{ url('user/fav_list') }}" class="d-flex gap-2 align-items-center">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="fav-search-box"
            placeholder="Search favourites..."
        >
        <button type="submit" class="search-btn">🔍</button>
        <a href="{{ url('user/all_notes') }}" class="browse-btn">📚 Browse Notes</a>
    </form>
</div>

{{-- ===== EMPTY STATE ===== --}}
@if($notes->isEmpty())
    <div class="fav-empty">
        <div style="font-size:48px; margin-bottom:12px;">💔</div>
        <h5 style="color:#374151; font-weight:700;">No Favourites Yet</h5>
        <p style="color:#6b7280; font-size:13px;">Star any note to save it here for quick access.</p>
        <a href="{{ url('user/all_notes') }}" class="btn-add text-decoration-none py-2 px-4 mt-2 d-inline-block">
            Browse Public Notes
        </a>
    </div>

@else

{{-- ===== GRID ===== --}}
<div class="row g-3">
    @foreach($notes as $note)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="fav-card h-100">

                {{-- TOP BAR --}}
                <div class="fav-card-top">
                    <span class="fav-card-title" title="{{ $note->title }}">
                        {{ Str::limit($note->title, 26) }}
                    </span>
                    <button
                        onclick="toggleFav({{ $note->id }}, this)"
                        class="fav-star-btn fav-active"
                        aria-label="Remove from favourites">
                        ★
                    </button>
                </div>

                {{-- PREVIEW (icon-based for performance — no iframe per card) --}}
                <div class="fav-preview">
                    @if(isset($note->filePath[0]))
                        <span style="font-size:32px;">📄</span>
                        <small class="fav-preview-label">PDF NOTE</small>
                    @elseif($note->youtubeLink && $note->youtubeLink->count() > 0)
                        <span style="font-size:32px; color:#ef4444;">▶</span>
                        <small class="fav-preview-label">VIDEO</small>
                    @else
                        <span style="font-size:28px; color:#94a3b8;">📁</span>
                        <small class="fav-preview-label">No Preview</small>
                    @endif
                </div>

                {{-- META --}}
                <div class="fav-card-meta">
                    <div>👤 {{ $note->user->name ?? 'Unknown' }}</div>
                    <div>📘 {{ $note->subject->sub_name ?? 'General' }}</div>
                </div>

                {{-- ACTIONS --}}
                <div class="fav-card-actions">
                    @if(isset($note->filePath[0]))
                        <a href="{{ url('/view-file/'.$note->filePath[0]->file_path) }}"
                           target="_blank"
                           class="fav-btn-view">
                            View
                        </a>
                        <a href="{{ url('/view-file/'.$note->filePath[0]->file_path) }}"
                           class="fav-btn-dl">
                            ↓ Save
                        </a>
                    @endif
                    @if($note->youtubeLink && $note->youtubeLink->count() > 0)
                        @foreach($note->youtubeLink as $yt)
                            @if(!empty($yt->youtube_link))
                                <a href="{{ $yt->youtube_link }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="fav-btn-yt">
                                    ▶ Watch
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    @endforeach
</div>

{{-- PAGINATION --}}
@if($notes->hasPages())
    <div class="d-flex justify-content-center mt-4 small-pagination">
        {{ $notes->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
@endif

@endif

<script>
function toggleFav(noteId, btn) {
    $.ajax({
        url: '/user/add_to_fav/' + noteId,
        type: 'POST',
        data: { _token: '{{ csrf_token() }}' },
        success: function(res) {
            if (res.status === 'removed') {
                $(btn).closest('.col-6, .col-md-4, .col-lg-3').fadeOut(280, function() {
                    $(this).remove();
                    // show empty state if no cards remain
                    if ($('.fav-card').length === 0) {
                        location.reload();
                    }
                });
            }
        },
        error: function() {
            alert('Something went wrong. Please try again.');
        }
    });
}
</script>

<style>
.fav-empty {
    text-align: center;
    padding: 70px 0;
    color: #6b7280;
}

.fav-card {
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    background: white;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: 0.25s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.fav-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    border-color: #c7d2fe;
}

.fav-card-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 12px 6px;
    gap: 8px;
}
.fav-card-title {
    font-size: 12px;
    font-weight: 700;
    color: #1e293b;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    flex: 1;
}
.fav-star-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 18px;
    color: #facc15;
    line-height: 1;
    flex-shrink: 0;
    padding: 0;
}

.fav-preview {
    flex: 1;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px 0;
    gap: 6px;
}
.fav-preview-label {
    font-size: 10px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.fav-card-meta {
    padding: 8px 12px;
    font-size: 11px;
    color: #64748b;
    line-height: 1.6;
    border-bottom: 1px solid #f1f5f9;
}

.fav-card-actions {
    display: flex;
    gap: 6px;
    padding: 8px 12px;
    flex-wrap: wrap;
}

.fav-btn-view, .fav-btn-dl, .fav-btn-yt {
    flex: 1;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 8px;
    border-radius: 6px;
    text-align: center;
    text-decoration: none;
    min-width: 50px;
    transition: 0.2s;
}
.fav-btn-view { background: #4f46e5; color: white; }
.fav-btn-view:hover { background: #4338ca; color: white; }
.fav-btn-dl { background: #f0fdf4; color: #059669; border: 1px solid #d1fae5; }
.fav-btn-dl:hover { background: #059669; color: white; }
.fav-btn-yt { background: #ef4444; color: white; }
.fav-btn-yt:hover { background: #dc2626; color: white; }
</style>

@endsection