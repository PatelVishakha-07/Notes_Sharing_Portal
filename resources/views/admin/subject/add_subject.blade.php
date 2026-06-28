@extends('layouts.admin_layout')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

        <div class="card category-card">

            <div class="card-header">
                <h4>📚 Add New Subject</h4>
                <p>Create a subject and assign it to a category</p>
            </div>

            <div class="card-body">

                {{-- Error INSIDE the card --}}
                @if(session('error'))
                    <div class="admin-alert-error mb-3" role="alert">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    <div class="admin-alert-error mb-3" role="alert">
                        <ul class="mb-0" style="padding-left:16px;">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('save_subject') }}" novalidate>
                    @csrf

                    <div class="admin-form-group">
                        <label for="sub-name" class="admin-label">
                            Subject Name <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            id="sub-name"
                            name="sub_name"
                            class="admin-input @error('sub_name') is-invalid @enderror"
                            placeholder="e.g. Data Structures, Calculus"
                            maxlength="100"
                            value="{{ old('sub_name') }}"
                            required
                            autocomplete="off"
                        >
                    </div>

                    <div class="admin-form-group">
                        <label for="cat-select" class="admin-label">
                            Category <span class="text-danger">*</span>
                        </label>
                        <select
                            id="cat-select"
                            name="cat_id"
                            class="admin-input @error('cat_id') is-invalid @enderror"
                            required
                        >
                            <option value="">Choose Category</option>
                            @foreach($category as $c)
                                <option value="{{ $c->id }}" {{ old('cat_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->cat_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn-primary">Add Subject</button>
                        <a href="{{ url('list_subject') }}" class="btn-cancel">Cancel</a>
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