@extends('layouts.user_layout')

@section("content")

<a href="{{url('user/upload_notes')}}" class="btn btn-success mb-3">
➕ Add New Notes
</a>

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📒 Notes List</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Notes ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Subject</th>
                        <th>Notes File</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($notes as $n)
                        <tr>
                            <td>{{$n->id}}</td>

                            <td class="fw-semibold">{{$n->title}}</td>

                            <td>
                                <span class="badge bg-info">
                                    {{$n->category->cat_name}}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-secondary">
                                    {{$n->subject->sub_name}}
                                </span>
                            </td>

                            <td>
                                @foreach ($n->filePath as $fp)
                                    <a href="{{ asset('storage/'.$fp->file_path) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary mb-1">
                                        📄 View PDF
                                    </a>
                                @endforeach
                            </td>

                            <td>
                                <a href="{{url('user/edit_notes_page/'.$n->id)}}"
                                   class="btn btn-sm btn-warning">
                                   ✏ Edit
                                </a>

                                <a href="{{url('user/delete_notes/'.$n->id)}}"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this note?')">
                                   🗑 Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection