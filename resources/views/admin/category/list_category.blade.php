@extends('layouts.admin_layout')

@section('content')

{{-- ===== HEADER ===== --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#0f172a;">📂 Categories</h4>
        <small class="text-muted">Manage all note categories</small>
    </div>
    <a href="{{ url('add_category') }}" class="btn-add">+ Add Category</a>
</div>

{{-- ===== TABLE ===== --}}
<div class="card category-card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table clean-table mb-0">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Category Name</th>
                        <th style="width:160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($category as $c)
                        <tr style="vertical-align:middle;">
                            <td class="text-muted" style="font-size:11px;">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <span class="fw-semibold" style="font-size:13px; color:#1e293b;">
                                    {{ $c->cat_name }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ url('edit_category_page', $c->id) }}" class="btn-edit">
                                        ✏ Edit
                                    </a>
                                    {{-- Bug fix: was GET link — changed to POST form --}}
                                    <form method="POST"
                                          action="{{ url('delete_category', $c->id) }}"
                                          onsubmit="return confirm('Delete category \'{{ addslashes($c->cat_name) }}\'? This may affect linked subjects and notes.')"
                                          style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-delete">
                                            🗑 Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-5">
                                <div style="font-size:32px; margin-bottom:8px;">📂</div>
                                No categories yet.
                                <a href="{{ url('add_category') }}" class="text-indigo-600 fw-semibold">Add one →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ===== PAGINATION ===== --}}
<div class="mt-3 small-pagination">
    {{ $category->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

@endsection