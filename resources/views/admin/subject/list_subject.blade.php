@extends('layouts.admin_layout')

@section('content')

<table border="1px" style="text-align: center; width: 100%;">
    <tr>
        <th>Subject Id</th>
        <th>Subject Name</th>
        <th>Category Name</th>
        <th>Action</th>
    </tr>

    @foreach($subject as $s)

    <tr>
        <td>{{$s->id}}</td>
        <td>{{$s->sub_name}}</td>
        <td>{{$s->category->cat_name}}</td>
        <td> 
            <a href="{{url('edit_subject_page',$s->id)}}">Edit</a> /
            <a href="{{url('delete_subject',$s->id)}}">Delete</a> 
        </td>
    </tr>

    @endforeach

</table>

<br><br>
<a href="{{url('add_subject')}}">Add Subject</a>

@endsection