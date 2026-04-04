@extends('layouts.admin_layout')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card category-card">

            <div class="card-header">
                <h4>Add New Category</h4>
                <p>Create categories to organize your notes</p>
            </div>

            <div class="card-body">

                <form method="POST" action="{{url('save_category')}}">
                    @csrf

                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="cat_name" class="input-field" placeholder="Example: Programming, AI, Math">
                    </div>

                    <button type="submit" class="btn-primary mt-3">
                        Add Category
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection