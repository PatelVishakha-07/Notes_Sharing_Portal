@extends('layouts.user_layout')

@section("content")

<h3>Notes List</h3><br>

<table border="1px" style="text-align: center">

    <tr>
        <th>Notes ID</th>
        <th>Title</th>
        <th>Category Name</th>
        <th>Subject Name</th>
        <th>Notes</th>
        <th>Action</th>
    </tr>

    @foreach ($notes as $n)
        <tr>
            <td>{{$n->id}}</td>
            <td>{{$n->title}}</td>
            <td>{{$n->category->cat_name}}</td>
            <td>{{$n->subject->sub_name}}</td>
            @foreach ($n->filePath as $fp)
                <td> <a href="{{ asset('storage/'.$fp->file_path) }}" target="_blank" class="btn btn-sm btn-primary"> Open PDF </a> </td>
            @endforeach
            <td>
                <a href="{{url('user/edit_notes_page/'.$n->id)}}">Edit</a> / 
                <a href="{{url('user/delete_notes/'.$n->id)}}">Delete</a>
            </td>
        </tr> 
    @endforeach

</table>

@endsection