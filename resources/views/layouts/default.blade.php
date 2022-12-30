<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Weibo App') -- Laravel 入门教程</title>
    <!-- <link rel="stylesheet" href="public/css/app.css"> -->
    <!-- 配合mix工具，自动引用hash文件名编译生成的静态css文件 -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!-- npm run watch-poll -->
</head>
<body>
    @include('layouts._header')
    
    <div class="container">
        <div class="offset-md-1 col-md-10">
            @include('shared._messages')
            @yield('content')
            @include('layouts._footer')
        </div>
    </div>

    <!-- 配合mix工具，自动引用hash文件编译生成的静态js文件 -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>