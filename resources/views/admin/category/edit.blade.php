@extends('layouts.admin_layout')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card category-card">

            <div class="card-header">
                <h4>Edit Category</h4>
                <p>Update the category name</p>
            </div>

            <div class="card-body">

                <form method="POST" action="{{url('edit_category')}}">
                    @csrf

                    <input type="hidden" name="id" value="{{$category->id}}">

                    <div class="form-group">
                        <label>Category Name</label>
                        <input 
                            type="text" 
                            name="cat_name" 
                            class="input-field"
                            value="{{$category->cat_name}}"
                            placeholder="Enter category name"
                        >
                    </div>

                    <div class="d-flex gap-2 mt-4">

                        <button type="submit" class="btn-primary">
                            Update Category
                        </button>

                        <a href="{{url('list_category')}}" class="btn-cancel">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection