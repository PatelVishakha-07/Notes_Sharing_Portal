@extends('layouts.admin_layout')

@section('content')


    <form method="POST" action="{{url('edit_category')}}">
        @csrf
        <input type="hidden" value="{{$category->id}}" name="id"/>
        Enter category name: <input type="text" name="cat_name" value="{{$category->cat_name}}"><br><br>
        <button type="submit">Update</button>
    </form>

@endsection