<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header>
        <a href="/">Admins</a>
        <a href="/users">Users</a>
        <a href="/games">Games</a>
    </header>
    <div class="w-4/5 mx-auto">
        @yield('content')
    </div>
</body>

</html>