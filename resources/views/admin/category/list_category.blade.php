@extends('layouts.admin_layout')

@section('content')

<div class="card category-card p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">📂 Category List</h4>
            <p class="text-muted mb-0">Manage all categories</p>
        </div>

        <a href="{{url('add_category')}}" class="btn-add">
            + Add Category
        </a>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle admin-table clean-table">

            <thead>
                <tr>
                    <th style="width:80px;">ID</th>
                    <th>Category Name</th>
                    <th style="width:180px;">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($category as $c)
                <tr>
                    <td>#{{$c->id}}</td>

                    <td>
                        <span class="fw-semibold">{{$c->cat_name}}</span>
                    </td>

                    <td>
                        <div class="d-flex gap-2">

                            <a href="{{url('edit_category_page',$c->id)}}" class="btn-edit">
                                ✏ Edit
                            </a>

                            <a href="{{url('delete_category',$c->id)}}" 
                               class="btn-delete"
                               onclick="return confirm('Are you sure you want to delete this category?')">
                                🗑 Delete
                            </a>

                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        No categories found
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection