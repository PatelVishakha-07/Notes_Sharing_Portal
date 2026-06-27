@extends('layouts.user_layout')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#0f172a;">My Dashboard</h4>
        <small class="text-muted">Welcome back, {{ auth()->user()->name }}</small>
    </div>
    <a href="{{ url('user/upload_notes') }}" class="btn-add text-decoration-none py-2 px-4">
        + Upload Notes
    </a>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-3">
        <div class="dashboard-card">
            <div class="card-title">📒 Total Notes</div>
            <div class="card-number purple">{{ $totalNotes }}</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="dashboard-card">
            <div class="card-title">🌐 Public</div>
            <div class="card-number green">{{ $publicNotesCount }}</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="dashboard-card">
            <div class="card-title">🔒 Private</div>
            <div class="card-number orange">{{ $privateNotesCount }}</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ url('user/fav_list') }}" class="text-decoration-none">
            <div class="dashboard-card favorite-card">
                <div class="card-title">❤️ Favorites</div>
                <div class="card-number red">{{ $favouriteCount ?? 0 }}</div>
            </div>
        </a>
    </div>

</div>

{{-- ===== GLOBAL PUBLIC NOTES ===== --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0" style="color:#0f172a;">📚 Global Public Notes</h5>
        <small class="text-muted">Recently shared by the community</small>
    </div>
    <a href="{{ url('user/all_notes') }}" class="text-primary text-decoration-none small fw-semibold">
        Browse All →
    </a>
</div>

<div class="row g-3">
    @forelse($notes as $n)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="note-grid-card position-relative h-100">

            {{-- FAV BUTTON --}}
            <button
                onclick="toggleFav({{ $n->id }}, this)"
                class="favorite-btn {{ $n->is_favourite ? 'fav-active' : '' }}"
                aria-label="{{ $n->is_favourite ? 'Remove from favourites' : 'Add to favourites' }}">
                {{ $n->is_favourite ? '★' : '☆' }}
            </button>

            {{-- PREVIEW --}}
            <div class="note-preview-box">
                @if($n->filePath && $n->filePath->count() > 0)
                    <div class="note-preview-icon">📄</div>
                    <small class="note-preview-label">PDF NOTE</small>
                @elseif($n->youtubeLink && $n->youtubeLink->count() > 0)
                    <div class="note-preview-icon" style="color:#ef4444;">▶</div>
                    <small class="note-preview-label">VIDEO LESSON</small>
                @else
                    <small class="note-preview-label">No Preview</small>
                @endif
            </div>

            {{-- CARD BODY --}}
            <div class="p-3">
                <span class="subject-badge-pill">{{ $n->subject->sub_name ?? 'General' }}</span>

                <h6 class="mt-2 mb-1 fw-bold text-truncate" style="font-size:13px; color:#0f172a;">
                    {{ Str::limit($n->title, 28) }}
                </h6>

                <p class="mb-3" style="font-size:11px; color:#64748b;">
                    By {{ $n->user->name ?? 'System' }}
                </p>

                {{-- PDF ACTIONS --}}
                @if($n->filePath && $n->filePath->count() > 0)
                    <div class="d-flex flex-column gap-2 mb-2">
                        @foreach($n->filePath as $fp)
                            <div class="d-flex gap-1">
                                <a href="{{ url('view-file/'.$fp->file_path) }}"
                                   target="_blank"
                                   class="btn btn-sm note-btn-view flex-grow-1">
                                    View{{ $loop->iteration > 1 ? ' '.$loop->iteration : '' }}
                                </a>
                                <a href="{{ url('view-file/'.$fp->file_path) }}"
                                   class="btn btn-sm note-btn-dl px-2"
                                   title="Download">
                                    ↓
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- YOUTUBE ACTIONS --}}
                @if($n->youtubeLink && $n->youtubeLink->count() > 0)
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($n->youtubeLink as $yt)
                            @if(!empty($yt->youtube_link))
                                <a href="{{ $yt->youtube_link }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="btn btn-sm note-btn-yt flex-grow-1">
                                    ▶ Watch
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
            <div style="font-size:36px;">📭</div>
            <p class="mt-2">No public notes yet. Upload the first one!</p>
        </div>
    @endforelse
</div>

{{-- ===== AJAX FAVOURITE TOGGLE ===== --}}
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
/* ===== NOTE GRID CARD ===== */
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

/* preview box */
.note-preview-box {
    width: 100%;
    aspect-ratio: 16/9;
    background: #f1f5f9;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #e2e8f0;
    gap: 4px;
}
.note-preview-icon { font-size: 30px; }
.note-preview-label { font-size: 10px; font-weight: 700; color: #64748b; letter-spacing: 0.5px; text-transform: uppercase; }

/* subject pill */
.subject-badge-pill {
    display: inline-block;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 10px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 6px;
}

/* action buttons */
.note-btn-view {
    background: #4f46e5;
    color: white;
    font-size: 11px;
    font-weight: 600;
    border-radius: 6px;
    padding: 5px 0;
}
.note-btn-view:hover { background: #4338ca; color: white; }

.note-btn-dl {
    border: 1px solid #d1fae5;
    color: #059669;
    background: #f0fdf4;
    font-size: 13px;
    border-radius: 6px;
}
.note-btn-dl:hover { background: #059669; color: white; border-color: #059669; }

.note-btn-yt {
    background: #ef4444;
    color: white;
    font-size: 11px;
    font-weight: 600;
    border-radius: 6px;
}
.note-btn-yt:hover { background: #dc2626; color: white; }
</style>

@endsection