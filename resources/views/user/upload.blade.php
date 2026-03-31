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
    <input type="file" name="file" class="form-control">
</div>

<div class="mb-3">
    <label class="mb-1">Visibility</label>
    <select name="visibility" class="form-control">
        <option value="public">Public</option>
        <option value="private">Private</option>
    </select>
</div>

<button class="btn btn-primary">Upload</button>

</form>

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
</script>

@endsection