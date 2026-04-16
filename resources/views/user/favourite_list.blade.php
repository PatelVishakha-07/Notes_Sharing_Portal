@extends('layouts.user_layout')

@section('content')

<script src="{{ asset('jquery-3.6.0.min.js') }}"></script>

<style>
    .fav-header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:18px;
    }

    .fav-title {
        font-size:18px;
        font-weight:700;
    }

    .fav-sub {
        font-size:12px;
        color:#6b7280;
    }

    .search-box {
        border:1px solid #e5e7eb;
        border-radius:8px;
        padding:5px 10px;
        font-size:12px;
        outline:none;
    }

    .notes-grid {
        display:grid;
        grid-template-columns: repeat(4, 1fr);
        gap:16px;
    }

    .note-card {
        height:290px;
        display:flex;
        flex-direction:column;
        border-radius:12px;
        overflow:hidden;
        border:1px solid #e5e7eb;
        background:white;
        transition:0.3s;
    }

    .note-card:hover {
        transform:translateY(-4px);
        box-shadow:0 8px 20px rgba(0,0,0,0.08);
    }

    .fav-btn {
        background:none;
        border:none;
        cursor:pointer;
        font-size:16px;
    }

    .fav-active {
        color:#facc15;
    }

    .preview-box {
        height:140px;
        background:#f1f5f9;
        border-radius:10px;
        overflow:hidden;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .btn-sm-custom {
        font-size:10px;
        padding:3px 6px;
        border-radius:6px;
        text-align:center;
        text-decoration:none;
        color:white;
        display:inline-block;
    }

    .btn-view { background:#2563eb; }
    .btn-download { background:#16a34a; }

    .empty-box {
        text-align:center;
        padding:60px 0;
        color:#6b7280;
    }
</style>

<div class="container py-3">

    <!-- HEADER -->

    <!-- HEADER -->
<div class="fav-header">

    <div>
        <div class="fav-title">❤️ My Favorite Notes</div>
        <div class="fav-sub">All notes you’ve saved for quick access</div>
    </div>

    <form method="GET" action="{{ url('user/fav_list') }}" class="search-form">

        <input type="text" name="search" value="{{ request('search') }}"class="fav-search-box" placeholder="Search favorites...">

        <button type="submit" class="search-btn"> 🔍 </button>

        <a href="{{ url('user/all_notes') }}" class="browse-btn"> 📚 Browse Notes </a>

    </form>

</div>

    
    <!-- EMPTY STATE -->
    @if($notes->isEmpty())
        <div class="empty-box">
            <h5>💔 No Favorites Yet</h5>
            <p>Start adding notes to your favorites ⭐</p>
        </div>
    @else

    <!-- GRID -->
    <div class="notes-grid">

        @foreach($notes as $note)

        <div class="note-card">

            <!-- TOP -->
            <div style="display:flex; justify-content:space-between; padding:6px 6px;">
                
                <div style="font-size:12px; font-weight:600; max-width:80%; overflow:hidden; text-overflow:ellipsis;">
                    {{ $note->title }}
                </div>

                <!-- ⭐ REMOVE FROM FAVORITES -->
                <button onclick="toggleFav({{ $note->id }}, this)" class="fav-btn fav-active">
                    ★
                </button>

            </div>

            <!-- PREVIEW -->
            <div class="preview-box">

                @if(isset($note->filePath[0]))
                    <iframe
                        src="{{ url('/view-file/'.$note->filePath[0]->file_path) }}#page=1&zoom=00"
                        style="width:100%; height:100%; border:none; pointer-events:none;">
                    </iframe>
                @else
                    <span style="font-size:12px;">No Preview</span>
                @endif

            </div>

            <!-- DETAILS -->
            <div style="padding:6px; font-size:11px; color:#64748b;">
                👤 {{ $note->user->name ?? 'Unknown' }} <br>
                📘 {{ $note->subject->sub_name ?? 'General' }}
            </div>

            <!-- ACTIONS -->
            <div style="display:flex; gap:6px; padding:0 6px 6px;">

                @if(isset($note->filePath[0]))

                <a href="{{ url('/view-file/'.$note->filePath[0]->file_path) }}"
                   target="_blank"
                   class="btn-sm-custom btn-view"
                   style="flex:1;">
                   View
                </a>

                <a href="{{ url('/view-file/'.$note->filePath[0]->file_path) }}"
                   class="btn-sm-custom btn-download"
                   style="flex:1;">
                   Download
                </a>

                @endif

            </div>

        </div>

        @endforeach

    </div>

    @endif

</div>

<!-- TOGGLE SCRIPT -->
<script>
function toggleFav(noteId, btn){
    $.ajax({
        url:"/user/add_to_fav/" + noteId,
        type:"POST",
        data:{ _token:"{{ csrf_token() }}" },
        success:function(res){
            if(res.status === "removed"){
                // remove card smoothly
                $(btn).closest('.note-card').fadeOut(300, function(){
                    $(this).remove();
                });
            }
        }
    });
}
</script>

@endsection