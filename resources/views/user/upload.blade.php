@extends('layouts.user_layout')

@section("content")

<h3>Upload Note</h3><br>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul style="margin:0; padding-left:18px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ url('user/save_notes') }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- Title --}}
<div class="mb-3">
    <label class="mb-1">Title</label>
    <input type="text" name="title" class="form-control" placeholder="enter title">
</div>

{{-- Category --}}
<div class="mb-3">
    <label class="mb-1">Category</label>
    <select name="cat_id" class="form-control" id="category">
        <option value="">Select Category</option>
        @foreach($category as $c)
            <option value="{{ $c->id }}">{{ $c->cat_name }}</option>
        @endforeach
    </select>
</div>

{{-- Subject --}}
<div class="mb-3">
    <label class="mb-1">Subject</label>
    <select name="sub_id" class="form-control" id="subject" disabled>
        <option value="">Select Subject</option>
    </select>
</div>

{{-- pdf / images Upload --}}
<div class="mb-3">
    <label>Upload File</label>
    <input type="file" name="file[]" class="form-control" multiple>
</div>

{{-- ASK USER --}}
<div class="mb-3">
    <input type="checkbox" id="addYT">
    <label for="addYT">Do you want to add YouTube links?</label>
</div>

{{-- YOUTUBE SECTION --}}
<div id="yt-section" style="display:none;">
    <div class="mb-3">
        <label class="mb-1">Add YouTube Links</label>

        <div id="yt-container">
            <div class="d-flex mb-2">
                <input type="text" name="youtube_links[]" class="form-control" placeholder="Paste YouTube link">
                <button type="button" class="btn btn-danger ms-2" onclick="removeField(this)">X</button>
            </div>
        </div>

        <button type="button" class="btn btn-secondary btn-sm" onclick="addField()">+ Add More</button>
    </div>
</div>

{{-- Private/public --}}
<div class="mb-3">
    <label class="mb-1">Do you want to keep the notes private?</label><br>
    <input type="checkbox" name="is_private" value="1" id="private">
    <label for="private">Private</label>
</div>

<button class="btn btn-primary">Upload</button>

</form>

<!-- Modal to display private code-->
<div class="modal fade" id="codeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Private Note Code</h5>
      </div>

      <div class="modal-body text-center">
        <p>Share this code with others to access the file</p>

        <h3 id="codeText" class="text-success fw-bold">{{ session('access_code') }}</h3>

        <button class="btn btn-primary mt-2" onclick="copyCode()">Copy Code</button>
      </div>

    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    // CATEGORY → SUBJECT
    $('#category').change(function(){
        var cat_id = $(this).val();

        if(cat_id){
            $.ajax({
                url: '{{ url("user/getSubjects") }}/' + cat_id,
                type: 'GET',
                success: function(data){
                    $('#subject').empty().append('<option value="">Select Subject</option>');

                    data.forEach(function(sub){
                        $('#subject').append(
                            '<option value="'+sub.id+'">'+sub.sub_name+'</option>'
                        );
                    });
                }
            });
        } else {
            $('#subject').empty().append('<option value="">Select Subject</option>');
        }

        $('#subject').prop('disabled', false);
    });

    // TOGGLE YOUTUBE SECTION
    $('#addYT').change(function(){
        if($(this).is(':checked')){
            $('#yt-section').slideDown();
        } else {
            $('#yt-section').slideUp();
        }
    });

    // ADD FIELD
    function addField(){
        $('#yt-container').append(`
            <div class="d-flex mb-2">
                <input type="text" name="youtube_links[]" class="form-control" placeholder="Paste YouTube link">
                <button type="button" class="btn btn-danger ms-2" onclick="removeField(this)">X</button>
            </div>
        `);
    }

    // REMOVE FIELD
    function removeField(btn){
        $(btn).parent().remove();
    }

    // COPY CODE
    function copyCode(){
        let code = document.getElementById("codeText").innerText;
        navigator.clipboard.writeText(code);
        alert("Code copied!");
    }

    // SHOW MODAL
    @if(session('access_code'))
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('codeModal'));
        myModal.show();
    });
    @endif    

</script>

@endsection