@extends('layouts.admin_layout')

@section('content')

<div class="card p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Category List</h4>

        <a href="{{url('add_category')}}" class="btn-add">
            + Add Category
        </a>
    </div>

    <table class="custom-table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th style="width:150px;">Action</th>
            </tr>
        </thead>

        <tbody>

            @foreach($category as $c)

            <tr>
                <td>{{$c->id}}</td>
                <td>{{$c->cat_name}}</td>

                <td>
                    <a href="{{url('edit_category_page',$c->id)}}" class="btn-edit">
                        Edit
                    </a>

                    <a href="{{url('delete_category',$c->id)}}" class="btn-delete">
                        Delete
                    </a>
                </td>
            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection