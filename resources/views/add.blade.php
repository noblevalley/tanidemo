<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Hello</title>
</head>
<body>
<h1>画像ファイルパスを送信する</h1>
 
<form action="{{ url('/result')}}" method="POST">
    {{ csrf_field() }}
    <div><textarea cols="100" name="image_path"></textarea></div>
    <div><input type="submit" name="add"></div>
</form>
 
</body>
</html>