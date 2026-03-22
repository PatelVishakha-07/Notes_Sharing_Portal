@extends('layouts.admin_layout')

@section('content')


    <form method="POST" action="{{url('save_category')}}">
        @csrf
        Enter category name: <input type="text" name="cat_name"><br><br>
        <button type="submit">Add</button>
    </form>

@endsection