@extends('layouts.admin_layout')

@section('content')

<div class="row justify-content-center">

    @if(session("error"))
        <p class="alert-error text-red-500 mb-3"> {{session('error')}} </p>
    @endif
    
    <div class="col-md-7">

        <div class="card p-4">

            <div class="mb-4">
                <h4>Add New Subject</h4>
                <p class="text-muted">Create a subject and assign it to a category</p>
            </div>

            <form method="POST" action="{{url('save_subject')}}">
                @csrf

                <div class="form-group mb-3">
                    <label>Subject Name</label>
                    <input 
                        type="text"
                        name="sub_name"
                        class="input-field"
                        placeholder="Enter subject name"
                    >
                </div>

                <div class="form-group mb-3">
                    <label>Select Category</label>

                    <select name="cat_id" class="form-control">
                        <option value="">Choose Category</option>

                        @foreach($category as $c)
                        <option value="{{$c->id}}">
                            {{$c->cat_name}}
                        </option>
                        @endforeach

                    </select>
                </div>

                <div class="d-flex gap-2 mt-4">

                    <button type="submit" class="btn-primary">
                        Add Subject
                    </button>

                    <a href="{{url('list_subject')}}" class="btn-cancel">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>
</div>

@endsection