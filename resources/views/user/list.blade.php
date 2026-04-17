@extends('layouts.user_layout')

@section("content")

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">📒 My Notes</h4>
        <small class="text-muted">Manage your uploaded study materials</small>
    </div>
    <a href="{{url('user/upload_notes')}}" class="btn-add text-decoration-none py-2 px-3">
        Add New Notes
    </a>
</div>


<form method="GET" action="{{ url('user/list_'.Str::lower($status).'_notes/'.$status) }}" class="mb-4">

    <div class="search-pill">

        <!-- Search -->
        <input type="text" 
               name="search" 
               class="search-input"
               placeholder="🔍 Search notes..."
               value="{{ request('search') }}">

        <!-- Category -->
        <select name="cat_id" class="filter-select" id="filter_category">
            <option value="">All Categories</option>
            @foreach($category as $c)
                <option value="{{ $c->id }}" {{ request('cat_id') == $c->id ? 'selected' : '' }}>
                    {{ $c->cat_name }}
                </option>
            @endforeach
        </select>

        <!-- Subject -->
        <select name="sub_id" class="filter-select" id="filter_subject">
            <option value="">All Subjects</option>
            @foreach($subject as $s)
                <option value="{{ $s->id }}" {{ request('sub_id') == $s->id ? 'selected' : '' }}>
                    {{ $s->sub_name }}
                </option>
            @endforeach
        </select>

        <!-- Search Button -->
        <button class="search-btn">
            Search
        </button>

        <!-- Clear -->
        <a href="{{ url('user/list_'.Str::lower($status).'_notes/'.$status) }}" class="clear-btn"> ✕ </a>

    </div>

</form>


<div class="card border-0 shadow-sm category-card">
    <div class="card-body p-0"> 
        <div class="table-responsive">
            <table class="custom-table clean-table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3" style="width: 60px;">ID</th>
                        <th style="width: 200px;">Title</th>
                        <th style="width: 150px;">Category</th>
                        <th style="width: 150px;">Subject</th>
                        <th style="width: 150px;">Status</th>
                        <th style="width: 100px;">Date</th>
                        @if($status == "Private")
                            <th style="width: 100px;">Code</th>
                        @endif
                        <th style="width: 120px;">Files</th>
                        <th class="text-end pe-3" style="width: 120px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($notes as $n)
                        <tr>
                            <td class="ps-3 text-muted" style="font-size: 11px;">{{$n->id}}</td>

                            <td class="fw-bold text-dark" style="font-size: 12px; line-height: 1.4;">
                                {{ Str::limit($n->title, 35) }}
                            </td>

                            <td>
                                <span class="badge badge-soft-info" style="font-size: 10px; padding: 4px 8px; white-space: nowrap;">
                                    {{$n->category->cat_name}}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-soft-secondary" style="font-size: 10px; padding: 4px 8px; white-space: nowrap;">
                                    {{$n->subject->sub_name}}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-soft-secondary" style="font-size: 10px; padding: 4px 8px; white-space: nowrap;">
                                    {{$n->status}}
                                </span>
                            </td>

                            <td class="text-muted" style="font-size: 11px; white-space: nowrap;">
                                {{ $n->created_at->format('d M y') }}
                            </td>

                            @if($status == "Private")
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <code class="text-primary bg-light px-1 rounded text-center" style="font-size: 10px;">{{$n->access_code}}</code>
                                        <span role="button" class="text-muted text-center" onclick="copyCode('{{$n->access_code}}')" style="font-size: 9px; cursor: pointer;"><u>Copy</u></span>
                                    </div>
                                </td>
                            @endif

                            <td>
                                @foreach ($n->filePath as $fp)
                                    <div class="d-flex flex-column gap-1 mb-2"> 
                                       <a href="{{ url('view-file/'.$fp->file_path) }}" 
                                            target="_blank" 
                                            class="btn btn-sm py-0 px-2 text-center"
                                            style="background: #6366f1; color: white; font-size: 9px;">
                                                View
                                        </a>      

                                        <a href="{{ asset('storage/'.$fp->file_path) }}" 
                                           download 
                                           class="btn btn-sm py-0 px-2 text-center" 
                                           style="background: #22c55e; color: white; font-size: 9px; line-height: 1.6; border-radius: 4px;">
                                            Download
                                        </a>

                                        @if(!empty($n->youtubeLink))
                                        @foreach ($n->youtubeLink as $yt)
                                            <a href="{{ $yt->youtube_link }}" 
                                            target="_blank" 
                                            class="btn btn-sm py-0 px-2" 
                                            style="background: #ef4444; color: white; font-size: 10px; line-height: 2;">
                                            Watch
                                            </a>
                                        @endforeach
                                    @endif
                                    </div>
                                @endforeach
                            </td>

                            <td class="text-end pe-3">
                                <div class="d-flex flex-column gap-1 align-items-end">
                                    <a href="{{url('user/edit_notes_page/'.$n->id)}}" 
                                       class="btn btn-outline-success py-0 px-2 w-100" 
                                       style="font-size: 10px; line-height: 1.8; max-width: 60px;">
                                        Edit
                                    </a>
                                    <a href="{{url('user/delete_notes/'.$n->id)}}" 
                                       class="btn btn-outline-danger py-0 px-2 w-100" 
                                       style="font-size: 10px; line-height: 1.8; max-width: 60px;"
                                       onclick="return confirm('Delete this note?')">
                                        Delete
                                    </a>
                                                                        
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function copyCode(code){
        navigator.clipboard.writeText(code);
        alert("Access code copied!");
    }
</script>

@endsection