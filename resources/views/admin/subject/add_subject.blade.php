@extends('layouts.admin_layout')

@section('content')

    <form method="POST" action="{{url('save_subject')}}">
        @csrf
        Enter Subject name: <input type="text" name="sub_name"><br><br>
        <select name="cat_id">
            <option></option>
            @foreach($category as $c)
                <option value="{{$c->id}}">{{$c->cat_name}}</option>
            @endforeach 
            <option>Other</option>
        </select><br><br>

        <button type="submit">Add</button>
    </form>


@endsection