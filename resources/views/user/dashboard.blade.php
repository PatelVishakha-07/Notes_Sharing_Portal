@extends('layouts.user_layout')

@section('content')

<style>
    .note-grid-card {
        border-radius: 16px;
        background: white;
        border: 1px solid #e2e8f0; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: 0.3s;
        height: 100%;
        overflow: hidden; /* Ensures content doesn't spill out of border radius */
    }
    .note-grid-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        border-color: #c7d2fe; 
    }

    .preview-container {
        width: 100%;
        aspect-ratio: 16 / 9; /* Changed to video aspect ratio */
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #eee;
    }

    .preview-icon {
        font-size: 32px;
    }

    .subject-badge {
        background: #eef2ff;
        color: #4f46e5;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .btn-view {
        background: #4f46e5;
        color: white;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-download {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #10b981;
    }

    /* New YouTube Style */
    .btn-youtube {
        background: #ef4444;
        color: white;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        transition: 0.2s;
    }
    .btn-youtube:hover {
        background: #dc2626;
        color: white;
    }
</style>

<div class="container py-4">

    {{-- header --}}
    <div class="mb-4">
    <h4 class="fw-bold mb-2">My Dashboard</h4>

    <div>
        <a href="{{url('user/upload_notes')}}"
           class="btn btn-primary btn-sm px-3"
           style="border-radius: 8px;">
            + Upload Notes
        </a>
    </div>
</div>

    {{-- cards  --}}
    <div class="row mb-4">
        <div class="col-6 col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="card-title small">📒 Total Notes</div>
                <div class="card-number purple fs-4">{{ $totalNotes }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="card-title small">🌐 Public</div>
                <div class="card-number green fs-4">{{ $publicNotesCount }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="card-title small">🔒 Private</div>
                <div class="card-number orange fs-4">{{ $privateNotesCount }}</div>
            </div>
        </div>  
        <div class="col-6 col-md-3 mb-3">
            <a href="{{ url('user/fav_list') }}" class="text-decoration-none">
                <div class="dashboard-card favorite-card">
                    <div class="card-title small">❤️ Favorites</div>
                    <div class="card-number red fs-4">{{ $favouriteCount ?? 0 }}</div>
                </div>
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">📚 Global Public Notes</h5>
        <a href="{{ url('user/all_notes') }}" class="text-primary text-decoration-none small">
            Browse All →
        </a>
    </div>

    {{-- Public Notes --}}
    <div class="row">
        @foreach ($notes as $n)
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="note-grid-card position-relative"> 
                
                {{-- ⭐ FAVORITE BUTTON --}}
                   <button
                        onclick="toggleFav({{ $n->id }}, this)"
                        class="favorite-btn {{ $n->is_favourite ? 'fav-active' : '' }}"
                        style="background:none; border:none; cursor:pointer; font-size:16px;">
                        {{ $n->is_favourite ? '★' : '☆' }}
                    </button>
                                
                {{-- PREVIEW CONTAINER LOGIC --}}
                <div class="preview-container">                
                   @if(count($n->filePath) > 0)
                        <div class="text-center">
                            <div class="preview-icon">📄</div>
                            <small class="text-muted fw-bold">PDF NOTE</small>
                        </div>
                    @elseif(!empty($n->youtubeLink) && count($n->youtubeLink) > 0)
                        <div class="text-center">
                            <div class="preview-icon text-danger">▶</div>
                            <small class="text-muted fw-bold">VIDEO LESSON</small>
                        </div>
                    @else
                        <div class="text-muted small">No Preview</div>
                    @endif
                </div>

                {{-- CARD BODY --}}
                <div class="p-3">
                    <span class="subject-badge">
                        {{ $n->subject->sub_name ?? 'General' }}
                    </span>

                    <h6 class="mt-2 mb-1 fw-bold text-dark" style="font-size: 14px;">
                        {{ Str::limit($n->title, 25) }}
                    </h6>

                    <p class="text-muted mb-3" style="font-size: 11px;">
                        By {{ $n->user->name ?? 'System' }}
                    </p>

                   {{-- BUTTONS ROW --}}
                    <div class="mt-3">                        
                        {{-- PDF Actions --}}                        
                        @if(count($n->filePath) > 0)
                            <div class="d-flex flex-column gap-2 mb-2">
                                @foreach ($n->filePath as $fp)
                                    <div class="d-flex gap-1">
                                        <a href="{{ url('view-file/'.$fp->file_path) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-view w-100 py-2">
                                            View PDF {{ $loop->iteration > 1 ? $loop->iteration : '' }}
                                        </a>
                                        <a href="{{ url('view-file/'.$fp->file_path) }}"
                                        class="btn btn-sm btn-download px-2 d-flex align-items-center">
                                            ↓
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- YouTube Actions --}}
                        @if($n->youtubeLink && $n->youtubeLink->count() > 0)
                            <div class="d-flex flex-wrap gap-1">
                                @foreach ($n->youtubeLink as $yt)
                                    @if(!empty($yt->youtube_link))
                                        <a href="{{ $yt->youtube_link }}" 
                                        target="_blank"
                                        class="btn btn-sm btn-youtube flex-grow-1 py-1"
                                        style="font-size: 11px; min-width: 80px;">
                                            ▶ Watch
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        
                    </div>
                   
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- code for add to favourite --}}
<script>
    function toggleFav(noteId, btn){
        $.ajax({
            url:"/user/add_to_fav/" + noteId,
            type:"POST",
            data: {
                _token: "{{csrf_token()}}"
            },
            success: function(data){
                if(data.status === "added"){
                    $(btn).html('★');
                    $(btn).addClass("fav-active");
                }else{
                    $(btn).html('☆');
                    $(btn).removeClass("fav-active");
                }
            },
            error: function(){
                alert("Something went wrong!");
            }
        });
    }
</script>


@endsection