@extends('layouts.admin_layout')

@section('content')

<div class="card category-card p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">🕒 Pending Notes</h4>
            <p class="text-muted mb-0">Approve or reject uploaded notes</p>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle admin-table clean-table">

            <thead>
                <tr>
                    <th style="width:80px;">ID</th>
                    <th>User</th>
                    <th>Category</th>
                    <th>Subject</th>
                    <th style="width:200px;">Files</th>
                    <th style="width:180px;">Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse ($pending_notes as $pn)

                <tr>

                    <td>{{$pn->id}}</td>

                    <td>
                        <div class="d-flex align-items-center gap-2"> <span>{{$pn->user->name}} </span> </div>
                    </td>

                    <td>
                        <span class="badge-soft-info px-2 py-1 rounded"> {{$pn->category->cat_name}} </span>
                    </td>

                    <td>
                        <span class="badge-soft-secondary px-2 py-1 rounded"> {{$pn->subject->sub_name}} </span>
                    </td>

                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach ($pn->filePath as $fp)
                                <a href="{{ asset('storage/'.$fp->file_path) }}" target="_blank" class="browse-btn">
                                    📄 View
                                </a>
                            @endforeach
                        </div>
                    </td>

                    <td>
                        <div class="d-flex gap-2">

                            <form method="GET" action="{{url('admin/acceptRequest/1/'.$pn->id)}}">
                                <button type="submit" class="btn-edit">
                                    ✔ Approve
                                </button>
                            </form>

                            <form method="GET" action="{{url('admin/acceptRequest/0/'.$pn->id)}}"
                                  onsubmit="return confirm('Reject this note?')">
                                <button type="submit" class="btn-delete">
                                    ✖ Reject
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No pending notes 🎉
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection