<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Weibo App') -- Laravel 入门教程</title>
    <!-- <link rel="stylesheet" href="public/css/app.css"> -->
    <!-- 配合mix工具，自动引用hash文件名生成的静态文件 -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!-- npm run watch-poll -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="/" class="navbar-brand">Weibo App</a>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item"><a href="/help" class="nav-link">帮助</a></li>
                <li class="nav-item"><a href="#" class="nav-link">登录</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        @yield('content')
    </div>
</body>
</html>