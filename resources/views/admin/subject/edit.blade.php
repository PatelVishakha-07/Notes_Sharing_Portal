@extends('layouts.admin_layout')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card p-4">

            <div class="mb-4">
                <h4>Edit Subject</h4>
                <p class="text-muted">Update subject details</p>
            </div>

            <form method="POST" action="{{url('edit_subject')}}">
                @csrf

                <input type="hidden" name="id" value="{{$subject->id}}"/>

                <div class="form-group mb-3">
                    <label>Subject Name</label>
                    <input 
                        type="text"
                        name="sub_name"
                        class="input-field"
                        value="{{$subject->sub_name}}"
                        placeholder="Enter subject name"
                    >
                </div>

                <div class="form-group mb-3">
                    <label>Select Category</label>

                    <select name="cat_id" class="form-control">

                        <option value="">Choose Category</option>

                        @foreach($category as $c)

                        <option 
                            value="{{$c->id}}" 
                            @if($c->id == $subject->cat_id) selected @endif
                        >
                            {{$c->cat_name}}
                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="d-flex gap-2 mt-4">

                    <button type="submit" class="btn-primary">
                        Update Subject
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