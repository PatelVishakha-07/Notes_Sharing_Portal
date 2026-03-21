<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="{{url('save_subject')}}">
        @csrf
        Enter Subject name: <input type="text" name="sub_name"><br><br>
        <select name="cat_id">
            <option></option>
            @foreach($category as $c)
                <option value="{{$c->id}}">{{$c->cat_name}}</option>
            @endforeach 
        </select><br><br>

        <button type="submit">Add</button>
    </form>
</body>
</html>