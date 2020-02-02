<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<form method="POST" action="/test">
    <input type="submit" value="Тест POST">
</form>

<form method="POST" action="/test">
    <input type="hidden" name="_method" value="PUT">
    <input type="submit" value="Тест PUT">
</form>

<form method="POST" action="/test">
    <input type="hidden" name="_method" value="DELETE">
    <input type="submit" value="Тест DELETE">
</form>

</body>
</html>
