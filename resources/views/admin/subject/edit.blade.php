@extends('layouts.admin_layout')

@section('content')

    <form method="POST" action="{{url('edit_subject')}}">
        @csrf
        <input type="hidden" value="{{$subject->id}}" name="id"/>
        Enter Subject name: <input type="text" name="sub_name" value="{{$subject->sub_name}}"><br><br>
        Select Category: <select name="cat_id">
            <option value=""></option>
            @foreach($category as $c)
                <option value="{{$c->id}}" {{$subject->cat_id == $c->id ? 'selected':''}} >{{$c->cat_name}}</option>
           @endforeach 
            <option>Other</option>
        </select><br><br>

        <button type="submit">Update</button>
    </form>


@endsection