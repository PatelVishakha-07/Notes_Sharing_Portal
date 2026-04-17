@extends('layouts.admin_layout')

@section('content')

<h3>Admin Dashboard</h3>

<div class="row mt-4">

    <div class="col-md-3">
        <a href="{{ url('admin/showUsersList') }}" style="text-decoration:none; color:inherit;">
            <div class="dashboard-card">
                <p>Total Users</p>
                <h4>{{$totalUser}}</h4>
            </div>
        </a>
    </div>

    <div class="col-md-3">        
            <div class="dashboard-card">
                <p>Total Notes</p>
                <h4>{{$totalNotes}}</h4>
            </div>
    </div>

    <div class="col-md-3">
        <a href="{{ url('list_category') }}" style="text-decoration:none; color:inherit;">
            <div class="dashboard-card">
                <p>Total Categories</p>
                <h4> {{$totalCategory}} </h4>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ url('list_subject') }}" style="text-decoration:none; color:inherit;">
            <div class="dashboard-card">
                <p>Total Subjects</p>
                <h4> {{$totalSubjects}}  </h4>
            </div>
        </a>
    </div>

</div>

{{-- List of All Notes --}}

<hr class="mt-4">

<h4 class="mt-3">All Notes</h4>

<!-- SEARCH BOX -->
<form method="GET" class="search-notes-wrapper mb-3" action="{{url('admin_dashboard')}}">

    <div class="search-pill">

        <i class="search-icon">🔍</i>

        <!-- SEARCH INPUT -->
        <input type="text" name="search" placeholder="Search notes..." value="{{ request('search') }}" class="search-input">

        <!-- CATEGORY -->
        <select name="category" class="filter-select">
            <option value="">Category</option>
            @foreach($category ?? [] as $cat)
                <option value="{{ $cat->id }}"
                    {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->cat_name }}
                </option>
            @endforeach
        </select>

        <!-- SUBJECT -->
        <select name="subject" class="filter-select">
            <option value="">Subject</option>
            @foreach($subject ?? [] as $sub)
                <option value="{{ $sub->id }}"
                    {{ request('subject') == $sub->id ? 'selected' : '' }}>
                    {{ $sub->sub_name }}
                </option>
            @endforeach
        </select>

        <!-- CLEAR -->
        @if(request('search') || request('category') || request('subject'))
            <a href="{{ url()->current() }}" class="clear-btn">✕</a>
        @endif

        <!-- BUTTON -->
        <button type="submit" class="search-btn">
            Filter
        </button>

    </div>
</form>


<!-- NOTES TABLE -->
<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle admin-table clean-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>User</th>
                <th>Category</th>
                <th>Subject</th>
                <th>Actions</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            @forelse($notes as $note)
               <tr>
                    <td>{{ $note->id }}</td>

                    <td>
                        <div class="text-truncate" style="max-width: 180px;">
                            {{ $note->title }}
                        </div>
                    </td>

                    <td>{{ $note->user->name ?? '-' }}</td>

                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $note->category->cat_name ?? '-' }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $note->subject->sub_name ?? '-' }}
                        </span>
                    </td>   

                    {{-- ✅ NEW ACTION COLUMN --}}
                    <td>
                        
                        {{-- PDF FILES --}}
                        @foreach ($note->filePath ?? [] as $fp)
                            <a href="{{ asset('storage/'.$fp->file_path) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-primary mb-1">
                                📄 View
                            </a>
                        @endforeach

                        {{-- YOUTUBE LINKS --}}
                        @foreach ($note->youtubeLink ?? [] as $yt)
                            <a href="{{ $yt->youtube_link }}"
                            target="_blank"
                            class="btn btn-sm btn-danger mb-1">
                                ▶ Watch
                            </a>
                        @endforeach
                    </td>
                    <td>{{ $note->created_at->format('d M Y') }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">
                        No notes found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


<!-- PAGINATION -->
<div class="mt-3">
    {{ $notes->appends(request()->query())->links() }}
</div>

@endsection