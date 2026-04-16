@extends('layouts.user_layout')

@section('content')

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<link href="{{ asset('jquery-3.6.0.min.js') }}" rel="stylesheet">

<!-- HEADER -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
    <div>
        <h2 style="margin:0; font-size:18px; font-weight:700;">🌍 Public Notes</h2>
        <p class="text-muted" style="margin:2px 0 0; font-size:12px;">
            Browse all publicly shared notes
        </p>
    </div>

    <input type="text" class="search-box" placeholder="Search notes...">
</div>

<!-- GRID -->
<div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:16px; ">

    @foreach($notes as $note)

        <div class="card p-2" style="height:290px; display:flex; flex-direction:column; border-radius:12px; overflow:hidden; ">

            <!-- TOP BAR (TITLE + STAR) -->
            <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 4px; ">

                <div style=" font-size:12px; font-weight:600;
                    color:#111827; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:80%; ">
                    {{ $note->title }}
                </div>

                <!-- FAVORITE BUTTON -->
                <button
                    onclick="toggleFav({{ $note->id }}, this)"
                    class="{{ $note->is_favourite ? 'fav-active' : '' }}"
                    style="background:none; border:none; cursor:pointer; font-size:16px;">
                    {{ $note->is_favorite ? '★' : '☆' }}
                </button>

            </div>

            <!-- preview of notes -->
            <div style="height:140px; background:#f1f5f9; border-radius:10px;
                overflow:hidden; display:flex; align-items:center; justify-content:center; ">

                @if(isset($note->filePath[0]))
                    <iframe
                        src="{{ url('/view-file/'.$note->filePath[0]->file_path) }}#page=1&zoom=00"
                        style="width:100%; height:100%; border:none; pointer-events:none;">
                    </iframe>
                @else
                    <span style="font-size:12px; color:#64748b;"> No Preview </span>
                @endif

            </div>

            <!-- user name and subject name -->
            <div style="padding:6px 4px;">

                <div style="font-size:11px; color:#64748b;">
                    👤 {{ $note->user->name ?? 'Unknown User' }}
                </div>

                <div style="font-size:11px; color:#64748b;">
                    📘 {{ $note->subject->sub_name }}
                </div>

            </div>

            <!-- Buttons to download or view notes -->
            <div style="display:flex; gap:6px; padding:0 4px 6px; ">

                @if(isset($note->filePath[0]))

                    <a href="{{ url('/view-file/'.$note->filePath[0]->file_path) }}"
                    target="_blank"
                    style="flex:1; font-size:10px; padding:3px 6px; border-radius:6px;
                            text-align:center; text-decoration:none; background:#2563eb; color:white; display:inline-block; ">
                        View </a>

                    <a href="{{ url('/view-file/'.$note->filePath[0]->file_path) }}"
                    style="flex:1; font-size:10px; padding:3px 6px; border-radius:6px;
                            text-align:center; text-decoration:none; background:#16a34a; color:white; display:inline-block; ">
                        Download </a>

                @endif                

            </div>

            @if(count($note->youtubeLink) > 0)

                    <div style="padding:0 4px 6px;">

                        @foreach($note->youtubeLink as $index  => $link)

                            <a href="{{ $link->youtube_link }}" 
                            target="_blank"
                            style="display:block; font-size:11px; color:#2563eb; text-decoration:none; margin-bottom:2px;">

                                🎥 Watch Video {{ $index + 1 }}

                            </a>

                        @endforeach

                    </div>

                @endif

        </div>

    @endforeach

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

