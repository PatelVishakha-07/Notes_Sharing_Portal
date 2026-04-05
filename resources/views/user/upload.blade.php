@extends('layouts.user_layout')

@section("content")

<h3>Upload Note</h3><br>

<form action="{{ url('user/save_notes') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
    <label class="mb-1">Title</label>
    <input type="text" name="title" class="form-control" placeholder="enter title">
</div>

<div class="mb-3">
    <label class="mb-1">Category</label>
    <select name="cat_id" class="form-control" id="category">
        <option value="">Select Category</option>
        @foreach($category as $c)
            <option value="{{ $c->id }}">{{ $c->cat_name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="mb-1">Subject</label>
    <select name="sub_id" class="form-control" id="subject" disabled>
        <option value="">Select Subject</option>
    </select>
</div>

<div class="mb-3">
    <label>Upload File</label>
    <input type="file" name="file[]" class="form-control" multiple accept="">
</div>

<div class="mb-3">
    <label class="mb-1">Do you want to keep the notes private?</label><br>

    <input type="checkbox" name="is_private" value="1" id="private">
    <label for="private">Private</label>
</div>

<button class="btn btn-primary">Upload</button>

</form>


<!-- Access Code Modal -->
<div class="modal fade" id="codeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Private Note Code</h5>
      </div>

      <div class="modal-body text-center">
        <p>Share this code with others to access the file</p>

        {{-- <h3 id="codeText">{{ session('access_code') }}</h3> --}}
        <h3 id="codeText" class="text-success fw-bold">{{ session('access_code') }}</h3>

        <button class="btn btn-primary mt-2" onclick="copyCode()">Copy Code</button>
      </div>

    </div>
  </div>
</div>


{{-- JavaScript code --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#category').change(function(){
        var cat_id = $(this).val();

        if(cat_id){
            $.ajax({
                url: '{{ url("user/getSubjects") }}/' + cat_id,
                type: 'GET',
                success: function(data){
                    $('#subject').empty();
                    $('#subject').append('<option value="">Select Subject</option>');

                    data.forEach(function(sub){
                        $('#subject').append(
                            '<option value="'+sub.id+'">'+sub.sub_name+'</option>'
                        );
                    });
                }
            });
        } else {
            $('#subject').empty();
            $('#subject').append('<option value="">Select Subject</option>');
        }
        $('#subject').prop('disabled', false);
    });

    // popup box for access code

    function copyCode(){
        let code = document.getElementById("codeText").innerText;
        navigator.clipboard.writeText(code);
        alert("Code copied!");
    }

    @if(session('access_code'))
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('codeModal'));
        myModal.show();
    });
    @endif

</script>


@endsection