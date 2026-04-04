@extends('layouts.admin_layout')

@section('content')

<div class="card p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Subject List</h4>

        <a href="{{url('add_subject')}}" class="btn-add">
            + Add Subject
        </a>
    </div>

    <table class="custom-table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Subject Name</th>
                <th>Category</th>
                <th style="width:160px;">Action</th>
            </tr>
        </thead>

        <tbody>

            @foreach($subject as $s)

            <tr>
                <td>{{$s->id}}</td>
                <td>{{$s->sub_name}}</td>
                <td>
                    <span class="category-badge">
                        {{$s->category->cat_name}}
                    </span>
                </td>

                <td>

                    <a href="{{url('edit_subject_page',$s->id)}}" class="btn-edit">
                        Edit
                    </a>

                    <a href="{{url('delete_subject',$s->id)}}" class="btn-delete">
                        Delete
                    </a>

                </td>
            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection