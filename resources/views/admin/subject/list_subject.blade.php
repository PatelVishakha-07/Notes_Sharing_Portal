@extends('layouts.admin_layout')

@section('content')

{{-- ===== HEADER ===== --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#0f172a;">📚 Subjects</h4>
        <small class="text-muted">Manage all subjects and their categories</small>
    </div>
    <a href="{{ url('add_subject') }}" class="btn-add">+ Add Subject</a>
</div>

{{-- ===== TABLE ===== --}}
<div class="card category-card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table clean-table mb-0">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Subject Name</th>
                        <th>Category</th>
                        <th style="width:160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subject as $s)
                        <tr style="vertical-align:middle;">
                            <td class="text-muted" style="font-size:11px;">
                                {{ $loop->iteration }}
                            </td>
                            <td class="fw-semibold" style="font-size:13px; color:#1e293b;">
                                {{ $s->sub_name }}
                            </td>
                            <td>
                                <span class="category-badge">
                                    {{ $s->category->cat_name ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ url('edit_subject_page', $s->id) }}" class="btn-edit">
                                        ✏ Edit
                                    </a>
                                    {{-- Bug fix: was GET link — changed to POST form --}}
                                    <form method="POST"
                                          action="{{ url('delete_subject', $s->id) }}"
                                          onsubmit="return confirm('Delete subject \'{{ addslashes($s->sub_name) }}\'?')"
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
                            <td colspan="4" class="text-center text-muted py-5">
                                <div style="font-size:32px; margin-bottom:8px;">📚</div>
                                No subjects yet.
                                <a href="{{ url('add_subject') }}" class="fw-semibold" style="color:#6366f1;">Add one →</a>
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
    {{ $subject->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

@endsection