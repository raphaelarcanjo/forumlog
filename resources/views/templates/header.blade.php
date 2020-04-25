@include('templates.head')
<body>

<div id="app">

<header>
    <nav>
        <div class="nav-wrapper">
            <a href="{{url('forumlog/')}}" class="brand-logo">
                <img src="{{asset('img/logo-rgba.png')}}" alt="ForumLog">
            </a>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>

            <ul id="nav-desktop" class="right hide-on-med-and-down">
                <li class="@if ($title == 'Home') active @endif"><a href="{{url('forumlog/')}}">Home</a></li>
                <li class="@if ($title == 'Forum') active @endif"><a href="{{url('forumlog/forum')}}">Forum</a></li>
                <li class="@if ($title == 'Blog') active @endif"><a href="{{url('forumlog/blog')}}">Blog</a></li>
                <li class="@if ($title == 'Sobre') active @endif"><a href="{{url('forumlog/about')}}">Sobre</a></li>
                <li class="teal">
                    <a href="#modalLogin" class="modal-trigger">
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    
    <ul id="nav-mobile" class="sidenav">
        <li class="@if ($title == 'Home') active @endif"><a href="{{url('forumlog/')}}">Home</a></li>
        <li class="@if ($title == 'Forum') active @endif"><a href="{{url('forumlog/forum')}}">Forum</a></li>
        <li class="@if ($title == 'Blog') active @endif"><a href="{{url('forumlog/blog')}}">Blog</a></li>
        <li class="@if ($title == 'Sobre') active @endif"><a href="{{url('forumlog/about')}}">Sobre</a></li>
        <li>
            <a href="#!" class="dropdown-trigger" data-target="dropdownLogin">
                Login<i class="material-icons right">arrow_drop_down</i>
            </a>
        </li>
    </ul>

    <ul id="dropdownLogin" class="dropdown-content">
        <li>
            <div class="container">
                <h4>Login</h4>
                <form action="{{url('forumlog/user/login')}}" method="post">
                    <div class="input-field">
                        <input type="text" id="login" name="login" class="validate" required />
                        <label for="login">Login</label>
                    </div>
                    <div class="input-field">
                        <input type="password" id="password" name="password" class="validate" required />
                        <label for="password">Senha</label>
                    </div>
                    <div class="input-field">
                        <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                        <a href="{{url('forumlog/user/register')}}" class="waves-effect waves-light btn">Cadastre-se</a>
                    </div>
                    <a href="{{url('forumlog/user/recover')}}" class="waves-effect btn-flat">Esqueci a senha</a>
                </form>
            </div>
        </li>
    </ul>

    <div id="modalLogin" class="modal">
        <div class="modal-content">
            <h4>Login</h4>
            <form action="{{url('forumlog/user/login')}}" method="post">
                <div class="input-field">
                    <label for="loginM">Login</label>
                    <input type="text" name="login" id="loginM" class="validate" required />
                </div>
                <div class="input-field">
                    <label for="passwordM">Senha</label>
                    <input type="password" name="password" id="passwordM" class="validate" required />
                </div>
                <div class="input-field">
                    <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                    <a href="{{url('forumlog/user/register')}}" class="waves-effect waves-light btn">Cadastre-se</a>
                </div>
                <a href="{{url('forumlog/user/recover')}}" class="waves-effect btn-flat">Esqueci a senha</a>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-light red btn">Cancelar</a>
        </div>
    </div>
    @yield('header')
</header>

<div class="container">
    <main>
        @yield('content')