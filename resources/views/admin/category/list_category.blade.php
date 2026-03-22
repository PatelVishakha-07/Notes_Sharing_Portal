@extends('layouts.admin_layout')

@section('content')

<table border="1px" style="text-align: center; width: 100%;">
    <tr>
        <th>Category Id</th>
        <th>Category Name</th>
        <th>Delete</th>
    </tr>

    @foreach($category as $c)

    <tr>
        <td>{{$c->id}}</td>
        <td>{{$c->cat_name}}</td>
        <td> <a href="{{url('delete_category',$c->id)}}">Delete</a> </td>
    </tr>

    @endforeach

</table>

<br><br>
<a href="{{url('add_category')}}">Add Category</a>

@endsection