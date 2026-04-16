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
    }
    .note-grid-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        border-color: #c7d2fe; 
    }

    .preview-container {
        width: 100%;
        aspect-ratio: 1 / 1;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #eee;
    }

    .preview-icon {
        font-size: 40px;
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
        font-size: 13px;
    }

    .btn-download {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #10b981;
    }
</style>

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <a href="{{url('user/upload_notes')}}"
        class="btn btn-primary btn-sm"
        style="padding: 4px 10px; font-size: 13px; border-radius: 8px;">
            + Upload
        </a>

    </div>

    {{-- ✅ DASHBOARD CARDS --}}
    <div class="row mb-4">

        <div class="col-12 col-md-6 col-lg-3 mb-3">
            <div class="dashboard-card">
                <div class="card-title">📒 Total Notes</div>
                <div class="card-number purple">{{ $totalNotes }}</div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3 mb-3">
            <div class="dashboard-card">
                <div class="card-title">🌐 Public Notes</div>
                <div class="card-number green">{{ $publicNotesCount }}</div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3 mb-3">
            <div class="dashboard-card">
                <div class="card-title">🔒 Private Notes</div>
                <div class="card-number orange">{{ $privateNotesCount }}</div>
            </div>
        </div>  
        
        <div class="col-12 col-md-6 col-lg-3 mb-3">
            <a href="{{ url('user/fav_list') }}" class="text-decoration-none">
                <div class="dashboard-card favorite-card">

                    <div class="card-title">❤️ Favorite Notes</div>

                    <div class="card-number red">
                        {{ $favouriteCount ?? 0 }}
                    </div>

                </div>
            </a>
        </div>

    </div>

   <div class="d-flex justify-content-between align-items-center mb-3">
    
    <h4 class="mb-0">📚 Global Public Notes</h4>

    <a href="{{ url('user/all_notes') }}" class="btn btn-outline-primary btn-sm"
       style="padding: 4px 10px; font-size: 13px; border-radius: 8px;">
       Browse All →
    </a>

</div>

    {{-- NOTES --}}
    <div class="row">

        @foreach ($notes as $n)

        <div class="col-6 col-md-4 col-lg-3 mb-4">

            <div class="note-grid-card">

                {{-- PREVIEW --}}
                <div class="preview-container">

                    @foreach ($n->filePath as $fp)

                        <div class="text-center">
                            <div class="preview-icon">📄</div>
                            <small class="text-muted">PDF</small>
                        </div>

                        @break

                    @endforeach

                    @if(count($n->filePath) == 0)
                        <div class="text-muted">No Preview</div>
                    @endif

                </div>

                {{-- BODY --}}
                <div class="p-3">

                    <span class="subject-badge">
                        {{ $n->subject->sub_name ?? 'General' }}
                    </span>

                    <h6 class="mt-2 mb-1">
                        {{ $n->title }}
                    </h6>

                    <small class="text-muted">
                        By {{ $n->user->name ?? 'System' }}
                    </small>

                    {{-- BUTTONS --}}
                    <div class="mt-3 d-flex gap-2">

                        @foreach ($n->filePath as $fp)

                            <a href="{{ url('view-file/'.$fp->file_path) }}"
                               target="_blank"
                               class="btn btn-sm btn-view w-100">
                               View
                            </a>

                            <a href="{{ url('view-file/'.$fp->file_path) }}"
                               class="btn btn-sm btn-download">
                               ↓
                            </a>

                            @break

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection