<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="{{url('save_category')}}">
        @csrf
        Enter category name: <input type="text" name="cat_name"><br><br>
        <button type="submit">Add</button>
    </form>
</body>
</html>