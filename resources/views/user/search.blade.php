@extends('layouts.user_layout')

@section('content')

    <div class="container mt-4">

        <div class="card shadow">

            <div class="card-header bg-dark text-white">
            <h4 class="mb-0">🔎 Search Notes</h4>
            </div>

        <div class="card-body">

            <form method="POST" action="{{ url('user/search_notes') }}" class="search-notes-form">
                @csrf
               <div class="row search-row">

                    <div class="col-md-2">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>

                    <div class="col-md-2">
                        <label>Category Name</label>
                        <select name="cat_id" class="form-control">
                            <option value="">All</option>
                            @foreach($category as $c)
                                <option value="{{$c->id}}">{{$c->cat_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Subject Name</label>
                        <select name="sub_id" class="form-control">
                            <option value="">All</option>
                            @foreach($subject as $s)
                                <option value="{{$s->id}}">{{$s->sub_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Notes Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Title">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">🔍 Search</button>
                    </div>

                </div>

            </form>

            <hr>

            <h5 class="mb-3">🔑 Access Private Note</h5>

            <form method="POST" action="{{ url('user/access_private_note') }}">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" name="access_code" class="form-control"  placeholder="Enter Access Code">
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-success w-100"> Open Private Note</button>
                    </div>
                </div>
            </form>

        </div>
    </div>


    {{-- Search Results --}}

    @if(isset($notes))

        <div class="card shadow mt-4">

            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">📒 Search Results</h5>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-hover text-center align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Uploader Name</th>
                            <th>Category</th>
                            <th>Subject</th>
                            <th>File</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($notes as $n)

                        <tr>

                            <td>{{$n->id}}</td>
                            <td>{{$n->title}}</td>

                            <td> <span class="badge badge-soft-success"> {{$n->user->name}} </span> </td>
                            <td> <span class="badge badge-soft-info"> {{$n->category->cat_name}} </span> </td>
                            <td> <span class="badge badge-soft-secondary"> {{$n->subject->sub_name}} </span> </td>

                            <td>
                                @foreach ($n->filePath as $fp)
                                    <a href="{{ asset('storage/'.$fp->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"> 📄 View </a>
                                @endforeach
                            </td>
                        </tr>   
                        @empty

                        <tr>
                            <td colspan="5">No Notes Found</td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

@endsection