<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Admin login</h1>
    <form method="post" action="">
        @csrf
        <input name="username">
        <input name="password">
        <input type="submit" value="Login">
    </form>
</body>
</html>