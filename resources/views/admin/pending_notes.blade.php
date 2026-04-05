@extends('layouts.admin_layout')

@section('content')

<div class="card p-4">

    <div class="mb-3">
        <h4>Pending Notes</h4>
        <p class="text-muted">Approve or reject uploaded notes</p>
    </div>

    <table class="table table-hover align-middle">

        <thead class="table-light">
            <tr>
                <th>Notes ID</th>
                <th>User</th>
                <th>Category</th>
                <th>Subject</th>
                <th>Files</th>
                <th width="180">Action</th>
            </tr>
        </thead>

        <tbody>

        @foreach ($pending_notes as $pn)

            <tr>

                <td>{{$pn->id}}</td>

                <td>{{$pn->user->name}}</td>

                <td>{{$pn->category->cat_name}}</td>

                <td>{{$pn->subject->sub_name}}</td>

                <td>
                    @foreach ($pn->filePath as $fp)

                        <a href="{{ asset('storage/'.$fp->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                            View PDF
                        </a>

                    @endforeach
                </td>

                <td class="d-flex gap-2">

                    <form method="GET" action="{{url('admin/acceptRequest/1/'.$pn->id)}}">
                        <button type="submit" class="btn btn-success btn-sm">
                            Approve
                        </button>
                    </form>

                    <form method="GET" action="{{url('admin/acceptRequest/0/'.$pn->id)}}">
                        <button type="submit" class="btn btn-danger btn-sm">
                            Reject
                        </button>
                    </form>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection