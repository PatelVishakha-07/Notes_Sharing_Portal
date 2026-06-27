@extends('layouts.user_layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#0f172a;">📤 Upload Note</h4>
        <small class="text-muted">Share your study materials with the community</small>
    </div>
    <a href="{{ url('user/list_public_notes/Public') }}" class="btn-add text-decoration-none py-2 px-4">
        My Notes
    </a>
</div>

{{-- ERROR SUMMARY --}}
@if($errors->any())
    <div class="upload-alert-error mb-4" role="alert">
        <strong>Please fix the following:</strong>
        <ul class="mb-0 mt-1" style="padding-left:18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="upload-alert-error mb-4" role="alert">
        {{ session('error') }}
    </div>
@endif

{{-- UPLOAD FORM --}}
<div class="upload-card">
    <form action="{{ url('user/save_notes') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
        @csrf

        <div class="upload-form-grid">

            {{-- TITLE --}}
            <div class="upload-field full-width">
                <label for="note-title" class="upload-label">Note Title <span class="text-danger">*</span></label>
                <input
                    type="text"
                    id="note-title"
                    name="title"
                    class="upload-input @error('title') is-invalid @enderror"
                    placeholder="e.g. Chapter 5 – Thermodynamics"
                    maxlength="150"
                    value="{{ old('title') }}"
                    required
                >
                <div class="upload-hint">Max 150 characters</div>
            </div>

            {{-- CATEGORY --}}
            <div class="upload-field">
                <label for="category" class="upload-label">Category <span class="text-danger">*</span></label>
                <select name="cat_id" id="category" class="upload-input @error('cat_id') is-invalid @enderror" required>
                    <option value="">Select Category</option>
                    @foreach($category as $c)
                        <option value="{{ $c->id }}" {{ old('cat_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->cat_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SUBJECT --}}
            <div class="upload-field">
                <label for="subject" class="upload-label">Subject <span class="text-danger">*</span></label>
                <select name="sub_id" id="subject" class="upload-input @error('sub_id') is-invalid @enderror" required disabled>
                    <option value="">Select Subject</option>
                </select>
                <div class="upload-hint">Choose a category first</div>
            </div>

            {{-- FILE UPLOAD --}}
            <div class="upload-field full-width">
                <label class="upload-label">Upload File(s)</label>
                <label for="file-input" class="file-drop-zone">
                    <div class="file-drop-icon">📁</div>
                    <div class="file-drop-text">Click to choose files</div>
                    <div class="file-drop-hint">PDF, Word, Excel, PowerPoint — multiple allowed</div>
                    <input type="file" id="file-input" name="file[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" hidden>
                </label>
                <div id="file-names" class="upload-hint mt-1"></div>
            </div>

            {{-- YOUTUBE TOGGLE --}}
            <div class="upload-field full-width">
                <div class="upload-toggle-row">
                    <input type="checkbox" id="addYT" class="upload-checkbox">
                    <label for="addYT" class="upload-label mb-0" style="cursor:pointer;">
                        Add YouTube links?
                    </label>
                </div>

                <div id="yt-section" style="display:none;" class="mt-3">
                    <div id="yt-container">
                        <div class="yt-row d-flex gap-2 mb-2">
                            <input
                                type="url"
                                name="youtube_links[]"
                                class="upload-input flex-grow-1"
                                placeholder="https://www.youtube.com/watch?v=..."
                                pattern="https?://(www\.)?(youtube\.com|youtu\.be)/.+"
                                title="Please enter a valid YouTube URL"
                            >
                            <button type="button" class="yt-remove-btn" onclick="removeYtField(this)" title="Remove">✕</button>
                        </div>
                    </div>
                    <button type="button" class="yt-add-btn" onclick="addYtField()">+ Add Another Link</button>
                </div>
            </div>

            {{-- PRIVACY --}}
            <div class="upload-field full-width">
                <div class="upload-toggle-row">
                    <input type="checkbox" name="is_private" value="1" id="private" class="upload-checkbox"
                        {{ old('is_private') ? 'checked' : '' }}>
                    <label for="private" class="upload-label mb-0" style="cursor:pointer;">
                        Make this note private
                    </label>
                </div>
                <div class="upload-hint mt-1">Private notes require an access code to view</div>
            </div>

        </div>

        <div class="mt-4">
            <button type="submit" class="btn-upload-submit">Upload Note</button>
        </div>

    </form>
</div>

{{-- ACCESS CODE MODAL --}}
@if(session('access_code'))
<div class="modal fade" id="codeModal" tabindex="-1" aria-labelledby="codeModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:14px; border:none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="codeModalLabel">🔐 Private Note Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="text-muted mb-3" style="font-size:13px;">
                    Share this code with others so they can access your private note.
                </p>
                <div class="access-code-box">
                    <span id="codeText">{{ session('access_code') }}</span>
                </div>
                <button
                    class="btn-copy-code mt-3"
                    onclick="copyCode()"
                    id="copyBtn">
                    Copy Code
                </button>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

<style>
.upload-card {
    background: white;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    padding: 28px;
}
.upload-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}
.upload-field.full-width { grid-column: 1 / -1; }

.upload-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}
.upload-input {
    width: 100%;
    padding: 9px 12px;
    font-size: 13px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: #f9fafb;
    color: #111827;
    transition: 0.2s;
    outline: none;
}
.upload-input:focus {
    border-color: #6366f1;
    background: white;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
}
.upload-hint {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 4px;
}

/* File drop */
.file-drop-zone {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    padding: 24px;
    cursor: pointer;
    background: #fafafa;
    transition: 0.2s;
    text-align: center;
}
.file-drop-zone:hover { border-color: #6366f1; background: #eef2ff; }
.file-drop-icon { font-size: 28px; }
.file-drop-text { font-size: 13px; font-weight: 600; color: #374151; }
.file-drop-hint { font-size: 11px; color: #9ca3af; }

/* Toggle row */
.upload-toggle-row { display: flex; align-items: center; gap: 10px; }
.upload-checkbox {
    width: 16px; height: 16px;
    accent-color: #6366f1;
    cursor: pointer;
}

/* YouTube */
.yt-remove-btn {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    border-radius: 6px;
    padding: 6px 10px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    flex-shrink: 0;
    transition: 0.2s;
}
.yt-remove-btn:hover { background: #dc2626; color: white; }

.yt-add-btn {
    background: none;
    border: 1px dashed #9ca3af;
    color: #6366f1;
    font-size: 12px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s;
}
.yt-add-btn:hover { border-color: #6366f1; background: #eef2ff; }

/* Submit */
.btn-upload-submit {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: white;
    font-size: 14px;
    font-weight: 700;
    padding: 12px 36px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(99,102,241,0.3);
    transition: 0.2s;
}
.btn-upload-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(99,102,241,0.4);
}

/* Access code modal */
.access-code-box {
    display: inline-block;
    background: #f0fdf4;
    border: 2px dashed #34d399;
    border-radius: 10px;
    padding: 16px 32px;
    font-size: 26px;
    font-weight: 800;
    color: #065f46;
    letter-spacing: 4px;
}
.btn-copy-code {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 24px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}
.btn-copy-code:hover { opacity: 0.9; }

.upload-alert-error {
    background: #fee2e2;
    border: 1px solid #f87171;
    color: #b91c1c;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
}

@media (max-width: 576px) {
    .upload-form-grid { grid-template-columns: 1fr; }
    .upload-field.full-width { grid-column: unset; }
}
</style>

<script>
    // CATEGORY → SUBJECT AJAX
    document.getElementById('category').addEventListener('change', function () {
        const catId = this.value;
        const subjectSelect = document.getElementById('subject');

        subjectSelect.innerHTML = '<option value="">Select Subject</option>';
        subjectSelect.disabled = !catId;

        if (!catId) return;

        $.ajax({
            url: '{{ url("user/getSubjects") }}/' + catId,
            type: 'GET',
            success: function (data) {
                data.forEach(function (sub) {
                    subjectSelect.innerHTML += `<option value="${sub.id}">${sub.sub_name}</option>`;
                });
            },
            error: function () {
                alert('Could not load subjects. Please try again.');
            }
        });
    });

    // YOUTUBE TOGGLE
    document.getElementById('addYT').addEventListener('change', function () {
        const section = document.getElementById('yt-section');
        section.style.display = this.checked ? 'block' : 'none';
    });

    // ADD YOUTUBE FIELD
    function addYtField() {
        const div = document.createElement('div');
        div.className = 'yt-row d-flex gap-2 mb-2';
        div.innerHTML = `
            <input type="url" name="youtube_links[]"
                class="upload-input flex-grow-1"
                placeholder="https://www.youtube.com/watch?v=..."
                pattern="https?://(www\\.)?(youtube\\.com|youtu\\.be)/.+"
                title="Please enter a valid YouTube URL">
            <button type="button" class="yt-remove-btn" onclick="removeYtField(this)" title="Remove">✕</button>
        `;
        document.getElementById('yt-container').appendChild(div);
    }

    // REMOVE YOUTUBE FIELD
    function removeYtField(btn) {
        const rows = document.querySelectorAll('.yt-row');
        if (rows.length > 1) {
            btn.closest('.yt-row').remove();
        } else {
            // only one row — just clear it
            btn.closest('.yt-row').querySelector('input').value = '';
        }
    }

    // SHOW SELECTED FILE NAMES
    document.getElementById('file-input').addEventListener('change', function () {
        const names = Array.from(this.files).map(f => f.name);
        document.getElementById('file-names').textContent = names.length
            ? '✓ ' + names.join(', ')
            : '';
    });

    // COPY ACCESS CODE
    function copyCode() {
        const code = document.getElementById('codeText').innerText;
        navigator.clipboard.writeText(code).then(function () {
            const btn = document.getElementById('copyBtn');
            btn.textContent = '✓ Copied!';
            setTimeout(() => { btn.textContent = 'Copy Code'; }, 2000);
        });
    }

    // SHOW MODAL IF ACCESS CODE EXISTS
    @if(session('access_code'))
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('codeModal'));
        modal.show();
    });
    @endif
</script>

@endsection