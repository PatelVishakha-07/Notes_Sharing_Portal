@extends('layouts.admin_layout')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

        <div class="card category-card">

            <div class="card-header">
                <h4>✏️ Edit Category</h4>
                <p>Update the category name</p>
            </div>

            <div class="card-body">

                @error('cat_name')
                    <div class="admin-alert-error mb-3" role="alert">{{ $message }}</div>
                @enderror

                <form method="POST" action="{{ url('edit_category') }}" novalidate>
                    @csrf

                    <input type="hidden" name="id" value="{{ $category->id }}">

                    <div class="admin-form-group">
                        <label for="cat-name" class="admin-label">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            id="cat-name"
                            name="cat_name"
                            class="admin-input @error('cat_name') is-invalid @enderror"
                            value="{{ old('cat_name', $category->cat_name) }}"
                            placeholder="Enter category name"
                            maxlength="100"
                            required
                            autocomplete="off"
                        >
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn-primary">Update Category</button>
                        <a href="{{ url('list_category') }}" class="btn-cancel">Cancel</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<style>
.admin-form-group { margin-bottom: 16px; }
.admin-label { display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; }
.admin-input {
    width: 100%; padding: 9px 12px; font-size: 13px;
    border: 1px solid #d1d5db; border-radius: 8px;
    background: #f9fafb; color: #111827; transition: 0.2s; outline: none;
}
.admin-input:focus {
    border-color: #6366f1; background: white;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
}
.admin-alert-error {
    background: #fee2e2; border: 1px solid #f87171;
    color: #b91c1c; padding: 10px 14px; border-radius: 8px; font-size: 13px;
}
</style>

@endsection