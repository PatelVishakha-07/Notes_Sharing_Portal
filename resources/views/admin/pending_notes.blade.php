@extends('layouts.admin_layout')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#0f172a;">🕒 Pending Notes</h4>
        <small class="text-muted">Review and approve or reject uploaded notes</small>
    </div>
    <a href="{{ url('admin_dashboard') }}" class="browse-btn">← Dashboard</a>
</div>

{{-- ===== TABLE ===== --}}
<div class="card category-card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">

            {{-- 
                Bug fix: removed table-bordered which conflicts with clean-table's
                borderless style and creates double borders
            --}}
            <table class="table admin-table clean-table mb-0">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Uploader</th>
                        <th>Category</th>
                        <th>Subject</th>
                        <th style="width:180px;">Files</th>
                        <th style="width:190px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pending_notes as $pn)
                        <tr style="vertical-align:middle;">

                            <td class="text-muted" style="font-size:11px;">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="fw-semibold" style="font-size:13px; color:#1e293b;">
                                    {{ $pn->user->name }}
                                </div>
                                <small class="text-muted" style="font-size:10px;">
                                    {{ $pn->created_at->format('d M Y') }}
                                </small>
                            </td>

                            <td>
                                <span class="badge-soft-info" style="font-size:11px; padding:3px 9px; border-radius:6px; display:inline-block;">
                                    {{ $pn->category->cat_name }}
                                </span>
                            </td>

                            <td>
                                <span class="badge-soft-secondary" style="font-size:11px; padding:3px 9px; border-radius:6px; display:inline-block;">
                                    {{ $pn->subject->sub_name }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($pn->filePath as $fp)
                                        <a href="{{ url('/view-file/'.$fp->file_path) }}"
                                           target="_blank"
                                           class="browse-btn"
                                           style="font-size:10px; padding:3px 8px;">
                                            📄 View
                                        </a>
                                    @endforeach

                                    @if($pn->youtubeLink && $pn->youtubeLink->count())
                                        @foreach($pn->youtubeLink as $yt)
                                            @if(!empty($yt->youtube_link))
                                                <a href="{{ $yt->youtube_link }}"
                                                   target="_blank"
                                                   rel="noopener noreferrer"
                                                   class="admin-yt-btn">
                                                    ▶ Watch
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    {{--
                                        Bug fix: was using method="GET" for state-changing
                                        approve/reject actions. Changed to POST for correctness.
                                        Update your routes accordingly:
                                        Route::post('admin/acceptRequest/{val}/{id}', ...)
                                    --}}
                                    <form
                                        method="POST"
                                        action="{{ url('admin/acceptRequest/1/'.$pn->id) }}"
                                        onsubmit="return confirm('Approve this note?')">
                                        @csrf
                                        <button type="submit" class="btn-edit">
                                            ✔ Approve
                                        </button>
                                    </form>

                                    <form
                                        method="POST"
                                        action="{{ url('admin/acceptRequest/0/'.$pn->id) }}"
                                        onsubmit="return confirm('Reject this note?')">
                                        @csrf
                                        <button type="submit" class="btn-delete">
                                            ✖ Reject
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <div style="font-size:36px; margin-bottom:8px;">🎉</div>
                                All caught up — no pending notes!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ===== PAGINATION ===== --}}
<div class="mt-3 small-pagination">
    {{ $pending_notes->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

<style>
.admin-yt-btn {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    background: #ef4444;
    color: white;
    font-size: 10px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 5px;
    text-decoration: none;
    transition: 0.2s;
}
.admin-yt-btn:hover { background: #dc2626; color: white; }
</style>

@endsection