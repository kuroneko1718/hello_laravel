<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">Weibo App</a>
        <ul class="navbar-nav justify-content-end">
            @if(Auth::check())
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">用户列表</a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expended="false">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a href="{{ route('users.show', Auth::user()) }}" class="dropdown-item">个人中心</a>
                    <a href="{{ route('users.edit', Auth::user()) }}" class="dropdown-item">编辑资料</a>
                    <!-- <a href="#" class="dropdown-item"></a> -->
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" id="logout">
                        <form action="{{ route('logout') }}" method="GET">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-block btn-danger" name="button">退出登录</button>
                        </form>
                    </a>
                </div>
            </li>
            @else
            <li class="nav-item"><a href="{{ route('help') }}" class="nav-link">帮助</a></li>
            <!-- <li class="nav-item"><a href="/help" class="nav-link">帮助</a></li> -->
            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">登录</a></li>
            @endif
        </ul>
    </div>
</nav>
